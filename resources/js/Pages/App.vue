<template>
  <div id="app-window">
    <!--        <date-picker :multiple="true"></date-picker>-->
    <!--        <date-picker :multiple="false"></date-picker>-->
    <Navbar :bus="bus" />
    <Navigation :user="user.name" :bus="bus" />
    <GroupView :groups="group_obj" />
  </div>
</template>

<script>
import Navigation from "@/Pages/Navigation/Navigation";
import GroupView from "@/Pages/Group/GroupView";
import DatePicker from "@/Pages/Dialog/DatePicker";
import Navbar from "@/Pages/Navigation/Navbar";

import Vue from "vue";
import PubNub from "pubnub";
import axios from "axios";

export default {
  name: "App",
  components: {
    Navigation,
    Navbar,
    GroupView,
    DatePicker,
  },
  props: {
    user: Object,
    groups: Array,
    chats: Array,
  },
  data() {
    return {
      bus: new Vue(),
      uuid: undefined,
      messages: [],
      group_obj: this.getGroups(),
    };
  },
  mounted() {
    this.initStore();
    this.pubnubAddListener();
    this.pubnubSubscribe();
  },
  methods: {
    initStore() {
      this.$store.commit("setState", {
        pubnub: new PubNub({
          publishKey: this.getPublishKey(),
          subscribeKey: this.getSubscribeKey(),
          uuid: this.getUUID(),
        }),
        user: {
          username: this.getUsername(),
          uuid: this.user.uuid,
          settings: {
            darkmode: false,
          },
        },
        groups: this.getGroups(),
      });

      this.getAllMissedMessagesFromPubNub();
    },
    pubnubAddListener() {
      this.$store.state.pubnub.addListener({
        message: (event) => {
          console.log("Received message Event from PubNub!");
          this.$store.commit("addMessage", {
            message: event,
          });
        },
      });
    },
    pubnubSubscribe() {
      this.$store.state.pubnub.subscribe({
        channels: this.$store.getters.getAllChannelUuids,
        withPresence: true,
      });
    },
    getMessagesFromLocalStorage(channel) {
      return JSON.parse(localStorage.getItem(channel)) || {};
    },
    saveMessagesToLocalStorage(group, chat, channel) {
      localStorage.setItem(
        channel,
        JSON.stringify(this.$store.getters.getChannel(group, chat).messages)
      );
    },
    getUUID() {
      if (!this.uuid) {
        this.uuid = this.generateUUID();
      }
      return this.uuid;
    },
    getAllMissedMessagesFromPubNub() {
      Object.keys(this.$store.state.groups).forEach((group) => {
        Object.keys(this.$store.state.groups[group].channels).forEach(
          (chat) => {
            let channel = this.$store.state.groups[group].channels[chat];
            let messageValues = Object.values(channel.messages);
            if (messageValues.length > 0) {
              this.getMissedMessagesFromPubNub(
                group,
                chat,
                channel.uuid,
                messageValues[messageValues.length - 1].timetoken
              );
            }
          }
        );
      });
    },

    getMissedMessagesFromPubNub(
      group,
      chat,
      channel,
      endTimetoken,
      startTimetoken
    ) {
      this.$store.state.pubnub.fetchMessages(
        {
          channels: [channel],
          start: startTimetoken,
          end: endTimetoken,
          count: 25, // default/max is 25
        },
        function (status, response) {
          let newMessages = Object.values(response.channels)[0];

          this.messages = this.messages.concat(newMessages);

          let currentTimetoken = newMessages[0].timetoken;

          if (currentTimetoken !== endTimetoken) {
            this.getMissedMessagesFromPubNub(
              group,
              chat,
              channel,
              endTimetoken,
              currentTimetoken
            );
            return;
          }

          this.messages.sort((a, b) => {
            if (parseInt(a.timetoken) > parseInt(b.timetoken)) {
              return 1;
            }
            if (parseInt(a.timetoken) < parseInt(b.timetoken)) {
              return -1;
            }
            return 0;
          });

          this.messages.forEach((message) => {
            Vue.set(
              this.$store.state.groups[group].channels[chat].messages,
              message.timetoken,
              message
            );
          });

          this.saveMessagesToLocalStorage(group, chat, channel);
          this.messages = [];
        }
      );

      // store.state.pubnub.fetchMessages(
      //     {
      //         channels: [channel],
      //         start: startTimetoken,
      //         end: endTimetoken,
      //         count: 1 // default/max is 25
      //     },
      //     function (status, response) {
      //         let messages = Object.values(response.channels)[0];
      //         messages.forEach(message => {
      //             Vue.set(store.state.groups[group].channels[chat].messages, message.timetoken, message);
      //         });
      //         console.log(messages)
      //         console.log(messages[messages.length-1].timetoken);
      //         console.log(endTimetoken);
      //         let currentTimetoken = messages[messages.length-1].timetoken;
      //         if (currentTimetoken !== endTimetoken) {
      //             getMissedMessagesFromPubNub(group, chat, channel, endTimetoken, currentTimetoken)
      //         }
      //         saveMessagesToLocalStorage(group, chat, channel);
      //     }
      // )
    },
    generateUUID() {
      return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(
        /[xy]/g,
        function (c) {
          let r = (Math.random() * 16) | 0,
            v = c == "x" ? r : (r & 0x3) | 0x8;
          return v.toString(16);
        }
      );
    },

    //TODO aus der Datenbank holen
    getPublishKey() {
      return "pub-c-3b6e9ed9-1191-4e64-a5b8-c835f42b776f";
    },

    //TODO aus der Datenbank holen
    getSubscribeKey() {
      return "sub-c-d87417d8-157a-11eb-a3e5-1aef4acbe547";
    },
    getUsername() {
      return this.user.name;
    },

    getUrlFromName(name) {
      return name.toLowerCase().replace(" ", "-");
    },

    toObject(array) {
      let obj = {};
      array.forEach((element) => {
        // console.log(element[Object.keys(element)[0]]);
        obj[Object.keys(element)[0]] = element[Object.keys(element)[0]];
      });
      // console.log(obj);
      return obj;
    },

    //TODO aus der Datenbank holen
    getGroups() {
      let groups = this.toObject(this.groups);
      Object.keys(groups).forEach((group) => {
        groups[group].channels.allgemein.messages = {};
        groups[group].channels.wichtig.messages = {};
      });
      return groups;
    },
  },
  computed: {
    darkmode: function () {
      //console.log(this.$store.state.user.settings.darkmode);
      return this.$store.state.user.settings.darkmode;
    },
  },
  watch: {
    darkmode: function (darkmode) {
      let root = document.documentElement;
      let isDarkmode = root.classList.contains("darkmode");
      if (isDarkmode && !darkmode) {
        root.classList.remove("darkmode");
      } else if (!isDarkmode && darkmode) {
        root.classList.add("darkmode");
      }
    },
  },
};
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Montserrat&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap");

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  transition: all 0.15s ease;
}

:root {
  --primary: #ffa88e;
  --primary-darker: #ff8f6e;

  --secondary-lighter: #ffdbb1;
  --secondary: #ffcb8e;
  --secondary-darker: #ffb561;

  --warn: #fc6b6b;
  --warn-darker: #ef5252;

  --black: #000000;
  --dark-grey: #2c2f33;
  --semi-dark-grey: #505050;
  --mid-grey: #e1e1e1;
  --light-grey: #f3f3f3;
  --white: #ffffff;
}

html {
  --background-color: var(--white);
  --background-color-alternate: var(--light-grey);
  --font-color: var(--black);
  --font-color-alternate: var(--white);
  --header-color: var(--dark-grey);
}

html.darkmode {
  --background-color: var(--semi-dark-grey);
  --background-color-alternate: var(--dark-grey);
  --font-color: var(--white);
  --font-color-alternate: var(--black);
  --header-color: var(--white);
}

#app-window {
  width: 100vw;
  height: 100vh;

  display: flex;
  flex-direction: row;

  font-family: "Montserrat", sans-serif;
}

.headline {
  color: #707070;
  font-size: 1.8rem;
  font-weight: 700;
}

.title {
  color: #ffcb8e;
  font-size: 1.8rem;
  font-weight: 700;
}

.round-btn {
  display: flex;
  justify-content: center;
  align-items: center;

  width: 3rem;
  height: 3rem;
  font-size: 1.5rem;
  border-radius: 1.5rem;
  outline: 0;
}

.round-btn.mini {
  width: 1.5rem;
  height: 1.5rem;
  font-size: 0.75rem;
}

.btn {
  width: 100%;
  /*flex-grow: 1;*/
  height: 3rem;
  font-size: 1rem;
  font-weight: 600;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  border-radius: 1.5rem;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  user-select: none;
}

.btn i {
  font-size: 1.5rem;
}

.input {
  font-size: 1rem;
  outline: 0;
  border-radius: 1.5rem;
  color: #707070;
  font-weight: 600;

  padding-left: 1.5rem;
  padding-right: 1.5rem;
  height: 3rem;
  background-color: #e1e1e1;
}

.input::placeholder {
  color: #707070;
}

.input.disabled {
  cursor: default;
  pointer-events: none;
}

.warn-background {
  background-color: var(--warn);
  transition: 0.2s ease;
  cursor: pointer;
  color: white;
}

.primary-background {
  background-color: var(--primary);
  transition: 0.2s ease;
  cursor: pointer;
  color: white;
}

.secondary-background {
  background-color: var(--secondary);
  transition: 0.2s ease;
  cursor: pointer;
  color: white;
}

.warn-background.disabled {
  pointer-events: none;
  cursor: default;
  filter: saturate(0.3);
}

.primary-background.disabled {
  pointer-events: none;
  cursor: default;
  filter: saturate(0.3);
}

.secondary-background.disabled {
  pointer-events: none;
  cursor: default;
  filter: saturate(0.3);
}

.warn-background:hover {
  background-color: var(--warn-darker);
}

.primary-background:hover {
  background-color: var(--primary-darker);
}

.secondary-background:hover {
  background-color: var(--secondary-darker);
}
</style>

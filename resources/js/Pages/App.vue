<template>
    <div id="app">
        <group-view :groups="group_obj"/>
    </div>
</template>

<script>
import GroupView from "@/Pages/Group/GroupView";
import DatePicker from "@/Pages/Dialog/DatePicker";

import Vue from "vue";
import PubNub from "pubnub";
import axios from "axios";

export default {
    name: "App",
    components: {
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
                    uuid: this.user.uuid,
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

            this.getAllMessagesFromLocalStorage();
            this.getAllMissedMessagesFromPubNub();
        },
        pubnubAddListener() {
            this.$store.state.pubnub.addListener({
                message: (event) => {
                    this.$store.commit("addMessage", {
                        message: event,
                    });
                },
                messageAction: (event) => {
                    let value = JSON.parse(event.data.value);

                    switch (event.data.type) {
                        case "poll":
                            this.$store.commit("addPollMessageAction", {
                                group: value.group,
                                chat: value.chat,
                                channel: value.channel,
                                user: value.user,
                                messageTimetoken: event.data.messageTimetoken,

                                // Poll specific
                                answerKey: value.answerKey,
                            });
                            break;
                    }
                },
            });
        },
        pubnubSubscribe() {
            this.$store.state.pubnub.subscribe({
                channels: this.$store.getters.getAllChannelUuids,
                withPresence: true,
            });
        },
        getAllMessagesFromLocalStorage() {
            Object.keys(this.$store.state.groups).forEach((group) => {
                Object.keys(this.$store.state.groups[group].channels).forEach(
                    (chat) => {
                        let channel = this.$store.state.groups[group].channels[chat].uuid;
                        let messages = this.getMessagesFromLocalStorage(channel);

                        Object.keys(messages).forEach((timetoken) => {
                            Vue.set(
                                this.$store.state.groups[group].channels[chat].messages,
                                timetoken,
                                messages[timetoken]
                            );
                        });
                    }
                );
            });
        },
        getMessagesFromLocalStorage(channel) {
            return JSON.parse(localStorage.getItem(channel)) || {};
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
                    console.log("Yeet: ", status, response);
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

                    this.$store.state.methods.saveMessagesToLocalStorage(
                        group,
                        chat,
                        channel
                    );
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
            return "pub-c-b25ff12b-5bec-4fa8-b5c8-9d37331f3464";
        },

        //TODO aus der Datenbank holen
        getSubscribeKey() {
            return "sub-c-fdf66a10-6890-11eb-95b1-4ae0cccec446";
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
};
</script>


<style>
#app-window {
    display: flex;
    flex-direction: row;

    width: 100%;
    height: 100vh;
}

</style>

<template>
    <div id="app-window">
        <Navbar :bus="bus"/>
        <Navigation :bus="bus"/>
        <GroupView :groups="group_obj"/>
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
                    this.$store.commit('addMessage', {
                        message: event
                    });
                },
                messageAction: (event) => {
                    let value = JSON.parse(event.data.value);

                    switch (event.data.type) {
                        case 'poll':
                            this.$store.commit('addPollMessageAction', {
                                group: value.group,
                                chat: value.chat,
                                channel: value.channel,
                                user: value.user,
                                messageTimetoken: event.data.messageTimetoken,

                                // Poll specific
                                answerKey: value.answerKey
                            })
                            break;
                    }
                }
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

                        Object.keys(messages).forEach(timetoken => {
                            Vue.set(
                                this.$store.state.groups[group].channels[chat].messages,
                                timetoken,
                                messages[timetoken]
                            );
                        })
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

        getMissedMessagesFromPubNub(group, chat, channel, endTimetoken, startTimetoken) {
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

                    this.$store.state.methods.saveMessagesToLocalStorage(group, chat, channel);
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
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap');

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    transition: all 0.15s ease;
}

:root {
    --primary: #FFA88E;
    --primary-darker: #ff8f6e;

    --secondary-lighter: #FFDBB1;
    --secondary: #FFCB8E;
    --secondary-darker: #ffb561;

    --warn: #FC6B6B;
    --warn-darker: #ef5252;

    --black: #000000;
    --dark-grey: #2C2F33;
    --semi-dark-grey: #505050;
    --mid-grey: #E1E1E1;
    --light-grey: #F3F3F3;
    --white: #ffffff;

    --font-color-light: #707070;
}

html {
    scroll-behavior: smooth;

    --background-color: var(--white);
    --background-color-alternate: var(--light-grey);
    --alt-input-border-color: var(--dark-grey);
    --font-color: var(--black);
    --font-color-alternate: var(--white);
    --header-color: var(--dark-grey);
    --font-color-light: var(--font-color-light);
    --message-color: var(--white);
    --message-right-color: var(--secondary-lighter);
    --shadow-color: rgba(92, 86, 86, 0.3);
    --subject-color: var(--warn);
}

html.darkmode {
    --background-color: var(--semi-dark-grey);
    --background-color-alternate: var(--dark-grey);
    --alt-input-border-color: var(--mid-grey);
    --font-color: var(--white);
    --font-color-alternate: var(--black);
    --header-color: var(--white);
    --font-color-light: var(--mid-grey);
    --message-color: var(--semi-dark-grey);
    --message-right-color: var(--primary-darker);
    --shadow-color: rgb(31, 31, 31);
    --subject-color: var(--secondary);
}

#app {
    display: flex;
    flex-direction: row;

    width: 100%;
    height: 100vh;

    font-family: 'Montserrat', sans-serif;
}

.headline {
    color: var(--font-color-light);
    font-size: 1.8rem;
    font-weight: 700;
}

.title {
    color: #FFCB8E;
    font-size: 3rem;
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
    color: var(--font-color);
    font-weight: 600;

    padding-left: 1.5rem;
    padding-right: 1.5rem;
    height: 3rem;
    background-color: #F3F3F3;
}

.dialog-window .input {
    background-color: var(--background-color-alternate);
}

.textarea {
    font-size: 1rem;
    outline: 0;
    border-radius: 1.5rem;
    color: #707070;
    font-weight: 600;

    padding: 1.5rem;
    background-color: #E1E1E1;
    resize: none;
}

.input::placeholder {
    color: #707070;
}

.textarea::placeholder {
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

.row {
    display: flex;
    flex-direction: row;
    align-items: center;
    width: 100%;
}

.col {
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%;
}

.space-between {
    justify-content: space-between;
}

.flex-start {
    justify-content: flex-start;
}

/*Checkbox*/
.checkbox-container {
    margin: 1vh;
    display: flex;
    align-items: center;
    position: relative;
    padding-left: 35px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    cursor: pointer;
}

.checkbox-container input, .checkbox-container input {
    opacity: 0;
    position: absolute;
    cursor: pointer;
    height: 0;
    width: 0;
}

.checkbox {
    position: absolute;
    top: 0;
    left: 0;
    border-radius: 30%;
    height: 20px;
    width: 20px;
    background-color: var(--background-color);
    border: 2px solid var(--font-color);
}

input:checked ~ .checkbox {
    background-color: var(--primary);
    border: 2px solid var(--primary);
}

.checkbox:after {
    content: "";
    position: absolute;
    display: none;
}

input:checked ~ .checkbox:after {
    display: block;
}

.checkbox:after {
    left: 6px;
    top: 3px;
    width: 5px;
    height: 10px;
    border: solid var(--white);
    border-width: 0 3px 3px 0;
    border-radius: 1px;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}

/*Radio*/
.radio {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: var(--background-color);
    border: 2px solid var(--font-color);
    border-radius: 50%;
}

input:checked ~ .radio {
    background-color: var(--primary);
    border: 2px solid var(--primary);
}

.radio:after {
    content: "";
    position: absolute;
    display: none;
}

input:checked ~ .radio:after {
    display: block;
}

.radio:after {
    top: 3px;
    left: 3px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--white);
}

.alternate-input {
    background-color: var(--background-color-alternate);
    border: 3px solid var(--alt-input-border-color);
    border-radius: 12px;
    padding: 6px;
    color: var(--font-color);
}

.alternate-input:focus {
    outline: 0;
    border: 3px solid var(--primary);
    transition: 0.2s;
}

select option {
    color: var(--font-color);
    background-color: var(--background-color);
}

/* Vue Transitions */

.fade-enter-active, .fade-leave-active {
    transition: opacity .2s ease;
}

.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
{
    opacity: 0;
}

@media (max-width: 1200px) {
    .title {
        font-size: 2rem;
    }

    .headline {
        font-size: 1.5rem;
        margin-left: 1vh !important; /*Noch ändern!*/
    }
}

@media (max-width: 576px) {
    #app {
        flex-direction: column;
    }

    .btn i {
        display: none;
    }

    .btn {
        justify-content: center;
    }
}
</style>

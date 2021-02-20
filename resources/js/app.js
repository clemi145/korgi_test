require("./bootstrap");

// Import modules...
import Vue from "vue";
import {
    App as InertiaApp,
    plugin as InertiaPlugin
} from "@inertiajs/inertia-vue";
import Inertia from "@inertiajs/inertia";
import PortalVue from "portal-vue";

import Vuex from "vuex";
import PubNub from "pubnub";
import axios from "axios";

Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
Vue.use(Vuex);

const app = document.getElementById("app");

function generateLaravelTimestamp() {
    var d = new Date();
    var year = d.getFullYear();
    var month = ("0" + (d.getMonth() + 1)).slice(-2);
    var day = ("0" + d.getDate()).slice(-2);
    var hour = ("0" + d.getHours()).slice(-2);
    var minutes = ("0" + d.getMinutes()).slice(-2);
    var seconds = ("0" + d.getSeconds()).slice(-2);
    return (
        year +
        "-" +
        month +
        "-" +
        day +
        " " +
        hour +
        ":" +
        minutes +
        ":" +
        seconds
    );
}

function setLastMessage(groupName) {
    axios.post(route("group.get"), { groupName: groupName }).then(res => {
        axios
            .post(route("group.set"), {
                groupId: res.id,
                last_message: generateLaravelTimestamp()
            })
            .then(res => console.log(res));
    });
}

const store = new Vuex.Store({
    state: {
        pubnub: {},
        user: {
            username: "",
            uuid: "",
            settings: {
                darkmode: false
            }
        },
        groups: {}
    },
    mutations: {
        setState(state, payload) {
            Vue.set(state, "pubnub", payload.pubnub);
            Vue.set(state, "user", payload.user);
            Vue.set(state, "groups", payload.groups);
        },
        setShowArrow(state, payload) {
            state.showArrow = payload.showArrow;
        },
        setCurrentPage(state, payload) {
            state.currentPage = payload.page;
        },
        toggleDarkmode(state) {
            state.user.settings.darkmode = !state.user.settings.darkmode;
        },
        publishMessage(state, payload) {
            // console.log(payload.group);
            console.log("publish Message on: " + payload.channel.uuid);
            setLastMessage(payload.group);
            state.pubnub.publish(
                {
                    channel: payload.channel.uuid,
                    message: {
                        text: payload.message,
                        user: state.user,
                        group: payload.group,
                        chat: payload.chat,
                        messageType: "message"
                    }
                },
                (status, response) => {
                    console.log(status, response);
                }
            );
        },
        publishFile(state, payload) {
            setLastMessage(payload.group);
            state.pubnub.publish({
                channel: payload.channel,
                message: {
                    text: payload.message,
                    fileName: payload.fileName,
                    fileType: payload.fileType,
                    user: state.user,
                    group: payload.group,
                    chat: payload.chat,
                    url: payload.url,
                    messageType: "file"
                }
            });
        },
        publishEventAnnouncement(state, payload) {
            setLastMessage(payload.group);
            state.pubnub.publish({
                channel: payload.channel,
                message: {
                    text: payload.message,
                    date: payload.date,
                    user: state.user,
                    group: payload.group,
                    chat: payload.chat,
                    messageType: "eventAnnouncement"
                }
            });

            // Unnötig, wenn groups vom server kommen
            store.commit("addEvent", {
                subject: payload.message,
                date: payload.date,
                group: payload.group
            });
        },
        publishDateVoting(state, payload) {
            setLastMessage(payload.group);
            state.pubnub.publish({
                channel: payload.channel,
                message: {
                    text: payload.message,
                    options: payload.dates,
                    user: state.user,
                    group: payload.group,
                    chat: payload.chat,
                    messageType: "dateVoting"
                }
            });
        },
        addMessage(state, payload) {
            Vue.set(
                state.groups[payload.message.message.group].channels[
                    payload.message.message.chat
                ].messages,
                payload.message.timetoken,
                payload.message
            );

            document.querySelector("#message-input").value = "test";
            document.querySelector("#message-input").value = "";

            console.log("add Message");
            /*
            saveMessagesToLocalStorage(
                payload.message.message.group,
                payload.message.message.chat,
                payload.message.channel
            );
*/
        },
        addEvent(state, payload) {
            // TODO push to server

            let newEvent = {
                subject: payload.subject,
                date: payload.date
            };

            state.groups[payload.group].events.push(newEvent);
        },
        addGroup(state, payload) {
            axios.post("/gruppen", {
                name: payload.name
            });
        }
    },
    getters: {
        getUser: state => {
            return state.user;
        },
        getGroups: state => {
            return state.groups;
        },
        getGroup: state => group => {
            return state.groups[group];
        },
        getChannels: state => group => {
            return state.groups[group].channels;
        },
        getChannel: state => (group, channel) => {
            return state.groups[group].channels[channel];
        },
        getAllChannelUuids: state => {
            let uuids = [];

            Object.keys(state.groups).forEach(groupKey => {
                Object.keys(state.groups[groupKey].channels).forEach(
                    channelKey => {
                        console.log(
                            "Subscribed to channel: " +
                                state.groups[groupKey].channels[channelKey].uuid
                        );
                        uuids.push(
                            state.groups[groupKey].channels[channelKey].uuid
                        );
                    }
                );
            });

            return uuids;
        },
        getEvents: state => {
            let events = [];

            Object.values(state.groups).forEach(group => {
                group.events.forEach(event => {
                    events.push(event);
                });
            });

            return events.sort((e1, e2) => {
                if (e1.date.getTime() > e2.date.getTime()) {
                    return 1;
                }
                if (e1.date.getTime() === e2.date.getTime()) {
                    return 0;
                }
                return -1;
            });
        }
    }
});

new Vue({
    store,
    render: h =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: name => require(`./Pages/${name}`).default
            }
        })
}).$mount(app);

require('./bootstrap');

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

const app = document.getElementById('app');

function forceRerender(elem) {
    // Remove my-component from the DOM
    //this.renderComponent = false;
    elem.style.display = "none";
    console.log("messages hidden!");

    // this.$nextTick(() => {
    // Add the component back in
    // this.renderComponent = true;
    elem.style.display = "block";
    console.log("messages shown!");
    // });
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
        // addReadBy(state, payload) {
        //     Vue.set(state.groups[payload.group].channels[payload.chat].messages[payload.messageTimetoken].message.readBy, payload.user.uuid, {
        //         user: payload.user,
        //         time: payload.time
        //     });
        //     //saveMessagesToLocalStorage(payload.group, payload.chat, payload.channel)
        // },

        addPollMessageAction(state, payload) {
            Vue.set(state.groups[payload.group].channels[payload.chat].messages[payload.messageTimetoken].message.results, payload.user.uuid, payload.answerKey);
            //saveMessagesToLocalStorage(payload.group, payload.chat, payload.channel);
        },

        // TODO veröffentlichen einer allgemeinen Message Action
        publishMessageAction(state, payload) {
            state.pubnub.addMessageAction({
                channel: payload.message.channel,
                messageTimetoken: payload.message.timetoken,
                action: {
                    type: payload.type,
                    value: JSON.stringify({
                        user: state.user,
                        chat: payload.message.message.chat,
                        group: payload.message.message.group,
                        channel: payload.message.channel,
                        answerKey: payload.answerKey
                    })
                }
            })
        },

        // TODO Rename
        // addMessageAction(state, payload) {
        //     state.pubnub.addMessageAction(
        //         {
        //             channel: payload.message.channel,
        //             messageTimetoken: payload.message.timetoken,
        //             action: {
        //                 type: 'readConfirm',
        //                 value: JSON.stringify({
        //                     user: state.user,
        //                     time: new Date(),
        //                     chat: payload.message.message.chat,
        //                     group: payload.message.message.group,
        //                     channel: payload.message.channel
        //                 }),
        //             }
        //         }
        //     );
        // },
        publishPoll(state, payload) {
            state.pubnub.publish(
                {
                    channel: payload.channel,
                    message: {
                        'subject': payload.subject,
                        'user': state.user,
                        'group': payload.group,
                        'chat': payload.chat,
                        'allowMultiple': payload.allowMultiple,
                        'answers': payload.answers,
                        'results': {},
                        'messageType': 'poll'
                    }
                }
            );
        },
        publishReply(state, payload) {
            state.pubnub.publish(
                {
                    channel: payload.channel,
                    message: {
                        'text': payload.message,
                        'user': state.user,
                        'group': payload.group,
                        'chat': payload.chat,
                        'messageTimetoken': payload.messageTimetoken,
                        'messageType': 'reply'
                    }
                }
            );
        },
        publishMessage(state, payload) {
            console.log("publishMessage on: " + payload.channel);
            console.log("   group: " + payload.group)
            console.log("   chat: " + payload.chat)
            state.pubnub.publish(
                {
                    channel: payload.channel,
                    message: {
                        'text': payload.message,
                        'user': state.user,
                        'group': payload.group,
                        'chat': payload.chat,
                        'messageType': 'message'
                    }
                }
            );
        },
        publishImportantMessage(state, payload) {
            state.pubnub.publish(
                {
                    channel: payload.channel,
                    message: {
                        'text': payload.message,
                        'subject': payload.subject,
                        'user': state.user,
                        'group': payload.group,
                        'chat': payload.chat,
                        'readBy': {},
                        'messageType': 'importantMessage'
                    }
                }
            );
        },
        publishFile(state, payload) {
            state.pubnub.publish(
                {
                    channel: payload.channel,
                    message: {
                        'text': payload.message,
                        'fileName': payload.fileName,
                        'fileType': payload.fileType,
                        'user': state.user,
                        'group': payload.group,
                        'chat': payload.chat,
                        'url': payload.url,
                        'messageType': 'file'
                    }
                }
            );
        },
        publishEventAnnouncement(state, payload) {
            state.pubnub.publish(
                {
                    channel: payload.channel,
                    message: {
                        'text': payload.message,
                        'date': payload.date,
                        'user': state.user,
                        'group': payload.group,
                        'chat': payload.chat,
                        'messageType': 'eventAnnouncement'
                    }
                }
            );

            // Unnötig, wenn groups vom server kommen
            store.commit('addEvent', {
                subject: payload.message,
                date: payload.date,
                group: payload.group
            })
        },
        publishDateVoting(state, payload) {
            state.pubnub.publish(
                {
                    channel: payload.channel,
                    message: {
                        'text': payload.message,
                        'options': payload.dates,
                        'user': state.user,
                        'group': payload.group,
                        'chat': payload.chat,
                        'messageType': 'dateVoting'
                    }
                }
            );
        },
        addMessage(state, payload) {
            console.log("addMessage");
            console.log("   group: " + payload.message.message.group)
            console.log("   chat: " + payload.message.message.chat)
            Vue.set(
                state.groups[payload.message.message.group].channels[
                    payload.message.message.chat
                    ].messages,
                payload.message.timetoken,
                payload.message
            );
            //saveMessagesToLocalStorage(payload.message.message.group, payload.message.message.chat, payload.message.channel)
        },
        addEvent(state, payload) {
            // TODO push to server

            let newEvent = {
                subject: payload.subject,
                date: payload.date
            }

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
                        console.log("Subscribed to channel: " + state.groups[groupKey].channels[channelKey].uuid)
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

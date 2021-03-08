<template>
    <div id="chat">
        <div id="messages" v-if="renderComponent">
            <ChatElement
                v-for="message in Object.values(messages)"
                :key="message.timestamp"
                :message="message"
                :group="group"
                class="chat-element"
            />
        </div>
        <div id="input-group">
            <dialog-window
                :bus="fileInputBus"
                title="Datei senden"
                @submit="publishFile"
            >
                <dialog-content-send-file :bus="fileInputBus"/>
            </dialog-window>
            <dialog-window
                :bus="eventAnnouncementBus"
                title="Termin bekannt geben"
                @submit="publishEventAnnouncement"
            >
                <dialog-content-event-announcement :bus="eventAnnouncementBus"/>
            </dialog-window>
            <dialog-window
                :bus="importantMessageBus"
                title="Wichtige Nachricht senden"
                @submit="publishImportantMessage"
            >
                <dialog-content-important-message :bus="importantMessageBus"/>
            </dialog-window>
            <dialog-window
                :bus="pollBus"
                title="Umfrage starten"
                @submit="publishPoll"
            >
                <dialog-content-poll :bus="pollBus"/>
            </dialog-window>
            <transition name="fade">
                <div
                    v-show="openSpecialMessages && chat.url === 'wichtig'"
                    class="special-messages-container"
                    @click="toggleSpecialMessages"
                >
                    <div
                        class="btn primary-background"
                        v-on:click="pollBus.$emit('open')"
                    >
                        <p>Umfrage starten</p>
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div
                        class="btn primary-background"
                        v-on:click="eventAnnouncementBus.$emit('open')"
                    >
                        <p>Termin bekannt geben</p>
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div
                        class="btn primary-background"
                        v-on:click="dateVotingBus.$emit('open')"
                    >
                        <p>Terminumfrage starten</p>
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div
                        class="btn primary-background"
                        v-on:click="importantMessageBus.$emit('open')"
                    >
                        <p>Wichtige Nachricht schreiben</p>
                        <i class="far fa-calendar-alt"/>
                    </div>
                    <div
                        class="btn primary-background"
                        v-on:click="fileInputBus.$emit('open')"
                    >
                        <p>Wichtige Datei senden</p>
                        <i class="fas fa-paperclip"/>
                    </div>
                </div>
            </transition>
            <div
                class="round-btn warn-background"
                :class="hasAccess() ? '' : 'disabled'"
                v-if="chat.url === 'allgemein'"
                :disabled="!hasAccess()"
                v-on:click="fileInputBus.$emit('open')"
            >
                <i class="fas fa-paperclip"/>
            </div>
            <div
                class="round-btn warn-background"
                :class="hasAccess() ? '' : 'disabled'"
                v-if="chat.url === 'wichtig'"
                :disabled="!hasAccess()"
                v-on:click="toggleSpecialMessages"
            >
                <i class="fas fa-plus"/>
            </div>
            <!--<div>Groups: {{ Object.values($store.state.groups).length }}</div>-->
            <input
                type="text"
                class="input"
                :class="hasAccess() ? '' : 'disabled'"
                id="message-input"
                v-model="message"
                @keypress.enter="publishMessage"
                :placeholder="
          hasAccess()
            ? 'Nachricht'
            : 'Du darfst in diesem Chat leider keine Nachrichten schreiben!'
        "
            />
            <div
                class="round-btn secondary-background"
                :class="hasAccess() && message.replaceAll(' ', '').length ? '' : 'disabled'"
                v-on:click="publishMessage"
            >
                <i class="fas fa-paper-plane"/>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from "vue";

import DialogWindow from "@/Pages/Dialog/dialog-window";
import DialogContentSendFile from "@/Pages/Dialog/dialog-content-send-file";
import DialogContentEventAnnouncement from "@/Pages/Dialog/dialog-content-event-announcement";
import DatePicker from "@/Pages/Dialog/DatePicker";
import ChatElement from "@/Pages/Chat/ChatElement";
import Navbar from "@/Pages/Navigation/Navbar";
import DialogContentPoll from "@/Pages/Dialog/dialog-content-poll";
import DialogContentImportantMessage from "@/Pages/Dialog/dialog-content-important-message";
import axios from "axios";
import Files from "@/Pages/Group/Files";

export default {
    name: "Chat",
    components: {
        Files,
        DialogContentImportantMessage,
        DialogContentPoll,
        ChatElement,
        DatePicker,
        DialogWindow,
        DialogContentSendFile,
        DialogContentEventAnnouncement,
        Navbar,
    },
    props: {
        group: Object,
        chat: Object,
        hasAdminPermissions: Boolean,
    },
    data() {
        return {
            message: "",
            fileInputBus: new Vue(),
            eventAnnouncementBus: new Vue(),
            dateVotingBus: new Vue(),
            pollBus: new Vue(),
            importantMessageBus: new Vue(),
            openSpecialMessages: false,
            user: this.$store.getters.getUser,
            renderComponent: true,
        };
    },
    computed: {
        channel() {
            return this.$store.getters.getChannel(this.group.url, this.chat.url);
        },
        messages() {
            return this.channel.messages;
        },
    },
    watch: {
        messages: {
            handler() {
                let messagesElement = document.getElementById("messages");
                let scrollPercentage = Math.ceil(
                    (100 * messagesElement.scrollTop) /
                    (messagesElement.scrollHeight - messagesElement.clientHeight)
                );
                if (scrollPercentage >= 100 || isNaN(scrollPercentage)) {
                    setTimeout(() => {
                        this.scrollToBottom();
                    }, 10);
                }

            },
            deep: true,
        },
    },
    mounted() {
            this.jumpToBottom();
    },
    methods: {
        jumpToBottom() {
            let messagesElement = document.getElementById("messages");
            messagesElement.scrollTo(0, messagesElement.scrollHeight);
        },
        scrollToBottom() {
            let messagesElement = document.getElementById("messages");
            messagesElement.scrollTo({ top: messagesElement.scrollHeight, left: 0, behavior: "smooth" });
        },
        publishMessage() {
            if (this.message.replaceAll(' ', '').length) {
                this.$store.commit("publishMessage", {
                    message: this.message,
                    channel: this.chat.uuid,
                    chat: this.chat.url,
                    group: this.group.url,
                });

                this.message = "";
            }
        },
        publishImportantMessage(content) {
            this.$store.commit("publishImportantMessage", {
                subject: content.subject,
                message: content.text,
                channel: this.channel.uuid,
                chat: this.chat.url,
                group: this.group.url,
            });

            this.jumpToBottom();
        },
        publishPoll(content) {
            this.$store.commit("publishPoll", {
                subject: content.subject,
                channel: this.channel.uuid,
                chat: this.chat.url,
                group: this.group.url,
                allowMultiple: content.allowMultiple,
                answers: content.answers,
            });
        },
        publishFile(content) {
            // TODO Upload File

            const data = new FormData();
            data.append("file", content.file);
            data.append("groupId", this.group.id);
            axios
                .post(route("group.files.store"), data, {
                    headers: {
                        "content-type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    console.log(res)


                });
            this.$store.commit("publishFile", {
                message: content.message,
                channel: this.chat.uuid,
                chat: this.chat.url,
                group: this.group.url,
                fileName: content.file.name,
                fileType: content.file.type,
            });

        },
        publishEventAnnouncement(eventAnnouncement) {
            // TODO add event to group in database
            this.$store.commit("publishEventAnnouncement", {
                message: eventAnnouncement.subject,
                channel: this.chat.uuid,
                chat: this.chat.url,
                group: this.group.url,
                date: eventAnnouncement.date,
            });
        },
        hasAccess() {
            if (this.chat.url === "wichtig") {
                return this.hasAdminPermissions;
            } else {
                return true;
            }
        },
        toggleSpecialMessages() {
            this.openSpecialMessages = !this.openSpecialMessages;
        },
    },
    created() {
    },
};
</script>

<style scoped>
#chat {
    background-color: var(--background-color-alternate);
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

#messages {
    height: 100%;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    padding: 2vh;
    overflow-y: auto;
    overflow-x: hidden;
}

#messages::-webkit-scrollbar {
    margin-left: -1rem;
    width: 1rem;
}

#messages::-webkit-scrollbar-track {
    background: transparent;
    border-radius: 0.5rem;
}

#messages::-webkit-scrollbar-thumb {
    background-color: #ffa88e;
    border-radius: 0.5rem;
}

#message-input {
    margin-left: 3vh;
    margin-right: 3vh;
    flex-grow: 1;
}

#input-group {
    position: relative;
    display: flex;
    padding: 1.5vh 3vh 1.5vh 3vh;
    box-shadow: 1px 0 15px 3px var(--shadow-color);
    -webkit-box-shadow: 1px 0 15px 3px var(--shadow-color);
    -moz-box-shadow: 1px 0 15px 3px var(--shadow-color);
    justify-content: space-between;
    background-color: var(--background-color);
}

.special-messages-container {
    background-color: var(--background-color);
    margin-bottom: 2vh;
    padding: 1vh;
    height: 19rem;
    position: absolute;
    bottom: 100%;
    border-radius: 1rem;
    box-shadow: 1px 0 15px 3px var(--shadow-color);
    -webkit-box-shadow: 1px 0 15px 3px var(--shadow-color);
    -moz-box-shadow: 1px 0 15px 3px var(--shadow-color);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.15s ease;
}

.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
{
    opacity: 0;
}

@media (max-width: 576px) {
    #message-input {
        max-width: 68%; /*Irgendwie dumm, aber sonst funktioniert nix*/
        margin-left: 0.5vh;
        margin-right: 0.5vh;
    }

    #input-group {
        padding: 2% 2% 4% 2%; /*Unten mehr, damit bei Handys mit abgerundeten Ecken nix abgeschnitten wird*/
    }

    #messages::-webkit-scrollbar {
        width: 0.5rem;
    }

    .special-messages-container {
        padding: 4%;
    }
    #messages {
        padding: 0.5vh;
    }
}
</style>


<template>
  <div class="chat-element" :id="message.timetoken">
    <dialog-window :bus="messageReplyBus" title="Antworten" @submit="publishMessageReply">
      <dialog-content-message-reply :bus="messageReplyBus"/>
    </dialog-window>

    <message v-if="message.message.messageType === 'message' && message.message.chat === 'allgemein'"
             :message="message" v-on:open="messageReplyBus.$emit('open')"/>
    <important-message v-if="message.message.messageType === 'importantMessage'" :message="message"/>
    <less-important-message v-if="message.message.messageType === 'message' && message.message.chat === 'wichtig'"
                            :message="message"/>
    <file v-if="message.message.messageType === 'file'" :message="message" v-on:open="messageReplyBus.$emit('open')"/>
    <event-announcement v-if="message.message.messageType === 'eventAnnouncement'" :message="message"/>
    <poll v-if="message.message.messageType === 'poll'" :message="message"/>
    <message-reply v-if="message.message.messageType === 'reply'" :message="message" v-on:open="messageReplyBus.$emit('open')"></message-reply>
  </div>
</template>

<script>
import Message from "@/Pages/Message";
import File from "@/Pages/File";
import EventAnnouncement from "@/Pages/EventAnnouncement";
import LessImportantMessage from "@/Pages/LessImportantMessage";
import ImportantMessage from "@/Pages/ImportantMessage";
import Poll from "@/Pages/Poll";
import DialogWindow from "@/Pages/dialog-window";
import DialogContentMessageReply from "@/Pages/dialog-content-message-reply";
import Vue from "vue";
import MessageReply from "@/Pages/MessageReply";

export default {
  name: "ChatElement",
  components: {
    MessageReply,
    DialogContentMessageReply,
    DialogWindow, Poll, ImportantMessage, LessImportantMessage, EventAnnouncement, File, Message},
  props: {
    message: Object
  },
  data() {
    return {
      messageReplyBus: new Vue()
    };
  },
  methods: {
    publishMessageReply(content) {
      this.$store.commit('publishReply', {
        message: content.text,
        channel: this.message.channel,
        chat: this.message.message.chat,
        group: this.message.message.group,
        messageTimetoken: this.message.timetoken
      });
      let messagesElement = document.getElementById('messages');
      messagesElement.scrollTo(0, messagesElement.scrollHeight);
    },
  }
}
</script>

<style scoped>
.chat-element {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: flex-start;
  width: 100%;
  padding-left: 10vh;
  padding-right: 10vh;
}

@media (max-width: 576px) {
  .chat-element {
    padding-left: 4%;
    padding-right: 2%;
    margin-top: 4px;
    margin-bottom: 4px;
  }
}
</style>

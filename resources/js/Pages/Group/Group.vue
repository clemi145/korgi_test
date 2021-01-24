<template>
  <div id="group">
    <div id="group-header">
      <div class="row">
        <inertia-link
          :href="route('groups.show')"
          class="round-btn secondary-background"
          ><i class="fas fa-arrow-left"></i
        ></inertia-link>
        <inertia-link
          :href="route('group.join.show', { uuid: group.uuid })"
          style="margin-left: 2%"
          class="headline"
        >
          {{ group.name }}
        </inertia-link>

        <button v-on:click="leave" style="margin-left: 2%" class="headline">
          Leave
        </button>

        <button v-on:click="deleteGroup" style="margin-left: 2%" class="headline">
          Delete Group
        </button>

        <inertia-link
          :href="route('group.users', { url: this.group.url })"
          style="margin-left: 2%"
          class="headline"
        >
          Users
        </inertia-link>

        <inertia-link
          :href="route('group.files.show', { url: this.group.url })"
          style="margin-left: 2%"
          class="headline"
        >
          Files
        </inertia-link>
      </div>
      <div id="chat-selection">
        <button
          as="button"
          class="chat-link left"
          :class="generalIsCurrentChat()"
          v-on:click="type = false"
        >
          Allgemein
        </button>

        <button
          class="chat-link right"
          :class="importantIsCurrentChat()"
          v-on:click="type = true"
        >
          Wichtig
        </button>
      </div>
    </div>
    <Chat
      :group="group"
      :chat="chats['allgemein']"
      :hasAdminPermissions="user_is_admin"
      v-if="!type"
    />
    <Chat
      :group="group"
      :chat="chats['wichtig']"
      :hasAdminPermissions="user_is_admin"
      v-else
    />
  </div>
</template>

<script>
import Chat from "@/Pages/Chat/Chat";
import Navbar from "@/Pages/Navigation/Navbar";

import axios from "axios";

export default {
  name: "Group",
  components: {
    Chat,
    Navbar,
  },
  props: {
    group: Object,
    chats: Object,
    // chat: Object,
    user_is_admin: Boolean,
  },
  data() {
    return {
      type: false,
    };
  },
  methods: {
    deleteGroup() {
      axios
        .post(route("group.delete"), {
          uuid: this.group.uuid,
        })
        .then(() => this.$inertia.visit(route("groups.show")));
    },
    leave() {
      axios
        .post(route("group.leave"), {
          uuid: this.group.uuid,
        }) /*.then(() => {
        Object.values(this.$store.state.groups).filter((i, v, a) => {
          return v.uuid != this.group.uuid;
        });
      })*/
        .then(() => this.$inertia.visit(route("groups.show")));
    },
    generalIsCurrentChat() {
      if (!this.type) {
        //document.URL.includes("allgemein")) {
        return "chat-link-current";
      }
    },
    importantIsCurrentChat() {
      if (this.type) {
        //document.URL.includes("wichtig")) {
        return "chat-link-current";
      }
    },
  },
};
</script>

<style scoped>
#group {
  display: flex;
  flex-direction: column;
  width: 100%;
  height: 100%;
}

#group-header {
  display: flex;
  flex-direction: column;
  box-shadow: 1px 0px 15px 3px rgba(92, 86, 86, 0.75);
  -webkit-box-shadow: 1px 0px 15px 3px rgba(92, 86, 86, 0.75);
  -moz-box-shadow: 1px 0px 15px 3px rgba(92, 86, 86, 0.75);
  padding: 2% 2% 0 2%;
}

#chat-selection {
  display: flex;
  flex-direction: row;
  justify-content: center;
}

.chat-link {
  width: 6em;
  text-align: center;
  font-size: 1.2rem;
  color: #707070;
  font-weight: 600;
  transition: 0.2s ease;
}

.row {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: flex-start;
}

.chat-link:hover {
  color: #ffa88e;
}

.chat-link::after {
  content: "";
  width: 0;
  height: 4px;
  display: block;
  background-color: #ffa88e;
  transition: 0.2s ease;
}

.chat-link.left::after {
  margin-left: 100%;
}

.chat-link.right::after {
  margin-left: 0;
}

.chat-link-current {
  color: #ffa88e;
}

.chat-link-current.left::after {
  width: 100%;
  margin-left: 0;
}

.chat-link-current.right::after {
  width: 100%;
  margin-left: 0;
}

@media (max-width: 576px) {
  .row {
    display: none;
  }
}
</style>

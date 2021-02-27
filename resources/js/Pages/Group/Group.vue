<template>
    <page-layout :user="user" :groups="groups">
        <div id="group">
            <div id="group-content">
                <div id="group-header">
                    <div class="row">
                        <div style="display: flex; flex-direction: row; align-items: center; flex-grow: 1">
                            <inertia-link
                                :href="route('groups.show')"
                                class="round-btn secondary-background"
                            ><i class="fas fa-arrow-left"></i
                            ></inertia-link>
                            <div
                                style="margin-left: 2%"
                                class="headline"
                            >
                                {{ group.name }}
                            </div>
                        </div>


                        <!--inertia-link
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
                        </inertia-link-->
                        <div class="btn primary-background" @click="toggleGroupInfo">Gruppeninfo</div>
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
                    :hasAdminPermissions="group.hasAdminPermissions"
                    v-if="!type"
                />
                <Chat
                    :group="group"
                    :chat="chats['wichtig']"
                    :hasAdminPermissions="group.hasAdminPermissions"
                    v-else
                />
            </div>
            <group-info :group="group" :bus="bus" :hasAdminPermissions="group.hasAdminPermissions"/>
        </div>
    </page-layout>
</template>

<script>
import Chat from "@/Pages/Chat/Chat";
import Navbar from "@/Pages/Navigation/Navbar";
import GroupInfo from "@/Pages/Group/GroupInfo";
import Vue from "vue";
import Navigation from "@/Pages/Navigation/Navigation";
import PageLayout from "@/Layouts/PageLayout";
import StoreInitializer from "@/Pages/store-initializer";

export default {
    name: "Group",
    components: {
        StoreInitializer,
        PageLayout,
        Navigation,
        Chat,
        Navbar,
        GroupInfo,
    },
    props: {
        group: Object,
        groups: Array,
        user: Object
    },
    data() {
        return {
            type: false,
            bus: new Vue(),
            chats: this.group.channels
        };
    },
    methods: {
        toggleGroupInfo() {
            this.bus.$emit("toggleGroupInfo");
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
    created() {
        Vue.set(this.chats['wichtig'], "uuid", this.chats['wichtig'].uuid.uuid)
        Vue.set(this.chats['allgemein'], "uuid", this.chats['allgemein'].uuid.uuid)
        this.$store.commit("setCurrentPage", {page: this.group.name});
        this.$store.commit("setShowArrow", {showArrow: true});
    },
}
</script>

<style scoped>
#group {
    display: flex;
    flex-direction: row;
    width: 100%;
    height: 100%;
}

#group-content {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 100%;
}

#group-header {
    display: flex;
    flex-direction: column;
    box-shadow: 1px 0px 8px 3px var(--shadow-color);
    -webkit-box-shadow: 1px 0px 8px 3px var(--shadow-color);
    -moz-box-shadow: 1px 0px 8px 3px var(--shadow-color);
    padding: 2vh 2vh 0 2vh;
    z-index: 30;
    background-color: var(--background-color);
}

.btn {
    flex-grow: 0 !important;
    width: fit-content;
}

button:focus {
    outline: 0;
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
    color: var(--font-color-light);
    font-weight: 600;
    transition: 0.2s ease;
}

.row {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
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

    #group {
        height: calc(100vh - 20vw);
    }
}
</style>

<template>
    <div id="group-info" :class="{ active: active }">
        <dialog-window :title="'Einladungslink'" :bus="dialogBus" :info-only="true">
            <dialog-content-join-link :link="link"/>
        </dialog-window>

        <div id="group-info-header">
            <div>Gruppeninfo</div>
            <div class="round-btn secondary-background" @click="toggleActive">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div id="group-info-name">
            <div class="section-header">Name</div>
            <div class="input-container">
                <input
                    class="alternate-input"
                    :class="{'disabled': !nameInputActive}"
                    id="group-name-input"
                    type="text"
                    name="groupname"
                    value="groupname"
                    placeholder="Gruppenname"
                    v-model="groupName"
                />

                <Transition name="fade">
                    <div class="round-btn warn-background" v-if="nameInputActive" @click="cancelName">
                        <i class="fas fa-times"/>
                    </div>
                </Transition>

                <Transition name="fade">
                    <div class="round-btn secondary-background" v-if="nameInputActive" @click="updateName">
                        <i class="fas fa-check"/>
                    </div>

                    <div class="round-btn primary-background" v-if="!nameInputActive" @click="nameInputActive=true">
                        <i class="fas fa-pen"/>
                    </div>
                </Transition>
            </div>
        </div>
        <div id="group-info-members">
            <div class="section-header">Mitglieder</div>
            <!--            <member v-for="member in members" :group="member"/>-->
            <member></member>
            <member></member>
            <member></member>
            <div class="button-container">
                <div class="btn secondary-background">
                    <p>Mehr</p>
                    <i class="fas fa-angle-down"/>
                </div>
                <div class="btn secondary-background">
                    <p>Statistik</p>
                    <i class="fas fa-chart-bar"/>
                </div>
            </div>
        </div>

        <div id="group-info-invitation">
            <div class="section-header">Einladungslink</div>
            <div class="btn secondary-background" @click="dialogBus.$emit('open')">
                Link generieren
            </div>
        </div>
        <div id="group-info-delete" v-if="hasAdminPermissions && isEmpty">
            <div class="btn warn-background" v-on:click="deleteGroup">
                <p>Gruppe löschen</p>
                <i class="fas fa-trash-alt"/>
            </div>
        </div>
        <div id="group-info-leave" v-if="!hasAdminPermissions || !isEmpty">
            <div class="btn warn-background" v-on:click="leaveGroup">
                <p>Gruppe verlassen</p>
                <i class="fas fa-sign-out-alt"></i>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from "vue";
import Member from "@/Pages/Member";
import axios from "axios";
import DialogWindow from "@/Pages/Dialog/dialog-window";
import DialogContentJoinLink from "@/Pages/Dialog/dialog-content-join-link";

export default {
    name: "group-info",
    components: {DialogContentJoinLink, DialogWindow, Member},
    props: {
        bus: Object,
        group: Object,
        hasAdminPermissions: Boolean,

    },
    data() {
        return {
            active: false,
            groupName: this.group.name,
            dialogBus: new Vue(),
            link: route("group.join.show", {uuid: this.group.uuid}),
            isEmpty: true,
            nameInputActive: false,
        };
    },
    created() {
        this.bus.$on("toggleGroupInfo", () => {
            this.toggleActive();
        });
    },
    methods: {
        toggleActive() {
            this.active = !this.active;
        },
        deleteGroup() {
            axios
                .post(route("group.delete"), {
                    uuid: this.group.uuid,
                })
                .then(() => this.$inertia.visit(route("groups.show"), { only: ["groups"] }));
        },
        leaveGroup() {
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
        updateName() {
            this.nameInputActive=false
            axios.post(route("group.update"), {
                groupId: this.group.id,
                groupName: this.groupName
            }).then(res => {
                console.log(res);
                this.$inertia.visit(route("group.show", { url: this.urlFormat(this.groupName) }), { only: ["group"] });
            });
        },
        cancelName() {
            this.nameInputActive=false;
            this.groupName = this.group.name;
        },

        urlFormat(str) {
            return str.toLowerCase().replace(" ", "-");
        }
    },
    mounted() {
    },
};
</script>

<style scoped>
#group-info {
    width: 0;
    color: var(--font-color);
    overflow: hidden;
    z-index: 100;
    background-color: var(--background-color);
    box-shadow: 1px 0px 15px 3px var(--shadow-color);
    -webkit-box-shadow: 1px 0px 15px 3px var(--shadow-color);
    -moz-box-shadow: 1px 0px 15px 3px var(--shadow-color);

    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    padding: 1% 0 1% 0;

    transition: 0.2s ease;
}

#group-info.active {
    width: 28%;
    padding: 1%;
}

::placeholder {
    color: var(--font-color);
}

#group-info-header {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    font-size: 1.5rem;
    font-weight: 700;
}

#group-info-name {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
}

#group-info-members {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
}

#group-info-delete {
    margin-top: auto;
}

#group-info-leave {
    margin-top: auto;
}

.section-header {
    font-weight: 600;
    margin-top: 2.5vh;
    margin-bottom: 0.6vh;
}

.button-container {
    width: 100%;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
}

#group-info-members .btn {
    width: 48%;
}

#group-info-invitation .btn {
    width: fit-content;
    justify-content: center;
}

#group-info-delete .btn {
    width: 80%;
}

.input-container {
    width: 100%;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

/*Transitions*/

.fade-enter-active,
.fade-leave-active {
    transition: all 0.15s ease;
}

.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
{
    opacity: 0;
}

@media (max-width: 1200px) {
    #group-info.active {
        position: absolute;
        width: 75%;
        height: 100%;
        padding: 2vh;
        z-index: 35;
    }

    #group-info {
        position: absolute;
        width: 100%;
        height: 0;
        box-shadow: none;
        z-index: 0;
    }

    #group-info-delete .btn {
        width: 25vh;
    }
}

@media (max-width: 576px) {
    #group-info.active {
        position: absolute;
        width: 100%;
        height: 100%;
        padding: 2vh;
        z-index: 35;
    }

    #group-info {
        display: none;
        position: absolute;
        width: 100%;
        height: 0;
        box-shadow: none;
        z-index: 0;
    }
}
</style>

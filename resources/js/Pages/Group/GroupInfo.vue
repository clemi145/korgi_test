<template>
    <div id="group-info" :class="{'active': active}">
        <div id="group-info-header">
            <div>Gruppeninfo</div>
            <div class="round-btn secondary-background" @click="toggleActive">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div id="group-info-name">
            <div class="section-header">Name</div>
            <div class="input-container">
                <input class="alternate-input" type="text" name="groupname" value="groupname" placeholder="Gruppenname"
                       v-model="groupname">
                <div class="round-btn primary-background">
                    <i class="fas fa-edit"/>
                </div>
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
            <div class="btn secondary-background">Link generieren</div>
        </div>
        <div id="group-info-delete">
            <div class="btn warn-background">
                <p>Gruppe löschen</p>
                <i class="fas fa-trash-alt"/>
            </div>
        </div>
    </div>
</template>

<script>
import Member from "@/Pages/Member";
export default {
    name: "group-info",
    components: {Member},
    props: {
        bus: Object
    },
    data() {
        return {
            active: false
        }
    },
    created() {
        this.bus.$on("toggleGroupInfo", () => {
            this.toggleActive()
        })
    },
    methods: {
        toggleActive() {
            this.active = !this.active;
        }
    }
}
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
    color: var(--font-color)
}

#group-info-header {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    font-size: 1.5rem;
    font-weight: 900;
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

.section-header {
    font-weight: 900;
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

@media (max-width: 1200px) {
    #group-info.active {
        position: absolute;
        width: 70%;
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

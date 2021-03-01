<template>
    <div class="group-card" @mouseleave="hideMenu" @click.self="linkToGroup">
        <div class="group-card-icon">{{ group.name.substring(0, 1) }}</div>
        <h1 class="group-card-name">{{ group.name }}</h1>
        <i class="fas fa-ellipsis-h group-card-menu" @click.self="showMenu"></i>
        <!-- Nur mal ein Versuch, denk nicht, dass wir das so machen können aber idk -->
        <context-menu :bus="bus"/>
    </div>
</template>

<script>
import axios from "axios";
import Vue from "vue";
import ContextMenu from "@/Pages/ContextMenu";

export default {
    name: "GroupCard",
    components: {ContextMenu},
    props: {
        group: Object,
    },
    data() {
        return {
            bus: new Vue(),
        }
    },
    methods: {
        linkToGroup() {
            axios
                .post(route("group.set"), {
                    groupId: this.group.id,
                    last_message: this.generateLaravelTimestamp(),
                })
                // .then((res) => console.log(res))
                .then(() => {
                    this.$inertia.visit(route("group.show", {url: this.group.url}));
                });
        },
        generateLaravelTimestamp() {
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
        },
        showMenu() {
            this.bus.$emit("showMenu");
        },
        hideMenu() {
            this.bus.$emit("hideMenu");
        }
    },
};
</script>

<style scoped>
.group-card {
    cursor: pointer;

    background-color: var(--background-color);

    width: 15vw;
    height: 15vw;
    border: #ffa88e solid 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    border-radius: 1.5rem;

    box-shadow: 1px 0px 15px 3px var(--shadow-color);
    -webkit-box-shadow: 1px 0px 15px 3px var(--shadow-color);
    -moz-box-shadow: 1px 0px 15px 3px var(--shadow-color);

    transition: 0.2s ease;

    margin: 2%;
}

.group-card:hover {
    transform: scale(1.05);
}

.group-card-icon {
    width: 50%;
    height: 50%;
    background-color: var(--primary);
    color: white;
    font-size: 3rem;
    font-weight: 600;

    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border-radius: 100%;
    order: 2;
    margin-top: 0;
}

.group-card-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--header-color);
    order: 3;
    margin-top: 10%;
}

.group-card-menu {
    font-size: 1.5rem;
    align-self: flex-end;
    order: 1;
    color: var(--font-color);
    margin-top: 0.8vh;
    margin-right: 1.5vh;
    padding: 2%;
}

@media (max-width: 1200px) {
    .group-card {
        width: 18vw;
        height: 18vw;
    }

    .group-card-name {
        font-size: 1rem;
        margin-top: 5%;
    }

    .group-card-icon {
        font-size: 2.5rem;
        margin-top: 2%;
    }
}

@media (max-width: 576px) {
    .group-card {
        width: 90vw;
        height: 20vw;
        flex-direction: row;
        justify-content: flex-start;

        box-shadow: 1px 0px 8px 3px var(--shadow-color);
        -webkit-box-shadow: 1px 0px 8px 3px var(--shadow-color);
        -moz-box-shadow: 1px 0px 8px 3px var(--shadow-color);
        border: #ffa88e solid 4px;
    }

    .group-card-icon {
        order: 0;
        width: 16.66%;
        height: 80%;
        font-size: 2rem;
        margin: 10px;
    }

    .group-card-name {
        order: 0;
        font-size: 1.3rem;
        margin-top: 0;
    }

    .group-card-menu {
        order: 0;
        display: block;
        margin-left: auto;
        align-self: center;
        padding: 12px;
        margin-right: 0;
        margin-top: 0;
    }
}
</style>

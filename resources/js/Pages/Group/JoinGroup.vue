<template>
    <div id="join-group">
        <inertia-link id="logo" :href="route('home')">
            <img src="/images/korgi_yellow_only.svg" alt="Logo">
        </inertia-link>
        <!--        <h1>Join Group {{ group.name }} with UUID {{ group.uuid }}</h1>-->
        <div id="join-group-content">
            <h1 id="question">Möchtest du {{ group.name }} beitreten?</h1>
            <div class="group-icon no-select">
                <div class="group-card-icon" @click.self="linkToGroup">{{ group.name.substring(0, 1) }}</div>
                <h1 class="group-card-name" @click.self="linkToGroup">{{ group.name }}</h1>
            </div>
            <div id="button-container">
<!--                <inertia-link class="btn warn-background" :href="route('home')">Lieber nicht...</inertia-link>-->
                <button class="btn secondary-background" v-on:click="addUser">Na klar!</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import GroupCard from "@/Pages/Group/GroupCard";
import Button from "@/Jetstream/Button";

export default {
    name: "JoinGroup",
    components: {Button, GroupCard},
    props: {
        user: Object,
        group: Object,
    },
    data() {
        return {
            link: "",
        };
    },
    created() {
    },
    methods: {
        addUser() {
            axios
                .post(route("group.join"), {
                    uuid: this.group.uuid,
                    userId: this.user.id
                })
                .then((res) => console.log(res))
                .then(this.$inertia.visit(route("groups.show")));


        },
    },
};
</script>

<style scoped>

::selection {
    background-color: #ffcb8e;
    color: white;
}

#join-group {
    display: flex;
    height: 100vh;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    background-color: var(--primary);
}

#logo {
    width: 18vh;
    align-self: flex-start;
    margin-top: 4vh;
    margin-left: 4vh;
}

#question {
    color: #000000;
    text-align: center;
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 4vh;
}

#join-group-content {
    width: 25%;
    margin-top: 5%;
    background-color: #FFFFFF;
    border-radius: 30px;
    padding: 4vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.group-icon {
    background-color: var(--background-color);

    width: 15vw;
    height: 15vw;
    border: #ffa88e solid 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-radius: 1.5rem;

    box-shadow: 1px 0px 15px 3px var(--shadow-color);
    -webkit-box-shadow: 1px 0px 15px 3px var(--shadow-color);
    -moz-box-shadow: 1px 0px 15px 3px var(--shadow-color);

    margin-bottom: 4vh;
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

.btn {
    width: 40%;
    justify-content: center;
}

#button-container {
    display: flex;
    flex-direction: row;
    width: 100%;
    justify-content: center;
}

@media (max-width: 576px) {
    #join-group-content {
        width: 85%;
        margin-top: 40%;
    }
    .group-icon {
        width: 95%;
        height: 20vw;
        flex-direction: row;
        justify-content: flex-start;

        box-shadow: 1px 0px 8px 3px var(--shadow-color);
        -webkit-box-shadow: 1px 0px 8px 3px var(--shadow-color);
        -moz-box-shadow: 1px 0px 8px 3px var(--shadow-color);
        border: #ffa88e solid 4px;

        -webkit-tap-highlight-color: transparent;
    }
    .group-card-icon {
        order: 0;
        width: 23%;
        height: 80%;
        font-size: 2rem;
        margin: 10px;
    }

    .group-card-name {
        order: 0;
        font-size: 1.3rem;
        margin-top: 0;
        margin-left: 0.5rem;
    }
    .btn {
        width: 60%;
    }
}
</style>

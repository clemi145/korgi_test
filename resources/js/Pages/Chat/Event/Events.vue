<template>
    <div id="events">
        <Navigation />
<!--        <div v-for="event in events">-->
<!--            <p>{{event.subject}}</p>-->
<!--            <p>{{event.date.toString()}}</p>-->
<!--        </div>-->
        <div class="events-header">
            <h1 class="title">Termine</h1>
        </div>
        <div id="events-container">
            <event v-for="event in events" :event="event" :key="event.event"/>
        </div>
    </div>
</template>

<script>
import Navbar from "@/Pages/Navigation/Navbar";
import Event from "@/Pages/Chat/Event/Event";
import Navigation from "@/Pages/Navigation/Navigation";
export default {
    name: "Events",
    components: {Event, Navbar, Navigation},
    computed: {
        events() {
            return this.$store.getters.getEvents
        }
    },
    created() {
        this.$store.commit("setCurrentPage", {page: "Termine"});
        this.$store.commit("setShowArrow", {showArrow: false});
    },
}
</script>

<style scoped>
#events {
    height: 100%;
    width: 100%;
    background-color: var(--background-color-alternate);
    overflow: auto;
    display: flex;
    flex-direction: row;
}

#events-container {
    margin-top: 2%;
    display: flex;
    position: relative;
    flex-direction: column;
    flex-wrap: wrap;
    justify-content: flex-start;
}

.events-header {
    padding: 2%;
}

@media (max-width: 576px) {
    .title {
        display: none;
    }
}

@media (min-width: 576px) {
    #events::-webkit-scrollbar {
        margin-left: -1rem;
        width: 1rem;
    }

    #events::-webkit-scrollbar-track {
        background: transparent;
        border-radius: 0.5rem;
    }

    #events::-webkit-scrollbar-thumb {
        background-color: #FFA88E;
        border-radius: 0.5rem;
    }
}

</style>

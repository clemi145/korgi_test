<template>
    <div id="events">
        <Navigation />
        <div id="events-content">
            <!--        <div v-for="event in events">-->
            <!--            <p>{{event.subject}}</p>-->
            <!--            <p>{{event.date.toString()}}</p>-->
            <!--        </div>-->
            <div class="events-header">
                <h1 class="title">Termine</h1>
                <div class="btn primary-background" @click="toggleFilters">Filter</div>
            </div>
            <div id="events-container">
                <event v-for="event in Events" :event="event"/>
            </div>
            <div class="round-btn primary-background" id="filters-btn-mobile" @click="toggleFilters">
                <i class="fas fa-sliders-h"></i>
            </div>
        </div>
        <event-filters :bus="bus"/>
    </div>
</template>

<script>
import Navbar from "@/Pages/Navbar";
import Event from "@/Pages/Event";
import Vue from "vue";
import EventFilters from "@/Pages/EventFilters";

export default {
    name: "Events",
    components: {EventFilters, Event, Navbar, Navigation},
    computed: {
        events() {
            return this.$store.getters.getEvents
        }
    },
    data() {
        return {
            bus: new Vue()
        }
    },
    created() {
        this.$store.commit("setCurrentPage", {page: "Termine"});
        this.$store.commit("setShowArrow", {showArrow: false});
    },
    methods: {
        toggleFilters() {
            this.bus.$emit("toggleFilters");
        },
    }
}
</script>

<style scoped>
#events {
    display: flex;
    flex-direction: row;
    width: 100%;
    height: 100%;
}

#events-content {
    width: 100%;
    background-color: var(--background-color-alternate);
    overflow: auto;
}

#events-container {
    margin-top: 2vh;
    display: flex;
    position: relative;
    flex-direction: column;
    flex-wrap: wrap;
    justify-content: flex-start;
}

.events-header {
    padding: 4vh;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
}

.btn {
    width: fit-content;
}

#filters-btn-mobile {
    display: none;
    position: fixed;
    bottom: 4vh;
    left: 4vh;
    box-shadow: 1px 0px 8px 3px var(--shadow-color);
    -webkit-box-shadow: 1px 0px 8px 3px var(--shadow-color);
    -moz-box-shadow: 1px 0px 8px 3px var(--shadow-color);
}

@media (max-width: 576px) {
    .title {
        display: none;
    }
    .events-header {
        display: none;
    }
    #filters-btn-mobile {
        display: flex;
    }
    #events-container {
        margin-top: 0;
    }
}

@media (min-width: 576px) {
    #events-content::-webkit-scrollbar {
        margin-left: -1rem;
        width: 1rem;
    }

    #events-content::-webkit-scrollbar-track {
        background: transparent;
        border-radius: 0.5rem;
    }

    #events-content::-webkit-scrollbar-thumb {
        background-color: #FFA88E;
        border-radius: 0.5rem;
    }
}

</style>

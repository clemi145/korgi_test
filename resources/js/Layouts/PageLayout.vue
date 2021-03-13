<template>
    <div id="wrapper">
        <store-initializer :user="user" :groups="groups"/>
        <navigation :bus="bus" :user="$page.props.user.name"/>
        <navbar :bus="bus"/>
        <main>
            <slot></slot>
        </main>
    </div>
</template>

<script>
import Vue from "vue";
import Navigation from "@/Pages/Navigation/Navigation.vue";
import Navbar from "@/Pages/Navigation/Navbar.vue";
import StoreInitializer from "@/Pages/store-initializer";

export default {
    components: {StoreInitializer, Navigation, Navbar},
    props: {
        user: Object,
        groups: Array,
    },
    data() {
        return {
            bus: new Vue(),
        };
    },
};
</script>

<style>
#wrapper {
    width: 100vw;
    height: 100vh;
    display: flex;
    flex-direction: row;
}

main {
    width: 80vw;
    height: 100vh;
}
@media (max-width: 576px) {
    #wrapper {
        flex-direction: column;
    }

    main {
        width: 100vw;
    }
}
</style>

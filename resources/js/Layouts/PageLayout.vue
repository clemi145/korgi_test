<template>
  <div id="wrapper">
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

export default {
  components: { Navigation, Navbar },
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
  width: 100vw;
  height: 100vh;
}
</style>

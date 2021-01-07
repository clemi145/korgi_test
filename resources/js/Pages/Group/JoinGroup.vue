<template>
  <div>
    <h1>Join Group {{ group.name }} with UUID {{ group.uuid }}</h1>
    <button v-on:click="addUser">Ich will beitreten</button>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "JoinGroup",
  components: {},
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
    console.log(this.group.uuid);
  },
  methods: {
    addUser() {
      axios
        .post("/join", {
          uuid: this.group.uuid,
        })
        .then((res) => console.log(res))
        .then(this.$inertia.visit(route("groups.show")));

        
    },
  },
};
</script>

<style>
</style>

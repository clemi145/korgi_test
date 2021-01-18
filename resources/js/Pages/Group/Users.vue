<template>
  <div>
    <h1>Users</h1>
    <div
      v-for="user in users"
      :key="user.id"
      style="display: flex; flex-direction: row"
    >
      {{ user.id }} : {{ user.name }}
      <p>&nbsp;</p>
      <button v-if="isAdmin" v-on:click="removeUser(user.id)" style="padding: 1px 5px; background-color: lightblue; border-radius: 5px;">Remove</button>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Users",
  props: {
    group: Object,
    users: Array,
    isAdmin: Boolean,
  },
  created() {
    console.log(this.users);
  },
  methods: {
    urlFormat(string) {
        return string.toLowerCase().replace(" ", "-");
    },
    removeUser(id) {
      axios
        .post(
          route("user.remove", {
            groupUuid: this.group.uuid,
            userId: id,
          })
        )
        .then((res) => {
          this.$inertia.visit(route("group.users", { url: this.urlFormat(this.group.name) }));
        });
    },
  },
};
</script>

<style>
</style>
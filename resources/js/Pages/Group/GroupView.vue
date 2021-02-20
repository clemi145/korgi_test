<template>
  <div id="outer-wrapper">
    <div id="group-view">
      <!--<inertia-link :href="route('teams.create')">Create Team</inertia-link>-->
      <dialog-window
        :bus="groupInputBus"
        title="Gruppe erstellen!"
        @submit="createGroup"
      >
        <dialog-content-create-group :bus="groupInputBus" />
      </dialog-window>

      <div class="group-view-header">
        <h1 class="title">Gruppenübersicht</h1>
      </div>
      <div id="groups">
        <group-card v-for="group in groups" :group="group" :key="group.url" />
        <new-group-card @click="groupInputBus.$emit('open')" />
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import GroupCard from "@/Pages/Group/GroupCard";
import NewGroupCard from "@/Pages/Group/NewGroupCard";
import DialogWindow from "@/Pages/Dialog/dialog-window";
import DialogContentCreateGroup from "@/Pages/Dialog/dialog-content-create-group";
import Navbar from "@/Pages/Navigation/Navbar";
import axios from "axios";

export default {
  name: "GroupView",
  components: {
    DialogContentCreateGroup,
    DialogWindow,
    NewGroupCard,
    GroupCard,
    Navbar,
  },
  props: {
    groups: Object,
  },
  data() {
    return {
      groupInputBus: new Vue(),
    };
  },
  created() {
    this.$store.commit("setCurrentPage", { page: "Gruppenübersicht" });
    this.$store.commit("setShowArrow", { showArrow: false });
  },
  computed: {
    get_groups: function () {
      return this.$store.getters.getGroups;
    },
  },
  methods: {
    createGroup(name) {
      this.$store.commit("addGroup", { name: name });
      this.$inertia.visit(route("groups.show"), {
        only: ["groups"],
      });
    },
  },
};
</script>

<style scoped>
#outer-wrapper {
  width: 100vw;
}

#group-view {
  height: 100%;
  width: 100%;
  background-color: var(--background-color-alternate);
  overflow: auto;
}

.group-view-header {
  padding: 2%;
}

#groups {
  margin-top: 2%;
  display: flex;
  position: relative;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: flex-start;
}

@media (max-width: 1200px) {
    #groups {
        padding-left: 3vh;
    }
}

@media (max-width: 576px) {
  #groups {
    /*margin-top: 25%;*/
    flex-direction: column;
    flex-wrap: nowrap;
    align-items: center;
  }

  .group-view-header {
    display: none;
  }
}

@media (min-width: 576px) {
  #group-view::-webkit-scrollbar {
    margin-left: -1rem;
    width: 1rem;
  }

  #group-view::-webkit-scrollbar-track {
    background: transparent;
    border-radius: 0.5rem;
  }

  #group-view::-webkit-scrollbar-thumb {
    background-color: #ffa88e;
    border-radius: 0.5rem;
  }
}
</style>

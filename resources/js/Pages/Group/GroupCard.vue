<template>
  <div class="group-card" @click="linkToGroup">
    <div class="group-card-icon">{{ group.name.substring(0, 1) }}</div>
    <h1 class="group-card-name">{{ group.name }}</h1>
    <i class="fas fa-ellipsis-h group-card-menu"></i>
    <!-- Nur mal ein Versuch, denk nicht, dass wir das so machen können aber idk -->
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "GroupCard",
  props: {
    group: Object,
  },
  methods: {
    linkToGroup() {
      axios
        .post(route("group.set"), {
          groupId: this.group.id,
          last_message: this.generateLaravelTimestamp(),
        })
        .then((res) => console.log(res))
        .then(() => {
          this.$inertia.visit(route("group.show", { url: this.group.url }));
        });
    },
    generateLaravelTimestamp(){
    var d = new Date()
    var year = d.getFullYear();
    var month = ("0" + (d.getMonth() + 1)).slice(-2);
    var day = ("0" + d.getDate()).slice(-2);
    var hour = ("0" + d.getHours()).slice(-2);
    var minutes = ("0" + d.getMinutes()).slice(-2);
    var seconds = ("0" + d.getSeconds()).slice(-2);
    return year + "-" + month + "-" + day + " "+ hour + ":" + minutes + ":" + seconds;
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
  justify-content: space-around;
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
}

.group-card-name {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--header-color);
  order: 3;
}
.group-card-menu {
  display: none;
  font-size: 1.5rem;
  align-self: flex-end;
  order: 1;
  padding: 16px;
  color: var(--font-color);
}

@media (max-width: 1200px) {
  .group-card {
    width: 18vw;
    height: 18vw;
  }
  .group-card-name {
    font-size: 1rem;
  }
  .group-card-icon {
    font-size: 2.5rem;
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
  }
  .group-card-menu {
    order: 0;
    display: block;
    margin-left: auto;
    align-self: center;
    padding: 12px;
  }
}
</style>

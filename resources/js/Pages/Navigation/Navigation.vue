<template>
  <div
    id="navigation"
    v-bind:class="{ 'navigation-active': isActive, hide: hide }"
  >
    <div id="top">
      <div id="header">
        <img
          class="logo"
          src="/images/korgi_yellow_only.svg"
          alt="KORGI"
        />
        <a
          id="burger"
          href="#"
          @click="toggleMenu"
          v-bind:class="{ active: isActive }"
          ><span
        /></a>
      </div>
      <p class="greeting">Willkommen zurück, {{ user }}!</p>
      <form method="POST" @submit.prevent="logout">
        <jet-responsive-nav-link as="button">
          Abmelden
        </jet-responsive-nav-link>
      </form>
    </div>
    <div id="center">
      <div @click="toggleMenu" v-bind:class="{ active: isActive }">
        <inertia-link
          :class="groupsIsCurrent()"
          :href="route('groups.show')"
          class="navigation-item"
        >
          <p>Gruppenübersicht</p>
          <i class="fas fa-th-large"></i>
        </inertia-link>
      </div>
      <div @click="toggleMenu" v-bind:class="{ active: isActive }">
        <inertia-link
          :class="eventsIsCurrent()"
          :href="route('events.show')"
          class="navigation-item"
        >
          <p>Termine</p>
          <i class="far fa-calendar-alt"></i>
        </inertia-link>
      </div>
      <div @click="toggleMenu" v-bind:class="{ active: isActive }">
        <inertia-link
          :class="settingsIsCurrent()"
          :href="route('settings.show')"
          class="navigation-item"
        >
          <p>Einstellungen</p>
          <i class="fas fa-cog"></i>
        </inertia-link>
      </div>
      <div @click="toggleMenu" v-bind:class="{ active: isActive }">
        <div :class="tutorialIsCurrent()" class="navigation-item">
          <p>Tutorial starten</p>
          <i class="far fa-question-circle"></i>
        </div>
      </div>
    </div>
    <div class="btn secondary-background" @click="toggleDarkmode">
      Toggle Darkmode WIP
    </div>
    <div id="bottom">
      <a>Impressum</a>
      <a>Datenschutzerklärung</a>
    </div>
  </div>
</template>

<script>
import Button from "@/Jetstream/Button";
import JetApplicationMark from "@/Jetstream/ApplicationMark";
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";
import JetNavLink from "@/Jetstream/NavLink";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
import PageLayout from "@/Pages/PageLayout";
export default {
  name: "Navigation",
  components: {
    JetApplicationMark,
    JetDropdown,
    JetDropdownLink,
    JetNavLink,
    JetResponsiveNavLink,
    Button,
    PageLayout
  },
  props: {
    user: String,
    bus: Object,
  },
  created() {
    this.bus.$on("toggleMenu", () => {
      if (this.isActive) {
        this.isActive = !this.isActive;
        setTimeout(() => {
          this.hide = !this.hide;
        }, 300);
      } else {
        this.hide = !this.hide;
        setTimeout(() => {
          this.isActive = !this.isActive;
        }, 5);
      }
    });
  },
  data() {
    return {
      isActive: false,
      hide: true,
    };
  },
  methods: {
    logout() {
      axios.post(route("logout")).then((response) => {
        window.location = "/";
      });
    },
    toggleDarkmode() {
      this.$store.commit("toggleDarkmode");
    },
    groupsIsCurrent() {
      if (document.URL.match("/gruppen.*")) {
        return "navigation-item-active";
      }
    },
    eventsIsCurrent() {
      if (document.URL.includes("/termine")) {
        return "navigation-item-active";
      }
    },
    settingsIsCurrent() {
      if (document.URL.includes("/einstellungen")) {
        return "navigation-item-active";
      }
    },
    tutorialIsCurrent() {
      if (document.URL.includes("/tutorial")) {
        return "navigation-item-active";
      }
    },
    toggleMenu() {
      this.bus.$emit("toggleMenu");
    },
  },
};
</script>

<style scoped>
.logo {
  width: 100%;
}

#navigation {
  display: flex;
  flex-direction: column;
  align-content: flex-start;
  justify-content: space-between;
  z-index: 40;

  width: 20vw;
  height: 100%;

  background-color: #ffa88e;
}

.navigation-item {
  padding: 5%;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  color: white;
  font-size: 1.2rem;
  font-weight: 600;

  margin-top: 1em;
  margin-bottom: 1em;
  background-color: #ffa88e;
  transition: 0.2s ease;
  margin: 0;
}

.greeting {
  font-size: 1.4rem;
  font-weight: bold;
  color: white;
  margin-top: 5%;
  margin-bottom: 5%;
}

.navigation-item i {
  width: 1.2rem;
  font-size: 1.5rem;
}

.navigation-item:hover {
  background-color: #ff8f6e;
}

#top {
  display: flex;
  flex-direction: column;
  padding: 5%;
  padding-right: 3%;
}

#top a {
  color: white;
  text-decoration: underline;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
}

.navigation-item-active {
  background-color: #ff8f6e;
}

#bottom {
  display: flex;
  flex-direction: column;
  padding: 5%;
}

#bottom a {
  margin-top: 5%;
  color: white;
  text-decoration: underline;
  font-size: 1.2rem;
  font-weight: bold;
}

#header {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}

#burger {
  display: none;
  cursor: pointer;
  margin-left: auto;
  align-self: center;
  padding: 10px;
}

#burger span {
  position: relative;
  display: block;
  z-index: 5;
  width: 30px;
  height: 4px;
  background: #ffffff;
  transition: all 0.2s ease-in-out;
  border-radius: 3px;
}

#burger span:before,
#burger span:after {
  position: absolute;
  background: #ffffff;
  content: "";
  width: 30px;
  height: 4px;
  transition: all 0.2s ease-in-out;
  border-radius: 3px;
}

#burger span:before {
  top: -8px;
}

#burger span:after {
  top: 8px;
}

#burger.active span {
  background: transparent;
}

#burger.active span:before {
  transform: rotate(45deg) translate(5px, 6px);
  background: #ffffff;
}

#burger.active span:after {
  transform: rotate(-45deg) translate(5px, -6px);
  background: #ffffff;
}

@media (max-width: 576px) {
  #navigation {
    position: absolute;
    right: -80vw;
    width: 80vw;
    height: 100vh;

    box-shadow: 1px 0px 15px 3px rgba(92, 86, 86, 0.5);
    -webkit-box-shadow: 1px 0px 15px 3px rgba(92, 86, 86, 0.5);
    -moz-box-shadow: 1px 0px 15px 3px rgba(92, 86, 86, 0.5);
    transition: 0.3s ease;
  }

  #navigation.navigation-active {
    right: 0;
    transition: 0.3s ease;
  }

  .logo {
    width: 70%;
  }
  .hide {
    display: none !important;
  }
  #burger {
    display: inline;
  }
}
</style>

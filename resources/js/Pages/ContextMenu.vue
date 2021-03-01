<template>
    <div id="context-menu" class="no-select" :class="{ active: active }">
        <div class="option">Option 1</div>
        <div class="option">Option 2</div>
    </div>
</template>

<script>
export default {
    name: "ContextMenu",
    props: {
        bus: Object
    },
    data() {
        return {
            active: false
        }
    },
    created() {
        this.bus.$on("showMenu", () => {
            this.toggleActive();
        });
        this.bus.$on("hideMenu", () => {
            this.hideMenu();
        });
    },
    methods: {
        toggleActive() {
            this.active = !this.active;
        },
        hideMenu() {
            this.active= false;
        }
    }
}
</script>

<style scoped>
#context-menu {
    background-color: var(--background-color);
    box-shadow: 1px 0px 10px 3px var(--shadow-color);
    -webkit-box-shadow: 1px 0px 10px 3px var(--shadow-color);
    -moz-box-shadow: 1px 0px 10px 3px var(--shadow-color);
    display: none;
    flex-direction: column;
    position: absolute;
    border-radius: 0.5rem;
    right: 7%;
    top: 14%;
}

#context-menu.active {
    display: flex;
}

.option {
    padding: 10px;
    color: var(--font-color);
    border-radius: 0.5rem;
}
.option:hover {
    background-color: var(--background-color-alternate);
}
</style>

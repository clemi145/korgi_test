<template>
    <div class="dialog-content">
        <div class="colors-container">
            <div
                class="color-element"
                v-for="color in colors"
                :style="'backgroundColor: ' + color"
                @click="saveContent(color)"
                :class="{'selected': selectedColor === color}"
            >
                <i class="fas fa-check" v-if="selectedColor === color"></i>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "DialogContentColorPicker",
    props: {
        bus: Object
    },
    data() {
        return {
            colors: [
                "#FF8EA1",
                "#FFC78E",
                "#FFFF8E",
                "#D2FF8E",
                "#8EFF96",
                "#60A29C",
                "#8EF0FF",
                "#79D1DE",
                "#4C7DFF",
                "#8EA8FF",
                "#B48EFF",
                "#FF8ED6"
            ],
            selectedColor: undefined,
            group: undefined
        }
    },
    created() {
        this.bus.$on("open", (payload) => {
            this.selectedColor = payload.group.color;
            this.group = payload.group
        })
    },
    methods: {
        saveContent(color) {
            this.selectedColor = color;

            this.bus.$emit('validate', {
                color: color,
                group: this.group.url
            })
        }
    }
}
</script>

<style scoped>
.dialog-content {
    width: 100%;
}

.colors-container {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: flex-start;
    flex-direction: row;
}

.color-element {
    cursor: pointer;
    user-select: none;
    width: 14.6%;
    margin: 1%;
    aspect-ratio: 1 / 1;
    border-radius: 10%;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}
.color-element .fas {
    opacity: 0;
}

.color-element:hover {
    transform: scale(1.05);
}

.color-element.selected .fas {
    opacity: 1;
}
</style>

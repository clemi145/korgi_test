<template>
    <div class="dialog-content">
        <input id="create-group-dialog-input" class="input" type="text" v-model="name" placeholder="Gruppenname" @input="saveContent" @keypress.enter="bus.$emit('submit')">
    </div>
</template>

<script>
export default {
    name: "new-add-group-dialog",
    data() {
        return {
            name: ""
        }
    },
    props: {
        bus: Object
    },
    methods: {
        saveContent(event) {
            this.bus.$emit('validate', this.name);
        },
    }

}
</script>

<style scoped>
.dialog-content {
    width: 100%;
}

#create-group-dialog-input {
    width: 100%;
}
</style>

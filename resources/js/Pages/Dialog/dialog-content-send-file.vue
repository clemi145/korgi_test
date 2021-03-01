<template>
    <div class="dialog-content">
        <input class="input send-file-message" type="text" placeholder="Nachricht" v-model="message" @input="saveContent">
        <input id="send-file-input" type="file" @change="saveContent">
    </div>
</template>

<script>
export default {
    name: "dialog-content-send-file",
    props: {
        bus: Object
    },
    data() {
        return {
            file: undefined,
            message: ""
        }
    },
    methods: {
        saveContent() {
            this.file = document.getElementById("send-file-input").files[0];
            this.bus.$emit('validate', {
                file: this.file,
                message: this.message
            });
        }
    }
}
</script>

<style scoped>
.dialog-content {
    width: 100%;
}

#send-file-input {
    border-radius: 2rem;
    background-color: lightgray;
    border: gray dashed 5px;
    height: 40vh;
    width: 100%;

    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

#send-file-input:focus {
    outline: 0;
    border-color: var(--primary);
}

.send-file-message {
    width: 100%;
    margin-bottom: 10%;
}
</style>

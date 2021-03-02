<template>
    <div class="dialog-content">
        <input class="input send-file-message" type="text" placeholder="Nachricht" v-model="message" @input="saveContent">
        <label for="send-file-input" id="send-file-input-container">
            <input id="send-file-input" type="file" @change="saveContent">
            <i class="fas fa-file"></i>
            <span class="text">Klicken um Datei hochzuladen</span>
        </label>
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

input[type="file"] {
    height: 100%;
    opacity: 0;
    z-index: 102;
}

input[type="file"]:focus {
    outline: 0;
}

#send-file-input-container {
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

i {
    position: absolute;
    font-size: 6rem;
    z-index: 101;
    color: var(--dark-grey);
}

.text {
    z-index: 101;
    font-weight: 700;
    color: var(--dark-grey);
}

#send-file-input-container:hover {
    outline: 0;
    border-color: var(--primary);
}

.send-file-message {
    width: 100%;
    margin-bottom: 10%;
}
</style>

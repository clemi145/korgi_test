<template>
    <div class="dialog-content">
        <input class="input send-file-message" type="text" placeholder="Nachricht" v-model="message"
               @input="saveContent">
        <label for="send-file-input" id="send-file-input-container">
            <input id="send-file-input" type="file" @change="saveContent">
            <div id="container">
                <i class="fas fa-file"></i>
                <span class="text" v-if="!file">Datei hochladen</span>
                <span class="text" v-if="file">{{ file.name }}</span>
            </div>
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
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
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

#container {
    position: absolute;
    z-index: 101;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 70%;
}

i {
    font-size: 6rem;
    color: var(--dark-grey);
    margin-bottom: 2vh;
    margin-right: 0;
}

.text {
    font-weight: 700;
    color: var(--dark-grey);
    word-break: break-word;
    text-align: center;
}

#send-file-input-container:hover {
    outline: 0;
    border-color: var(--primary);
}

.send-file-message {
    width: 100%;
    margin-bottom: 10%;
}

@media (max-width: 576px) {
    #send-file-input-container {
        height: 16vh;
    }

    i {
        font-size: 3rem;
        left: 14%;
        margin-bottom: 0;
        margin-right: 0.3rem;
    }

    #container {
        flex-direction: row;
        justify-content: space-around;
    }
}

</style>

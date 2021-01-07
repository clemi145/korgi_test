<template>
    <div class="file-element" v-bind:class="changeAlignment()">
        <div class="sender" v-if="!isOwn">{{ message.message.user.username }}</div>
        <p class="text">{{message.message.text}}</p>
        <div class="file-container primary-background">
            <i class="far fa-file-pdf"></i>
            <p>{{message.message.fileName}}</p>
        </div>
        <div class="timetoken">{{
                new Date(message.timetoken / 10000).toLocaleTimeString('de', {
                    hour: "2-digit",
                    minute: "2-digit"
                })
            }}
        </div>
    </div>
</template>

<script>
export default {
    name: "File",
    props: {
        message: Object
    },
    computed: {
        isOwn() {
            return this.message.publisher === this.$store.state.pubnub.getUUID()
        }
    },
    methods: {
        changeAlignment() {
            if (this.isOwn) {
                return 'right';
            }
        }
    }
}
</script>

<style scoped>
.file-element {
    max-width: 40%;
    background-color: white;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: space-between;
    padding: 1%;
    margin: 0.5%;
    border-radius: 1rem;
}

.right {
    text-align: right;
    align-self: flex-end;
    background-color: #FFDBB1;
}

.file-container {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    border-radius: 1rem;
    margin-top: 0.4rem;
    margin-bottom: 0.2rem;
    padding: 1rem;
}

i {
    font-size: 2rem;
    color: #ef5252;
    margin-right: 1rem;
    text-align: center;
}

.sender {
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 1%;
}

.timetoken {
    align-self: flex-end;
    color: #707070;
    font-size: 0.8rem;
}
</style>

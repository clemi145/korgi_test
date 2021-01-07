<template>
    <div class="message" v-bind:class="changeAlignment()">
        <div class="sender" v-if="!isOwn">{{ message.message.user.username }}</div>
        <div class="text">{{ message.message.text }}</div>
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
    name: "Message",
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
.message {
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

.sender {
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 1%;
}

/**
.text {

}
*/

.timetoken {
    align-self: flex-end;
    color: #707070;
    font-size: 0.8rem;
}

.right {
    align-self: flex-end;
    background-color: #FFDBB1;
}

@media (max-width: 576px) {
    .message {
        padding: 2.5%;
    }
}

</style>

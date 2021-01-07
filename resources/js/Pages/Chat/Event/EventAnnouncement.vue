<template>
    <div class="message" v-bind:class="changeAlignment()">
        <div class="sender" v-if="!isOwn">{{ message.message.user.username }}</div>
        <div class="subject">{{ message.message.text }}</div>
        <div class="date"><span style="font-weight: bold">Datum:</span> {{weekdayNames[date.getDay()]}}, {{date.toLocaleDateString('de')}}</div>
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
    name: "EventAnnouncement",
    data() {
        return {
            weekdayNames: ["Sonntag", "Montag", 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
        }
    },
    props: {
        message: Object
    },
    computed: {
        isOwn() {
            return this.message.publisher === this.$store.state.pubnub.getUUID()
        },
        date() {
            return new Date(this.message.message.date);
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
    width: 80%;
    background-color: white;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: space-between;
    padding: 1%;
    margin: 0.5%;
    border-radius: 1rem;
    align-self: center;
}

.sender {
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 1%;
}

.subject {
    color: #ef5252;
    font-size: 1.1rem;
    font-weight: bold;
}

.timetoken {
    align-self: flex-end;
    color: #707070;
    font-size: 0.8rem;
}

.right {
    background-color: #FFDBB1;
}
</style>

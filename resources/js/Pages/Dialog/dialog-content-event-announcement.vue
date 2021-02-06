<template>
    <div class="dialog-content">
        <input id="subject-input" class="input" type="text" v-model="subject" placeholder="Bezeichnung"
               @input="saveContent" @keypress.enter="bus.$emit('submit')">
        <date-picker :multiple="true" @input="saveDate"/>
    </div>
</template>

<script>
import DatePicker from "@/Pages/Dialog/DatePicker";
export default {
    name: "dialog-content-event-announcement",
    components: {DatePicker},
    data() {
        return {
            subject: "",
            date: []
        }
    },
    props: {
        bus: Object
    },
    methods: {
        saveContent() {
            this.bus.$emit('validate', {
                subject: this.subject,
                date: this.date
            });
        },
        saveDate(payload) {
            this.date = payload.dates[0];
            this.saveContent();
        }
    }
}
</script>

<style scoped>
.dialog-content {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
}

#subject-input {
    width: 100%;
    margin-bottom: 10%;
}
</style>

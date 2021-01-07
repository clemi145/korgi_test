<template>
    <div class="event">
        <div class="date">
            <div class="date-text">{{event.date.toLocaleDateString('de')}}</div>
        </div>
        <div class="subject">{{ event.subject }}</div>
        <div class="description">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
            invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
        </div>
    </div>
</template>

<script>
export default {
    name: "Event",
    props: {
        event: Object
    }
}
</script>

<style scoped>
.event {
    display: flex;
    flex-direction: column;
    width: 60%;
    border-radius: 1rem;
    background-color: var(--background-color);

    box-shadow: 1px 0px 15px 3px rgba(92, 86, 86, 0.3);
    -webkit-box-shadow: 1px 0px 15px 3px rgba(92, 86, 86, 0.3);
    -moz-box-shadow: 1px 0px 15px 3px rgba(92, 86, 86, 0.3);

    align-self: center;
    margin-bottom: 4%;
}

.date {
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    background-color: var(--primary);
}

.date-text {
    font-size: 1.5rem;
    margin: 1% 2% 1% 2%;
    color: white;
    font-weight: 800;
}

.subject {
    margin-left: 2%;
    margin-top: 2%;
    font-weight: 800;
    font-size: 1.3rem;
    color: var(--font-color)
}
.description {
    margin: 2%;
    color: var(--font-color)
}

@media (max-width: 576px) {
    .event {
        width: 90%;
    }
    .date-text {
        margin: 2% 3% 2% 3%;
        font-size: 1.4rem;
    }
    .subject {
        margin-left: 3%;
        margin-top: 3%;
        font-size: 1.2rem;
    }
    .description {
        margin: 3%;
    }
}
</style>

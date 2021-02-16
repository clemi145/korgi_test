<template>
    <div class="new-group-card" @click="$emit('click')">
        <i class="fas fa-plus new-group-card-icon"></i>
        <h1 class="new-group-card-text">Neue Gruppe erstellen</h1>
    </div>
</template>

<script>
export default {
    name: "NewGroupCard"
}
</script>

<style scoped>
.new-group-card {
    cursor: pointer;

    background-color: var(--background-color);

    width: 15vw;
    height: 15vw;
    border: #FFCB8E dashed 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-radius: 1.5rem;

    box-shadow: 1px 0px 15px 3px var(--shadow-color);
    -webkit-box-shadow: 1px 0px 15px 3px var(--shadow-color);
    -moz-box-shadow: 1px 0px 15px 3px var(--shadow-color);

    transition: 0.2s ease;

    margin: 2%;
}

.new-group-card:hover {
    transform: scale(1.05);
}

.new-group-card-icon {
    color: #FFCB8E;
    font-size: 3rem;
    font-weight: 600;
}

.new-group-card-text {
    font-size: 1.2rem;
    font-weight: 700;
    color: #FFCB8E;
}

h1 {
    text-align: center;
}

@media (max-width: 1200px) {
    .new-group-card {
        width: 18vw;
        height: 18vw;
    }
    .new-group-card-text {
        font-size: 1rem;
    }
    .new-group-card-icon {
        font-size: 2.5rem;
    }
}

@media (max-width: 576px) {
    .new-group-card {
        width: 90vw;
        height: 20vw;
        flex-direction: row;
        justify-content: flex-start;
        border: #FFCB8E dashed 4px;

        box-shadow: 1px 0px 8px 3px var(--shadow-color);
        -webkit-box-shadow: 1px 0px 8px 3px var(--shadow-color);
        -moz-box-shadow: 1px 0px 8px 3px var(--shadow-color);
    }
    .new-group-card-icon {
        width: 17%;
        height: 80%;
        font-size: 2rem;
        margin: 10px;

        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
}

</style>

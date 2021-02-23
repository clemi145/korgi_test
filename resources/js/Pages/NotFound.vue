<template>
    <div id="not-found">
        <div id="motd">
            <img src="/images/korgi_red_sad.svg">
            <p>Hier gibt's wohl nichts zu sehen.</p>
            <inertia-link class="btn secondary-background" :href="route('home')">
                Home
            </inertia-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "NotFound"
}
</script>

<style scoped>

#not-found {
    font-family: "Montserrat", sans-serif;
    height: 100vh;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: #ffa88e;
}

#motd {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

p {
    font-size: 4rem;
    color: #ffffff;
    text-align: center;
    margin-top: 4vh;
}

img {
    width: 40%;
    align-self: center;
}

.btn {
    width: 20%;
    margin-top: 2vh;
    justify-content: center;
}

@media (max-width: 576px) {
    p {
        font-size: 2rem;
    }

    img {
        width: 70%;
    }
}

</style>

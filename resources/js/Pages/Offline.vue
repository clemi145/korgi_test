<template>
    <div id="offline">
        <div id="motd">
            <img src="/images/korgi_red_sad.svg">
            <p>Scheint als wärst du gerade offline.</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "Offline"
}
</script>

<style scoped>

#offline {
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

@media (max-width: 576px) {
    p {
        font-size: 2rem;
    }
    img {
        width: 70%;
    }
}

</style>

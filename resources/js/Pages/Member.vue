<template>
    <div id="container">
        <div id="member">
            <div id="name">
                <p class="role">Admin</p>
                <p>Jakob Fischer</p>
            </div>
            <div class="round-btn primary-background">
                <i class="fas fa-ellipsis-h"></i>
            </div>
        </div>
        <div id="line"/>
    </div>
</template>

<script>
export default {
    name: "member"
}
</script>

<style scoped>

#member {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

#name {
    display: flex;
    flex-direction: column;
    justify-content: center;
    white-space: nowrap;
}

#container {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    width: 100%;

    margin-bottom: 1.5vh;
    margin-top: 1vh;
}

#line {
    margin-top: 1vh;
    border-top: 2px solid var(--font-color-light);
    height: 2px;
    width: 100%;
    flex: 1;
}

.role {
    font-size: 0.8rem;
    font-weight: 900;
    color: var(--warn);
}

</style>

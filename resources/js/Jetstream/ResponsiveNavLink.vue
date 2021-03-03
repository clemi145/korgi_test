<template>
    <div>
        <button v-if="as == 'button'">
            <slot></slot>
        </button>

        <inertia-link :href="href"  v-else>
            <slot></slot>
        </inertia-link>
    </div>
</template>

<script>
    export default {
        props: ['active', 'href', 'as'],

        computed: {
            classes() {
                return this.active
                            ? 'block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out'
                            : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out'
            }
        }
    }
</script>

<style scoped>
/* Muss leider hier rein, habs ned anders hinbekommen */
button {
    color: white;
    text-decoration: underline;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    margin-top: 1vh;
}

button:focus {
    outline: 0;
}
</style>

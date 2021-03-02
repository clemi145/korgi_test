<template>
    <div v-if="hasErrors" v-show="elementVisible" id="error">
        <div>Hoppla! Da ist wohl etwas schief gelaufen.</div>

        <ul class="mt-3 list-disc list-inside">
            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        computed: {
            errors() {
                return this.$page.props.errors
            },

            hasErrors() {
                return Object.keys(this.errors).length > 0;
            },
        },
        data() {
            return {
                elementVisible: true
            }
        },
        created() {
            // setTimeout(() => this.elementVisible = false, 8000)
        }
    }
</script>
<style scoped>

::selection {
    background-color: var(--secondary);
    color: white;
}

#error {
    position: fixed;
    bottom: 5%;
    right: 5%;
    color: #FFFFFF;
    background-color: var(--warn);
    border-radius: 1rem;
    padding: 1%;
    font-weight: 600;

    box-shadow: 1px 0px 10px 3px var(--shadow-color);
    -webkit-box-shadow: 1px 0px 10px 3px var(--shadow-color);
    -moz-box-shadow: 1px 0px 10px 3px var(--shadow-color);
}
</style>

<template>
    <div v-if="hasErrors">
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
        }
    }
</script>

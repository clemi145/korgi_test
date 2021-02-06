<template>
  <div>
    <label class="block w-full text-gray-700 text-sm font-bold mb-2">{{ label }}</label>
    <input
      class="form-input rounded-md shadow-sm"
      :value="value"
      @input="$emit('input', $event.target.value)"
      ref="input"
      :type="type"
      :placeholder="placeholder"
    />
    <p class="text-red-500 text-xs italic" v-if="!!error">{{ error }}</p>
  </div>
</template>

<script>
export default {
  name: "Input",
  props: ["error", "value", "label", "type", "placeholder"],

  methods: {
    focus() {
      this.$refs.input.focus();
    },
  },
};
</script>


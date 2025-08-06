<template>
  <div>
    <input
      id="trix"
      type="hidden"
      :name="name"
      :value="value"
      ref="input"
    />
    <trix-editor
      ref="trix"
      input="trix"
      :placeholder="placeholder"
    ></trix-editor>
  </div>
</template>

<script>
import 'trix'

export default {
  inheritAttrs: false,
  props: ['name', 'value', 'placeholder', 'shouldClear'],

  mounted() {
    // Watch for changes in the Trix editor
    this.$refs.trix.addEventListener('trix-change', () => {
      // Emit updated value
      const updatedValue = this.$refs.input.value;
      this.$emit('input', updatedValue);
    });

    // Watch for shouldClear and clear input/editor
    this.$watch('shouldClear', (newVal) => {
      if (newVal) {
        this.clearEditor();
      }
    });

    // Set initial value if needed (for two-way binding)
    if (this.value) {
      this.$refs.input.value = this.value;
      this.$refs.trix.editor.loadHTML(this.value);
    }
  },

  methods: {
    clearEditor() {
      this.$refs.input.value = '';
      this.$refs.trix.editor.loadHTML('');
    }
  }
}
</script>

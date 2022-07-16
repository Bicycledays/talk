<script>
export default {
  emits: ['someEmit'],
  methods: {
    signal() {
      this.$emit('someEmit', 'hello from child')
    }
  }
}
</script>

<template>
  <h2>Child component</h2>
  <button @click="signal">signal</button>
</template>
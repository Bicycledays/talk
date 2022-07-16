<script>
export default {
  data() {
    return {
      text: ''
    }
  },
  // methods: {
  //   onInput(e) {
  //     this.text = e.target.value
  //   }
  // }
}
</script>

<template>
<!--  <input :value="text" @input="onInput" placeholder="Type here">-->
  <input v-model="text" placeholder="Type here">
  <p>{{ text }}</p>
</template>
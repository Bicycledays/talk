<script>
export default {
  mounted() {
    this.$refs.p.textContent = this.$refs.p.textContent + ' wold'
  }
}
</script>

<template>
  <p ref="p">hello</p>
</template>
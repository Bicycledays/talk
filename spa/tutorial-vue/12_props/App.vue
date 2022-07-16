<script>
import Child from './Child'

export default {
  components: {
    Child
  },
  data() {
    return {
      greeting: 'Hello from parent'
    }
  }
}
</script>

<template>
  <Child :msg="greeting"/>
</template>
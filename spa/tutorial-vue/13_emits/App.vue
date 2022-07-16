<script>
import Child from './Child'

export default {
  components: {
    Child
  },
  data() {
    return {
      childMsg1: 'No child msg yet',
      childMsg2: 'No child msg yet'
    }
  }
}
</script>

<template>
  <Child @someEmit="(msg) => childMsg1 = msg"/>
  <Child @someEmit="(msg) => childMsg2 = msg"/>
  <p>{{ childMsg1 }}</p>
  <p>{{ childMsg2 }}</p>
</template>
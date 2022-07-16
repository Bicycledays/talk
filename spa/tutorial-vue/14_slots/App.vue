<script>
import ChildComp from './ChildComp.vue'

export default {
  components: {
    ChildComp
  },
  data() {
    return {
      msg: 'from parent'
    }
  }
}
</script>

<template>
<!--  если ничего не передавать в дочерний, то
отобразится содержимое <slot>-->
  <ChildComp>{{msg}}</ChildComp>
</template>
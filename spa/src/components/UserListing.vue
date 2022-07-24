<template>
  <ul v-for="user in users" :key="user.id" class="list-group list-group-flush">
    <button @click="toProfile(user)" class="list-group-item list-group-item-action">{{ user.username }}</button>
  </ul>
</template>

<script>
import router from "../router";

export default {
  name: "Users",

  data() {
    return {
      users: null
    }
  },

  methods: {
    toProfile(user) {
      // todo посмотреть что уже есть в роутере
      console.log()
      router.push("/profile")
      // todo переходим в профиль пользователя
    },

    setUsers() {
      this.users = null
      this.$api
          .get("/users")
          .then((response) => {this.users = response.data.result});}
  },

  created() {
    this.setUsers()
  }
}

</script>
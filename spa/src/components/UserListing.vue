<template>
  <ul v-for="user in users" :key="user.id" class="list-group list-group-flush">
    <router-link to="/profile" class="list-group-item list-group-item-action">{{ user.username }}</router-link>
  </ul>
</template>

<script>
export default {
  name: "Users",

  data() {
    return {
      users: null
    }
  },

  methods: {

    setUsers() {
      this.users = null
      this.$api
          .get("/users")
          .then((response) => {
            this.users = response.data.result
          });
    }
  },

  created() {
    this.setUsers()
  }
}

</script>
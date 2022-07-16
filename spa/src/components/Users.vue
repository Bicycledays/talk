<template>
  <ul v-for="user in users" :key="user.id" class="list-group list-group-flush">
    <button @click="toProfile(user)" class="list-group-item list-group-item-action">{{ user.username }}</button>
  </ul>
</template>

<script>
const token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NTI5OTIyMDksImV4cCI6MTY1Mjk5NTgwOSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdGVyMiJ9.VhXt7LGYq0XIO6nc4L1lr5vyOkI7aF5z8QlTOxG670SdjnMhFzJG7ZArkDkoGmJn6pDcesgCqyp-Zow7DfFDNcyHKrwD8enCkMPKSu8zDpK36f5sRVmO-uNEH_t0j1Xd3Z0EtvlKHzzyV6XjQGlxcsjlKd1-HKYsOKIl0ZLz6n8jaMUtVmz0RFog0jYMdLC0OLiwOEs_a_gIlu4JZECnMol0QfOTG_0lP7TjW4fkQSzCWxCqUQnsvQA32YY9-7GERVk4tHMGcx86FIiuG0GUZ3zuZFrBMIIFAHa1s-AtR9TLSRaR3fcSBIi6Bd-fMVKQqY3m2TGvd2xADsHD8wd42g"

export default {
  name: "Users",

  data() {
    return {
      users: []
    }
  },

  methods: {
    toProfile(user) {
      // todo переходим в профиль пользователя
    },

    async setUsers() {
      this.users = null
      const res = await fetch(
          `/api/users`,
          {
            method: 'POST',
            mode: 'same-origin', // no-cors, *cors, same-origin
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            headers: new Headers({
              'Authorization': 'Bearer ' + token,
              'Content-Type': 'application/json'
            }),
            // body: JSON.stringify(data)
          }
      )

      let data = await res.json()
      this.users = data.result
    }
  },

  mounted() {
    this.setUsers()
  }
}

</script>
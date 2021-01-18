<template>
  <div>admin</div>
  <button @click="logout">выйти</button>
</template>

<script>
import { GQL_AUTH_TOKEN, GQL_USER_EMAIL, GQL_USER_ID } from '@/base/settings'

export default {
  name: 'Admin',
  setup () {
    function logout () {
      localStorage.setItem(GQL_AUTH_TOKEN, null)
      localStorage.setItem(GQL_USER_ID, null)
      localStorage.setItem(GQL_USER_EMAIL, null)
      location.href = '/'
    }

    return {
      logout
    }
  }
}
</script>

<style scoped>

</style>

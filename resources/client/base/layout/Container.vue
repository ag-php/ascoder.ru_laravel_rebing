<template>
  <main v-if="user">
    <router-view></router-view>
  </main>
  <div v-else-if="needLogin">
    <Login/>
  </div>
</template>

<script>
import Login from './Login'
import { useUser } from '../use/user'

export default {
  name: 'Container',
  components: {
    Login
  },
  setup () {
    const { fetch, user, needLogin } = useUser()

    fetch()

    return { user, needLogin }
  }
}
</script>

<template>
  <div v-if="user" class="back-container">
    <div class="menu-wrap">
      <a href="/">ascoder.ru</a>
      <hr>
      <ul>
        <li><router-link :to="{ name: 'Dashboard' }">Dashboard</router-link></li>
        <li><router-link :to="{ name: 'PostList' }">Посты</router-link></li>
        <li><router-link :to="{ name: 'CategoryList' }">Категории</router-link></li>
        <li><router-link :to="{ name: 'Tags' }">Теги</router-link></li>
        <li><a href="#" @click.prevent="logout">Выйти</a></li>
      </ul>
      <hr>
    </div>
    <div class="cont-wrap">
      <router-view></router-view>
    </div>
  </div>
  <div v-else-if="needLogin">
    <Login/>
  </div>
</template>

<script>
import Login from './Login'
import { useUser } from '@/base/use/user'
import { GQL_AUTH_TOKEN, GQL_USER_EMAIL, GQL_USER_ID } from '@/base/settings'

export default {
  name: 'BackContainer',
  components: {
    Login
  },
  setup () {
    const { fetch, user, needLogin } = useUser()

    fetch()

    function logout () {
      localStorage.setItem(GQL_AUTH_TOKEN, null)
      localStorage.setItem(GQL_USER_ID, null)
      localStorage.setItem(GQL_USER_EMAIL, null)
      location.href = '/'
    }

    return { user, needLogin, logout }
  }
}
</script>

<style lang="scss" scoped>
.back-container {
  display: flex;
  width: 100%;
  height: 100vh;
  .menu-wrap {
    display: inline-flex;
    flex-direction: column;
    width: 300px;
    height: 100%;
    padding: 1rem;
    background-color: #eef2f4;
  }
  .cont-wrap {
    display: inline-flex;
    flex-direction: column;
    width: 100%;
    height: 100%;
    padding: 1rem;
    background-color: white;
  }
}
</style>

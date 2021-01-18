<template>
  <main v-if="user">
    <div class="container-fluid">
      <div class="row">
        <div class="col-2">
          Админка
          <hr>
          <ul>
            <li><router-link :to="{ name: 'Admin' }">Главная</router-link></li>
            <li><router-link :to="{ name: 'AdminPosts' }">Посты</router-link></li>
            <li><router-link :to="{ name: 'AdminCategories' }">Категории</router-link></li>
            <li><router-link :to="{ name: 'AdminTags' }">Теги</router-link></li>
          </ul>

          <hr>
          <button class="btn btn-danger btn-sm" @click="logout">Выйти</button>
        </div>
        <div class="col-10">
          <router-view></router-view>
        </div>
      </div>
    </div>

  </main>
  <div v-else-if="needLogin">
    <Login/>
  </div>
</template>

<script>
import Login from './Login'
import { useUser } from '../use/user'
import { GQL_AUTH_TOKEN, GQL_USER_EMAIL, GQL_USER_ID } from '@/base/settings'

export default {
  name: 'Container',
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

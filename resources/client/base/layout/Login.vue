<template>
  <transition name="fade">
    <div class="row" :style="styleHeight">
      <div class="col">
        <form v-on:submit.prevent="login">
          <div :class="{snake: error}">
            <input type="email"
                   v-model="email"
                   placeholder="Email"
                   @input="error = false">
            <input type="password"
                   v-model="password"
                   placeholder="Password"
                   @input="error = false">
            <button type="submit">Login</button>
          </div>
        </form>
      </div>
    </div>
  </transition>
</template>

<script>
import { ApolloClient } from 'apollo-client'
import { BatchHttpLink } from 'apollo-link-batch-http'
import { InMemoryCache } from 'apollo-cache-inmemory'
import { GQL_AUTH_TOKEN, GQL_USER_EMAIL, GQL_USER_ID } from '@/base/settings'
import gql from 'graphql-tag'

export default {
  name: 'Login',
  data () {
    return {
      email: '',
      password: '',
      error: false,
      loading: false,
      windowHeight: 0
    }
  },
  computed: {
    styleHeight () {
      return { height: this.windowHeight + 'px' }
    }
  },
  methods: {
    login () {
      if (!this.email.length || !this.password.length) {
        this.startSnake()
        return
      }
      this.error = false
      this.loading = true

      const httpLinkLogin = new BatchHttpLink({
        uri: '/q/?',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json'
        }
      })

      const apolloClientLogin = new ApolloClient({
        link: httpLinkLogin,
        cache: new InMemoryCache(),
        shouldBatch: false,
        connectToDevTools: false
      })

      apolloClientLogin.mutate({
        mutation: gql`
          mutation ($email: String!, $password: String!) {
            Login (email: $email, password: $password) {
              id,
              email,
              access_token
            }
          }`,
        variables: {
          email: this.email,
          password: this.password
        }
      }).then((data) => {
        const response = data.data.Login
        localStorage.setItem(GQL_AUTH_TOKEN, response.access_token)
        localStorage.setItem(GQL_USER_ID, response.id)
        localStorage.setItem(GQL_USER_EMAIL, response.email)
        location.href = '/admin'
      }).catch(() => {
        this.startSnake()
        this.loading = false
      })
    },
    startSnake: function () {
      this.error = true
      setTimeout(this.stopSnake, 1200)
    },
    stopSnake: function () {
      this.error = false
    },
    onResize: function () {
      this.windowHeight = window.innerHeight
    }
  },
  mounted () {
    window.addEventListener('resize', this.onResize)
    this.onResize()
  },
  beforeUnmount () {
    window.removeEventListener('resize', this.onResize)
  }
}
</script>

<style type="scss" scoped>
.row {
  display: table;
  margin: 0 auto;
}

.col {
  display: table-cell;
  vertical-align: middle;
  text-align: center;
}

.error {
  text-align: center;
}

.snake {
  -webkit-animation: 1.2s ease-in-out 0s normal none infinite running snake-animation;
  -moz-animation: 1.2s ease-in-out 0s normal none infinite running snake-animation;
  -o-animation: 1.2s ease-in-out 0s normal none infinite running snake-animation;
  animation: 1.2s ease-in-out 0s normal none infinite running snake-animation;
}

@keyframes snake-animation {
  0%, 50%, 100% {
    transform: translateX(0);
    -webkit-transform: translateX(0);
    -moz-transform: translateX(0);
    -o-transform: translateX(0);
    -ms-transform: translateX(0);
  }
  10%, 30% {
    transform: translateX(-10px);
    -webkit-transform: translateX(-10px);
    -moz-transform: translateX(-10px);
    -o-transform: translateX(-10px);
    -ms-transform: translateX(-10px);
  }
  20%, 40% {
    transform: translateX(10px);
    -webkit-transform: translateX(10px);
    -moz-transform: translateX(10px);
    -o-transform: translateX(10px);
    -ms-transform: translateX(10px);
  }
}
</style>

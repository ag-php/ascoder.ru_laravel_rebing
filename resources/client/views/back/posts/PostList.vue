<template>
  <Preloader v-if="loading"/>
  <div v-else>
    <div>Посты: [{{ total }}]</div>
    <hr>
    <router-link class="btn btn-success btn-sm" :to="{ name: 'PostEdit', params: { slug: 'add' }}">Добавить пост</router-link>
    <hr>
    <table class="table table-bordered table-sm">
      <thead class="thead-light">
      <tr>
        <th></th>
        <th>ID</th>
        <th>Название</th>
        <th>slug</th>
        <th>Создан</th>
        <th>Обновлен</th>
        <th>Активнен</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="p in posts">
        <th><router-link :to="{ name: 'PostEdit', params: { slug: p.slug }}"><VIcon name="cilPencil"/></router-link></th>
        <td>{{ p.id }}</td>
        <td><router-link :to="'/posts/' + p.slug">{{ p.name }}</router-link></td>
        <td>{{ p.slug }}</td>
        <td>{{ p.created_at }}</td>
        <td>{{ p.updated_at }}</td>
        <td>{{ p.active }}</td>
        <th><a href="#" class="text-danger" @click.prevent="del(p.id)"><VIcon name="cilTrash"/></a></th>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { apolloClient, apolloClientNoAuth } from '@/base/apollo'
import { POST_LIST, POST_DELETE } from '@/gql/post'
import Preloader from '@/base/components/preloader/Preloader'
import VIcon from '@/base/components/icon/VIcon'

export default {
  name: 'PostList',
  components: { VIcon, Preloader },
  setup () {
    const loading = ref(true)

    const total = ref(null)
    const posts = ref(null)

    function fetch () {
      loading.value = true
      apolloClientNoAuth.query({
        query: POST_LIST,
        fetchPolicy: 'no-cache',
        variables: {
          page: 1,
          size: 10
        }
      }).then(res => {
        const result = res.data.PostList
        total.value = result.total
        posts.value = result.data
        loading.value = false
      })
    }

    function del (id) {
      apolloClient.mutate({
        mutation: POST_DELETE,
        variables: {
          id
        }
      }).then(() => {
        fetch()
      })
    }

    onMounted(() => {
      fetch()
    })

    return {
      loading,
      total,
      posts,
      del
    }
  }
}
</script>

<style scoped>

</style>

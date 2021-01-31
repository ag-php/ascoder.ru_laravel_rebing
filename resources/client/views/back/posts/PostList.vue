<template>
  <Preloader v-if="loading"/>
  <div v-else>
    <div>Посты [{{ total }}]</div>
    <hr>
    <router-link :to="{ name: 'PostEdit', params: { slug: 'add' }}">Добавить пост</router-link>
    <hr>
    <table class="table table-bordered table-sm">
      <thead class="thead-light">
      <tr>
        <th>ID</th>
        <th>slug</th>
        <th>Название</th>
        <th>Создан</th>
        <th>Обновлен</th>
        <th>Активнен</th>
        <th>#</th>
        <th>#</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="c in posts">
        <td>{{ c.id }}</td>
        <td>{{ c.slug }}</td>
        <td>{{ c.name }}</td>
        <td>{{ c.created_at }}</td>
        <td>{{ c.updated_at }}</td>
        <td>{{ c.active }}</td>
        <th><router-link :to="{ name: 'PostEdit', params: { slug: c.slug }}">ред</router-link></th>
        <th><a href="#" @click.prevent="del(c.id)">удал</a></th>
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

export default {
  name: 'PostList',
  components: { Preloader },
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

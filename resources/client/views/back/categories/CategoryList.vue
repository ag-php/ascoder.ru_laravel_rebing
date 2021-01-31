<template>
  <Preloader v-if="loading"/>
  <div v-else>
    <div>Категории: [{{ total }}]</div>
    <hr>
    <router-link class="btn btn-success btn-sm" :to="{ name: 'CategoryEdit', params: { slug: 'add' }}">Добавить категорию</router-link>
    <hr>
    <table class="table table-bordered table-sm">
      <thead class="thead-light">
      <tr>
        <th></th>
        <th>ID</th>
        <th>Название</th>
        <th>slug</th>
        <th>Создана</th>
        <th>Обновлена</th>
        <th>Активна</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="c in categories">
        <th><router-link :to="{ name: 'CategoryEdit', params: { slug: c.slug }}"><VIcon name="cilPencil"/></router-link></th>
        <td>{{ c.id }}</td>
        <td>{{ c.name }}</td>
        <td>{{ c.slug }}</td>
        <td>{{ c.created_at }}</td>
        <td>{{ c.updated_at }}</td>
        <td>{{ c.active }}</td>
        <th><a href="#" class="text-danger" @click.prevent="del(c.id)"><VIcon name="cilTrash"/></a></th>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { apolloClient, apolloClientNoAuth } from '@/base/apollo'
import { CATEGORY_LIST, CATEGORY_DELETE } from '@/gql/category'
import Preloader from '@/base/components/preloader/Preloader'
import VIcon from '@/base/components/icon/VIcon'

export default {
  name: 'CategoryList',
  components: { VIcon, Preloader },
  setup () {
    const loading = ref(true)
    const total = ref(null)
    const categories = ref(null)

    function fetch () {
      loading.value = true
      apolloClientNoAuth.query({
        query: CATEGORY_LIST,
        fetchPolicy: 'no-cache',
        variables: {
          page: 1,
          size: 10
        }
      }).then(res => {
        const result = res.data.CategoryList
        total.value = result.total
        categories.value = result.data
        loading.value = false
      })
    }

    function del (id) {
      apolloClient.mutate({
        mutation: CATEGORY_DELETE,
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
      categories,
      del
    }
  }
}
</script>

<style scoped>

</style>

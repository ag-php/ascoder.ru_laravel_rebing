<template>
  <div>Категория {{ category.name }}</div>
  <hr>
  <input type="text" v-model="category.slug"/>
  <input type="text" v-model="category.name"/>
  <input type="checkbox" :checked="category.active" @input="category.active =! category.active"/>
  <button @click="push">Сохранить</button>
</template>

<script>
import { useRoute, useRouter } from 'vue-router'
import { reactive, onMounted } from 'vue'
import { apolloClient, apolloClientNoAuth } from '@/base/apollo'
import { CATEGORY, CATEGORY_PUSH } from '@/gql/category'

export default {
  name: 'CategoryEdit',
  setup () {
    const route = useRoute()
    const router = useRouter()

    const category = reactive({
      slug: null,
      name: null,
      active: true
    })

    function fetch () {
      apolloClientNoAuth.query({
        query: CATEGORY,
        fetchPolicy: 'no-cache',
        variables: {
          slug: category.slug
        }
      }).then(res => {
        const result = res.data.Category
        category.slug = result.slug
        category.name = result.name
        category.active = result.active
      })
    }

    function push () {
      apolloClient.mutate({
        mutation: CATEGORY_PUSH,
        variables: category
      }).then(() => {
        router.back()
      })
    }

    onMounted(() => {
      if (route.params.slug !== 'add') {
        category.slug = route.params.slug
        fetch()
      }
    })

    return {
      category,
      push
    }
  }
}
</script>

<style scoped>

</style>

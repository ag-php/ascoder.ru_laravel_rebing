<template>
  <div>Категория: <b>{{ category.name }}</b></div>
  <hr>
  <form>
    <div class="form-check">
      <input type="checkbox" class="form-check-input" id="postActive" :checked="category.active" @input="category.active =! category.active">
      <label class="form-check-label" for="postActive">Активна</label>
    </div>
    <div class="form-group">
      <label for="postName">Название</label>
      <input type="text" class="form-control" id="postName" v-model="category.name">
    </div>
    <div class="form-group">
      <label for="postSlug">slug</label>
      <input type="text" class="form-control" id="postSlug" v-model="category.slug">
    </div>
    <hr>
    <button class="btn btn-primary btn-sm" @click="push">Сохранить</button>
  </form>
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

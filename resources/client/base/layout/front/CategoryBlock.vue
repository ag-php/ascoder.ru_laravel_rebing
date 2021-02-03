<template>
  <ul class="list-group" v-if="categories.length">
    <li v-for="category in categories" class="list-group-item">
      <router-link :to="{ name: 'CategoryPosts', params: { category: category.slug }}">{{ category.name }}</router-link>
      <span class="text-muted small float-end">{{ category.posts_count }}</span>
    </li>
  </ul>
</template>

<script>
import { ref, onMounted } from 'vue'
import { apolloClientNoAuth } from '@/base/apollo'
import { CATEGORY_LIST } from '@/gql/category'

export default {
  name: 'SidebarBlock',
  setup () {
    const categories = ref([])

    function fetch () {
      apolloClientNoAuth.query({
        query: CATEGORY_LIST,
        fetchPolicy: 'cache-first',
        variables: {
          page: 1,
          size: 10
        }
      }).then(res => {
        categories.value = res.data.CategoryList.data
      })
    }

    onMounted(() => {
      fetch()
    })

    return {
      categories
    }
  }
}
</script>

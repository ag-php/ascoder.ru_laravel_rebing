<template>
  <div class="categories-block" v-if="categories.length">
    <div class="cats-title">Разделы</div>
    <router-link class="category-link" :to="{ name: 'CategoryPosts', params: { category: c.slug }}" v-for="c in categories">{{ c.name }}</router-link>
  </div>
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

<style lang="scss" scoped>
.categories-block {
  display: flex;
  flex-direction: column;
  width: 100%;
  padding: 1rem;
  background-color: white;
  border: 1px solid #ccc;
  .cats-title {
    font-family: Verdana;
    font-weight: 700;
    color: #0071bc;
    border-bottom: 1px solid #0071bc;
    margin-bottom: 8px;
  }
  .category-link {
    display: block;
    width: 100%;
    height: 50%;
    color: #535c69;
    font-family: Verdana;
    font-weight: 700;
    text-decoration: none;
    &:hover {
      color: black;
    }
  }
}
</style>

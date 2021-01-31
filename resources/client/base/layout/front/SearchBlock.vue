<template>
  <div class="search-block">
    <input type="text" class="form-control" placeholder="Что найти?" v-model="search"/>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { apolloClientNoAuth } from '@/base/apollo'

export default {
  name: 'SearchBlock',
  setup () {
    const search = ref('')

    // function fetch () {
    //   apolloClientNoAuth.query({
    //     query: CATEGORY_LIST,
    //     fetchPolicy: 'cache-first',
    //     variables: {
    //       page: 1,
    //       size: 10
    //     }
    //   }).then(res => {
    //     categories.value = res.data.CategoryList.data
    //   })
    // }

    onMounted(() => {

    })

    return {
      search
    }
  }
}
</script>

<style lang="scss" scoped>
.search-block {
  width: 100%;
  padding: 1rem;
  border-bottom: 1px solid #0071bc;
  .search-field {
    display: block;
    width: 100%;
    color: #ccc;
  }
}
</style>

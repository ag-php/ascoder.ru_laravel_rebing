<template>
  <input type="text" class="form-control" placeholder="Что найти?" v-model="search"/>
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

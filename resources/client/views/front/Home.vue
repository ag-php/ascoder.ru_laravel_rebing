<template>
  <Preloader v-if="!loaded"/>
  <div class="post-wrap" v-else>
    <div class="post-block" v-for="p in posts">
      <div class="post-header">
        <VIcon name="cilCalendar"/>
        <p>{{ formatDate(p.created_at) }}</p>
        <div class="cat-small">{{ p.category.name }}</div>
      </div>
      <div class="post-body">
        <div class="post-title"><router-link :to="{ name: 'Post', params: { slug: p.slug }}">{{ p.name }}</router-link></div>
        <div class="post-text" v-html="p.description"></div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { apolloClientNoAuth } from '@/base/apollo'
import { POST_LIST } from '@/gql/post'
import VIcon from '@/base/components/icon/VIcon'
import moment from 'moment'
import Preloader from '@/base/components/preloader/Preloader'

export default {
  name: 'Home',
  components: { Preloader, VIcon },
  setup () {
    const loaded = ref(false)
    const posts = ref([])

    function fetch () {
      loaded.value = false
      apolloClientNoAuth.query({
        query: POST_LIST,
        fetchPolicy: 'cache-first',
        variables: {
          page: 1,
          size: 10
        }
      }).then(res => {
        const result = res.data.PostList
        posts.value = result.data
        loaded.value = true
      })
    }

    onMounted(() => {
      fetch()
    })

    function formatDate (date) {
      return moment(date).format('DD.MM.YYYY')
    }

    return {
      loaded,
      formatDate,
      posts
    }
  }
}
</script>

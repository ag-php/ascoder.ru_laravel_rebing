<template>
  <Preloader v-if="!loaded"/>
  <div v-else>
    <div class="card mb-2" v-for="post in posts">
      <div class="card-body">
        <div class="text-muted h7 mb-2">
          {{formatDate(post.created_at)}}
          <span class="me-2">|</span>
          <span>{{ post.category.name}}</span>
        </div>
        <router-link class="card-link" :to="{ name: 'Post', params: { slug: post.slug }}"><h5 class="card-title">{{ post.name }}</h5></router-link>
        <p class="card-text">
          {{ post.description }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { apolloClientNoAuth } from '@/base/apollo'
import { POST_LIST } from '@/gql/post'
import moment from 'moment'
import Preloader from '@/base/components/preloader/Preloader'

export default {
  name: 'Home',
  components: { Preloader },
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

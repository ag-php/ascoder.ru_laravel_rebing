<template>
  <Preloader v-if="!loaded"/>
  <div v-else>
    <div v-if="!posts.length" class="alert bg-light text-center"><i>Ничего не найдено</i></div>
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
import { ref, watchEffect, computed } from 'vue'
import { apolloClientNoAuth } from '@/base/apollo'
import { POST_LIST } from '@/gql/post'
import moment from 'moment'
import Preloader from '@/base/components/preloader/Preloader'

export default {
  name: 'CategoryPosts',
  components: { Preloader },
  props: {
    category: {
      type: String,
      required: true
    }
  },
  setup (props) {
    const loaded = ref(false)
    const posts = ref([])

    const cat = computed(() => props.category)

    function fetch () {
      loaded.value = false
      apolloClientNoAuth.query({
        query: POST_LIST,
        fetchPolicy: 'cache-first',
        variables: {
          page: 1,
          size: 10,
          category: cat.value
        }
      }).then(res => {
        const result = res.data.PostList
        posts.value = result.data
        loaded.value = true
      })
    }

    watchEffect(() => {
      if (cat.value) {
        fetch()
      }
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

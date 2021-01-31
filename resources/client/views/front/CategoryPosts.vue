<template>
  <Preloader v-if="!loaded"/>
  <div class="post-wrap" v-else>
    <div class="post-block" v-for="p in posts">
      <div class="post-header">
        <VIcon name="cilCalendar"/>
        <p>{{ formatDate(p.created_at) }}</p>
        <router-link class="cat-small" :to="{ name: 'CategoryPosts', params: { category: p.category.slug }}">{{ p.category.name }}</router-link>
      </div>
      <div class="post-body">
        <div class="post-title"><router-link :to="{ name: 'Post', params: { slug: p.slug }}">{{ p.name }}</router-link></div>
        <div class="post-text" v-html="p.description"></div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, watchEffect, computed } from 'vue'
import { apolloClientNoAuth } from '@/base/apollo'
import { POST_LIST } from '@/gql/post'
import VIcon from '@/base/components/icon/VIcon'
import moment from 'moment'
import Preloader from '@/base/components/preloader/Preloader'

export default {
  name: 'CategoryPosts',
  components: { Preloader, VIcon },
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

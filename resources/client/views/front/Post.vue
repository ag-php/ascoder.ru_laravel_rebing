<template>
  <Preloader v-if="!post"/>
  <div v-else class="card mb-2">
    <div class="card-body">
      <div class="text-muted h7 mb-2">
        {{formatDate(post.created_at)}}
        <span class="me-2">|</span>
        <span>{{ post.category.name}}</span>
      </div>
      <h1 class="card-title">{{ post.name }}</h1>
      <hr>
      <div class="card-text" v-html="post.text">
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, nextTick } from 'vue'
import { apolloClientNoAuth } from '@/base/apollo'
import { POST } from '@/gql/post'
import moment from 'moment'
import Preloader from '@/base/components/preloader/Preloader'

import hljs from 'highlight.js/lib/core'
import java from 'highlight.js/lib/languages/java'
hljs.registerLanguage('java', java)

export default {
  name: 'Post',
  components: { Preloader },
  props: {
    slug: {
      type: String,
      required: true
    }
  },
  setup (props) {
    const post = ref(null)
    const postBody = ref(null)

    function fetch () {
      apolloClientNoAuth.query({
        query: POST,
        fetchPolicy: 'cache-first',
        variables: {
          slug: props.slug
        }
      }).then(res => {
        post.value = res.data.Post
        nextTick(() => {
          document.querySelectorAll('code').forEach((block) => {
            hljs.highlightBlock(block)
          })
        })
      })
    }

    onMounted(() => {
      fetch()
    })

    function formatDate (date) {
      return moment(date).format('DD.MM.YYYY')
    }

    return {
      formatDate,
      post,
      postBody
    }
  }
}
</script>

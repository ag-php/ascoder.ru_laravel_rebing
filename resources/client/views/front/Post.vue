<template>
  <Preloader v-if="!post"/>
  <div class="post-wrap" v-else>
  <div class="post-block">
    <div class="post-header">
      <VIcon name="cilCalendar"/>
      <p>{{ formatDate(post.created_at) }}</p>
      <div class="cat-small">{{ post.category.name }}</div>
    </div>
    <div class="post-body">
      <h1 class="post-title">{{ post.name }}</h1>
      <hr>
      <div class="post-text" v-html="post.text"></div>
    </div>
  </div>
  </div>
</template>

<script>
import { ref, onMounted, nextTick } from 'vue'
import { apolloClientNoAuth } from '@/base/apollo'
import { POST } from '@/gql/post'
import VIcon from '@/base/components/icon/VIcon'
import moment from 'moment'
import hljs from 'highlight.js'
import Preloader from '@/base/components/preloader/Preloader'

export default {
  name: 'Post',
  components: { Preloader, VIcon },
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

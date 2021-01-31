<template>
  <div>Пост {{ post.name }}</div>
  <hr>
  <form>
    <div class="form-check">
      <input type="checkbox" class="form-check-input" id="postActive" :checked="post.active" @input="post.active =! post.active">
      <label class="form-check-label" for="postActive">Активен</label>
    </div>
    <div class="form-group">
      <label for="categories">Категория</label>
      <select class="form-control" id="categories" v-model="post.categoryId">
        <option v-for="c in categories" :value="c.value">{{ c.label }}</option>
      </select>
    </div>
    <div class="form-group">
      <label for="postName">Название</label>
      <input type="text" class="form-control" id="postName" v-model="post.name">
    </div>
    <div class="form-group">
      <label for="postDescription">Описание</label>
      <textarea class="form-control" id="postDescription" v-model="post.description" cols="3"></textarea>
    </div>
    <div class="form-group">
      <label for="postSlug">slug</label>
      <input type="text" class="form-control" id="postSlug" v-model="post.slug">
    </div>
    <hr>
    <div class="form-group">
      <label for="postText">Текст</label>
      <textarea class="form-control" id="postText" v-model="post.text" rows="10"></textarea>
    </div>
    <hr>
    <button class="btn btn-primary btn-sm" @click="push">Сохранить</button>
  </form>
</template>

<script>
import { useRoute, useRouter } from 'vue-router'
import { ref, reactive, onMounted } from 'vue'
import { apolloClient, apolloClientNoAuth } from '@/base/apollo'
import { POST, POST_PUSH } from '@/gql/post'
import { CATEGORY_LIST } from '@/gql/category'

export default {
  name: 'PostEdit',
  setup () {
    const route = useRoute()
    const router = useRouter()

    const post = reactive({
      slug: null,
      name: null,
      text: null,
      description: null,
      active: true,
      categoryId: null
    })

    function fetch () {
      apolloClientNoAuth.query({
        query: POST,
        fetchPolicy: 'no-cache',
        variables: {
          slug: post.slug
        }
      }).then(res => {
        const result = res.data.Post
        post.slug = result.slug
        post.name = result.name
        post.text = result.text
        post.description = result.description
        post.active = result.active
        post.categoryId = result.categoryId
      })
    }

    const categories = ref([])

    function fetchCategories () {
      apolloClientNoAuth.query({
        query: CATEGORY_LIST,
        fetchPolicy: 'no-cache',
        variables: {
          page: 1,
          size: 9999
        }
      }).then(res => {
        categories.value = res.data.CategoryList.data.map(x => {
          return { label: x.name, value: x.id }
        })
      })
    }

    function push () {
      apolloClient.mutate({
        mutation: POST_PUSH,
        variables: post
      }).then(() => {
        router.back()
      })
    }

    onMounted(() => {
      if (route.params.slug !== 'add') {
        post.slug = route.params.slug
        fetch()
      }
      fetchCategories()
    })

    return {
      categories,
      post,
      push
    }
  }
}
</script>

<style scoped>

</style>

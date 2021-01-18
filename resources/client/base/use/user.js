import { ref } from 'vue'
import { CURRENT_USER } from '@/gql/user'
import { useApolloClient } from '@vue/apollo-composable'

const user = ref(null)

const useUser = () => {
  const loading = ref(false)
  const needLogin = ref(false)

  const apollo = useApolloClient()

  const fetch = () => {
    user.value = null
    loading.value = true
    needLogin.value = false
    apollo.client.query({
      query: CURRENT_USER,
      variables: {},
      fetchPolicy: 'no-cache'
    }).then(({ data }) => {
      loading.value = false
      user.value = data.CurrentUser
    }).catch(() => {
      loading.value = false
      needLogin.value = true
    })
  }

  return {
    fetch,
    user,
    loading,
    needLogin
  }
}

export {
  useUser
}

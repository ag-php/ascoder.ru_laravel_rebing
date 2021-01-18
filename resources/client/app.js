import { createApp, defineComponent } from 'vue'
import router from './router'
import './styles'

import { DefaultApolloClient } from '@vue/apollo-composable'
import { apolloClient } from '@/base/apollo'

const app = createApp(defineComponent({
  name: 'App',
  template: '<router-view></router-view>'
}))

app.use(router)
app.provide(DefaultApolloClient, apolloClient)
app.mount('#app')

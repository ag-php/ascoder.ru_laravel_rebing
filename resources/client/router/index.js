import { createRouter, createWebHistory } from 'vue-router'

import Home from '@/views/Index'
import Container from '@/base/layout/Container'

const routes = [
  {
    path: '/',
    component: Home
  },
  {
    path: '/admin',
    component: Container,
    children: [
      {
        path: '',
        component: () => import(/* webpackChunkName: "admin" */'@/views/admin/Index')
      }
    ]
  },
  {
    path: '/*',
    component: () => import(/* webpackChunkName: "not-found" */'@/views/NotFound')
  }
]

const router = createRouter({
  history: createWebHistory('/'),
  linkActiveClass: 'active',
  scrollBehavior: () => ({ y: 0 }),
  routes
})

export default router

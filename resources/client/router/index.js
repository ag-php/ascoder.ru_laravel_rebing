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
        name: 'Admin',
        component: () => import(/* webpackChunkName: "admin" */'@/views/admin/Index')
      },
      {
        path: 'posts',
        name: 'AdminPosts',
        component: () => import(/* webpackChunkName: "admin" */'@/views/admin/AdminPosts')
      },
      {
        path: 'categories',
        name: 'AdminCategories',
        component: () => import(/* webpackChunkName: "admin" */'@/views/admin/AdminCategories')
      },
      {
        path: 'tags',
        name: 'AdminTags',
        component: () => import(/* webpackChunkName: "admin" */'@/views/admin/AdminTags')
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

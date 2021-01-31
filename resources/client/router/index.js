import { createRouter, createWebHistory } from 'vue-router'

import Home from '@/views/front/Home'
import Post from '@/views/front/Post'
import FrontContainer from '@/base/layout/front/FrontContainer'

const routes = [
  {
    path: '/',
    component: FrontContainer,
    children: [
      {
        path: '',
        name: 'Home',
        component: Home
      },
      {
        props: true,
        path: 'posts/:slug',
        name: 'Post',
        component: Post
      }
    ]
  },
  {
    path: '/back',
    component: () => import(/* webpackChunkName: "admin" */'@/base/layout/back/BackContainer'),
    children: [
      {
        path: '',
        name: 'Dashboard',
        component: () => import(/* webpackChunkName: "admin" */'@/views/back/Dashboard')
      },
      {
        path: 'posts',
        component: { template: '<router-view></router-view>' },
        children: [
          {
            path: '',
            name: 'PostList',
            component: () => import(/* webpackChunkName: "admin" */'@/views/back/posts/PostList')
          },
          {
            path: ':slug',
            name: 'PostEdit',
            component: () => import(/* webpackChunkName: "admin" */'@/views/back/posts/PostEdit')
          }
        ]
      },
      {
        path: 'categories',
        component: { template: '<router-view></router-view>' },
        children: [
          {
            path: '',
            name: 'CategoryList',
            component: () => import(/* webpackChunkName: "admin" */'@/views/back/categories/CategoryList')
          },
          {
            path: ':slug',
            name: 'CategoryEdit',
            component: () => import(/* webpackChunkName: "admin" */'@/views/back/categories/CategoryEdit')
          }
        ]
      },
      {
        path: 'tags',
        name: 'Tags',
        component: () => import(/* webpackChunkName: "admin" */'@/views/back/Tags')
      }
    ]
  },
  {
    path: '/:catchAll(.*)',
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

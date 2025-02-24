import { createRouter, createWebHistory } from 'vue-router'
import PostList from '../views/PostList.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: PostList,
      meta: {
        title: 'Posts'
      }
    }
  ]
})

router.beforeEach((to, from, next) => {
  document.title = `${to.meta.title} - Rich Text Editor` || 'Rich Text Editor'
  next()
})

export default router

import { createRouter, createWebHistory } from 'vue-router'
import productIndex from '../products/index.vue'
import productNew from '../products/new.vue'
import productEdit from '../products/edit.vue'
import notFound from '../errors/404.vue'
const routes = [
   {
      path: '/',
      component: productIndex
   },
   {
      path: '/product/new',
      component: productNew
   },
   {
      path: '/product/edit/:id',
      component: productEdit,
      props:true
   },
   {
      path: '/:pathMatch(.*)*',
      component: notFound
   }
]

const router = createRouter({
   history: createWebHistory(process.env.BASE_URL),
   routes,
})
export default router
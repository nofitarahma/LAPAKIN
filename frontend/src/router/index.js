import { createRouter, createWebHistory } from 'vue-router'
import { setRouter } from '../api'

const routes = [
  { path: '/',               redirect: '/products' },
  { path: '/login',          component: () => import('../views/LoginView.vue') },
  { path: '/products',       component: () => import('../views/ProductsView.vue') },
  { path: '/products/:id',   component: () => import('../views/ProductDetailView.vue') },
  { path: '/cart',     component: () => import('../views/CartView.vue'),     meta: { requiresAuth: true } },
  { path: '/checkout', component: () => import('../views/CheckoutView.vue'), meta: { requiresAuth: true } },
  { path: '/payment/transfer/:orderId', component: () => import('../views/PaymentTransferView.vue'), meta: { requiresAuth: true } },
  { path: '/admin/products', component: () => import('../views/admin/AdminProducts.vue'), meta: { requiresAuth: true, requiresAdmin: true } },
  { path: '/admin/products/create', component: () => import('../views/admin/AdminProductForm.vue'), meta: { requiresAuth: true, requiresAdmin: true } },
  { path: '/admin/products/:id/edit', component: () => import('../views/admin/AdminProductForm.vue'), meta: { requiresAuth: true, requiresAdmin: true } },
  { path: '/admin/payments', component: () => import('../views/admin/AdminPaymentConfirmation.vue'), meta: { requiresAuth: true, requiresAdmin: true } },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

setRouter(router)

router.beforeEach((to) => {
  const token = localStorage.getItem('token')
  const user = JSON.parse(localStorage.getItem('user') || 'null')
  
  if (to.meta.requiresAuth && !token) {
    return { path: '/login' }
  }
  
  if (to.meta.requiresAdmin && (!token || user?.role !== 'admin')) {
    return { path: '/login' }
  }
})

export default router

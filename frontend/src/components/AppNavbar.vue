<template>
  <header class="navbar">
    <div class="container navbar-inner">
      <div class="brand">
        <div class="brand-icon">L</div>
        <div class="brand-copy">
          <h1>LAPAKIN</h1>
          <p>E-Commerce Lokal Indonesia</p>
        </div>
      </div>

      <nav class="nav-links">
        <RouterLink to="/products" :class="{ active: route.path === '/products' }">Produk</RouterLink>
        <a href="#">Kategori</a>
        <a href="#">Promo</a>
        <a href="#">Tentang</a>
      </nav>

      <div class="nav-actions">
        <button class="icon-button">♡</button>
        <RouterLink to="/cart" class="icon-button">🛒</RouterLink>
        <button v-if="auth.isLoggedIn" class="login-btn" @click="handleLogout">
          {{ auth.user?.name }}
        </button>
        <RouterLink v-else to="/login" class="login-btn">Masuk</RouterLink>
      </div>
    </div>
  </header>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const route  = useRoute()
const router = useRouter()
const auth   = useAuthStore()

async function handleLogout() {
  await auth.logout()
  router.push('/login')
}
</script>

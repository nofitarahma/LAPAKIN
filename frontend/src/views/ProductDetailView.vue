<template>
  <div class="page-bg"></div>
  <AppNavbar />

  <main>
    <section class="detail-section">
      <div class="container">
        <RouterLink to="/products" class="back-link">← Kembali ke Katalog</RouterLink>

        <p v-if="loading" class="empty-products">Memuat produk...</p>
        <p v-else-if="!product" class="empty-products">Produk tidak ditemukan.</p>

        <div v-else class="detail-container">
          <div class="detail-image">
            <img :src="imgSrc(product.image)" :alt="product.productName" />
          </div>
          <div class="detail-info">
            <h1>{{ product.productName }}</h1>
            <div class="detail-meta">
              <span>⭐ {{ product.rating }}</span>
              <span>{{ product.category }}</span>
              <span>📍 {{ product.location }}</span>
            </div>
            <div class="detail-price">{{ formatPrice(product.price) }}</div>
            <p class="detail-description">{{ product.description }}</p>
            <div class="detail-stock">
              <strong>Stok Tersedia:</strong>
              <span>{{ product.stock }} unit</span>
            </div>
            <div class="detail-actions">
              <button class="btn btn-outline">❤ Wishlist</button>
              <button class="btn btn-primary" @click="addToCart">🛒 Tambah ke Keranjang</button>
            </div>
            <div class="detail-info-box">
              <strong>Informasi Penting:</strong><br />
              Produk ini dijamin original dan berkualitas. Kami menyediakan garansi kepuasan pelanggan 100%.
              Jika ada pertanyaan, hubungi customer service kami.
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <AppFooter />
  <ToastNotif :message="toast.message" :type="toast.type" :visible="toast.visible" />
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { api } from '../api'
import { useAuthStore } from '../stores/auth'
import AppNavbar from '../components/AppNavbar.vue'
import AppFooter from '../components/AppFooter.vue'
import ToastNotif from '../components/ToastNotif.vue'

const route   = useRoute()
const router  = useRouter()
const auth    = useAuthStore()
const product = ref(null)
const loading = ref(true)
const toast   = reactive({ visible: false, message: '', type: 'success' })

const BASE_IMG = 'http://localhost:8000/storage/'
function imgSrc(image) {
  if (!image) return 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=80'
  return image.startsWith('http') ? image : BASE_IMG + image
}
function formatPrice(price) {
  return 'Rp' + Number(price).toLocaleString('id-ID')
}

function showToast(message, type = 'success') {
  toast.message = message
  toast.type    = type
  toast.visible = true
  setTimeout(() => toast.visible = false, 3000)
}

async function addToCart() {
  if (!auth.isLoggedIn) {
    router.push('/login')
    return
  }
  try {
    await api.post('/cart/add', { product_id: product.value.id, quantity: 1 })
    showToast('Produk ditambahkan ke keranjang!')
  } catch (err) {
    showToast(err.data?.message || 'Gagal menambahkan ke keranjang', 'error')
  }
}

onMounted(async () => {
  try {
    product.value = await api.get(`/products/${route.params.id}`)
  } catch (_) {
    product.value = null
  } finally {
    loading.value = false
  }
})
</script>

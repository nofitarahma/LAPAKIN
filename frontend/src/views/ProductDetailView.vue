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
              <span :class="{ 'stock-empty': product.stock <= 0, 'stock-low': product.stock > 0 && product.stock < 10 }">
                {{ product.stock <= 0 ? 'Habis' : `${product.stock} unit` }}
              </span>
            </div>
            <div class="detail-actions">
              <button class="btn btn-outline">❤ Wishlist</button>
              <button 
                class="btn" 
                :class="product.stock > 0 ? 'btn-primary' : 'btn-disabled'"
                @click="addToCart"
                :disabled="product.stock <= 0"
              >
                🛒 {{ product.stock <= 0 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
              </button>
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
  
  if (product.value.stock <= 0) {
    showToast('Produk ini sedang habis stok', 'error')
    return
  }
  
  try {
    await api.post('/cart/add', { product_id: product.value.id, quantity: 1 })
    showToast('Produk ditambahkan ke keranjang!')
  } catch (err) {
    const message = err.response?.data?.message || err.message || 'Gagal menambahkan ke keranjang'
    showToast(message, 'error')
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

<style scoped>
.btn-disabled {
  background: rgba(156, 163, 175, 0.3) !important;
  color: rgba(107, 114, 128, 0.8) !important;
  border: 1px solid rgba(156, 163, 175, 0.3) !important;
  cursor: not-allowed !important;
}

.btn-disabled:hover {
  background: rgba(156, 163, 175, 0.3) !important;
  transform: none !important;
}

.stock-empty {
  color: #dc2626;
  font-weight: 600;
}

.stock-low {
  color: #f59e0b;
  font-weight: 600;
}
</style>

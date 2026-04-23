<template>
  <div class="page-bg"></div>
  <AppNavbar />

  <main>
    <section class="catalog-section">
      <div class="container">
        <div class="section-top">
          <div>
            <span class="section-label">KATALOG PRODUK</span>
            <h2>Produk Pilihan untuk Customer</h2>
          </div>
          <p>Temukan produk lokal terbaik pilihan kami dari berbagai kategori dengan harga terjangkau.</p>
        </div>

        <div class="toolbar">
          <div class="search-area">
            <input v-model="filters.search" type="text" placeholder="Cari produk, kategori, atau toko..." @keyup.enter="loadProducts" />
          </div>
          <div class="toolbar-controls">
            <select v-model="filters.category">
              <option value="">Semua Kategori</option>
              <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
            </select>
            <select v-model="filters.sort">
              <option value="">Urutkan Produk</option>
              <option value="Harga Terendah">Harga Terendah</option>
              <option value="Harga Tertinggi">Harga Tertinggi</option>
              <option value="Rating Tertinggi">Rating Tertinggi</option>
            </select>
            <button class="btn btn-primary" @click="loadProducts()">Terapkan</button>
          </div>
        </div>

        <div class="catalog-layout">
          <aside class="sidebar">
            <div class="side-card">
              <h3>Kategori</h3>
              <ul>
                <li v-for="cat in categories" :key="cat">
                  <a href="#" @click.prevent="filterByCategory(cat)">{{ cat }}</a>
                </li>
              </ul>
            </div>
            <div class="side-card promo-panel">
              <span class="promo-pill">PROMO KHUSUS</span>
              <h3>Belanja lokal lebih hemat</h3>
              <p>Dapatkan penawaran spesial untuk produk pilihan minggu ini.</p>
              <a href="#" class="btn btn-dark">Lihat Promo</a>
            </div>
          </aside>

          <div class="product-grid">
            <p v-if="loading" class="empty-products">Memuat produk...</p>
            <p v-else-if="!products.length" class="empty-products">Tidak ada produk yang ditemukan</p>
            <article v-else v-for="p in products" :key="p.id" class="product-card">
              <div class="product-thumb">
                <img :src="imgSrc(p.image)" :alt="p.productName" />
                <span v-if="p.label" class="label-chip" :class="{ 'alt-chip': ['Diskon','Promo'].includes(p.label) }">{{ p.label }}</span>
              </div>
              <div class="product-body">
                <span class="category">{{ p.category }}</span>
                <h3>{{ p.productName }}</h3>
                <p class="meta">⭐ {{ p.rating }} · {{ p.stock > 0 ? 'Stok tersedia' : 'Stok habis' }}</p>
                <div class="price-row">
                  <h4>{{ formatPrice(p.price) }}</h4>
                  <span>{{ p.location }}</span>
                </div>
                <div class="product-buttons">
                  <RouterLink :to="`/products/${p.id}`" class="btn btn-outline">Lihat Detail</RouterLink>
                  <button 
                    class="btn" 
                    :class="p.stock > 0 ? 'btn-primary' : 'btn-disabled'"
                    :disabled="p.stock <= 0"
                    @click="addToCart(p.id)"
                  >
                    {{ p.stock > 0 ? '+ Keranjang' : 'Stok Habis' }}
                  </button>
                </div>
              </div>
            </article>
          </div>        </div>

        <div v-if="pagination.lastPage > 1" class="pagination">
          <button
            v-for="page in pagination.lastPage" :key="page"
            class="page" :class="{ active: page === pagination.currentPage }"
            @click="loadProducts(page)"
          >{{ page }}</button>
        </div>
      </div>
    </section>
  </main>

  <AppFooter />
  <ToastNotif :message="toast.message" :type="toast.type" :visible="toast.visible" />
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { api } from '../api'
import { useAuthStore } from '../stores/auth'
import AppNavbar from '../components/AppNavbar.vue'
import AppFooter from '../components/AppFooter.vue'
import ToastNotif from '../components/ToastNotif.vue'

const router   = useRouter()
const auth     = useAuthStore()
const products = ref([])
const loading  = ref(false)
const pagination = reactive({ currentPage: 1, lastPage: 1 })
const filters  = reactive({ search: '', category: '', sort: '' })
const categories = ['Elektronik', 'Fashion', 'Rumah Tangga', 'Kecantikan', 'Makanan', 'Aksesoris']
const toast    = reactive({ visible: false, message: '', type: 'success' })

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

async function loadProducts(page = 1) {
  loading.value = true
  let query = `?page=${page}`
  if (filters.search)   query += `&search=${encodeURIComponent(filters.search)}`
  if (filters.category) query += `&category=${encodeURIComponent(filters.category)}`
  if (filters.sort)     query += `&sort=${encodeURIComponent(filters.sort)}`

  try {
    const data = await api.get('/products' + query)
    products.value = data.data
    pagination.currentPage = data.current_page
    pagination.lastPage    = data.last_page
  } catch (_) {
    products.value = []
  } finally {
    loading.value = false
  }
}

function filterByCategory(cat) {
  filters.category = cat
  loadProducts()
}

async function addToCart(productId) {
  if (!auth.isLoggedIn) {
    router.push('/login')
    return
  }
  
  // Cek stok produk sebelum menambahkan
  const product = products.value.find(p => p.id === productId)
  if (product && product.stock <= 0) {
    showToast('Produk ini sedang habis stok', 'error')
    return
  }
  
  try {
    await api.post('/cart/add', { product_id: productId, quantity: 1 })
    showToast('Produk ditambahkan ke keranjang!')
  } catch (err) {
    showToast(err.response?.data?.message || 'Gagal menambahkan ke keranjang', 'error')
  }
}

onMounted(() => loadProducts())
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
</style>

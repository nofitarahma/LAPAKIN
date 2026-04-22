<template>
  <div class="page-bg"></div>

  <header class="navbar">
    <div class="container navbar-inner">
      <div class="brand">
        <div class="brand-icon">L</div>
        <div class="brand-copy">
          <h1>LAPAKIN</h1>
          <p>Admin Panel</p>
        </div>
      </div>
      <nav class="nav-links">
        <RouterLink to="/admin/products" class="active">Kelola Produk</RouterLink>
      </nav>
      <div class="nav-actions">
        <button class="logout-btn" @click="handleLogout">Logout</button>
      </div>
    </div>
  </header>

  <main>
    <section class="catalog-section">
      <div class="container">
        <div v-if="alertMsg" class="alert" :class="`alert-${alertType}`">{{ alertMsg }}</div>

        <div class="section-top">
          <div>
            <span class="section-label">MANAJEMEN PRODUK</span>
            <h2>Kelola Produk</h2>
          </div>
          <p>Kelola katalog produk Anda dengan mudah. Tambah, edit, atau hapus produk.</p>
        </div>

        <div class="toolbar">
          <div class="search-area">
            <input v-model="search" type="text" placeholder="Cari produk..." @keyup.enter="loadProducts" />
          </div>
          <div class="toolbar-controls">
            <select v-model="categoryFilter">
              <option value="">Semua Kategori</option>
              <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
            </select>
            <button class="btn btn-primary btn-small" @click="loadProducts">Cari</button>
            <RouterLink to="/admin/products/create" class="btn btn-dark btn-small">+ Tambah Produk</RouterLink>
          </div>
        </div>

        <div class="catalog-layout">
          <aside class="sidebar">
            <div class="side-card">
              <h3>Statistik</h3>
              <p class="stat-text">
                <strong>Total Produk:</strong> {{ allProducts.length }}<br />
                <strong>Stok Tersedia:</strong> {{ allProducts.filter(p => p.stock > 0).length }}<br />
                <strong>Stok Habis:</strong> {{ allProducts.filter(p => p.stock === 0).length }}
              </p>
            </div>
          </aside>

          <div class="product-grid">
            <p v-if="loading" class="empty-products">Memuat produk...</p>
            <p v-else-if="!filtered.length" class="empty-products">Tidak ada produk ditemukan</p>
            <article v-else v-for="p in filtered" :key="p.id" class="product-card">
              <div class="product-thumb">
                <img :src="imgSrc(p.image)" :alt="p.productName" />
                <span v-if="p.stock === 0" class="label-chip">Habis</span>
                <span v-else-if="p.stock < 10" class="label-chip">Terbatas</span>
              </div>
              <div class="product-body">
                <span class="category">{{ p.category }}</span>
                <h3>{{ p.productName }}</h3>
                <p class="meta">⭐ {{ p.rating ?? 0 }} · Stok: {{ p.stock }}</p>
                <div class="price-row">
                  <h4>{{ formatPrice(p.price) }}</h4>
                  <span>{{ p.location }}</span>
                </div>
                <div class="product-buttons">
                  <RouterLink :to="`/admin/products/${p.id}/edit`" class="btn btn-outline">Edit</RouterLink>
                  <button class="btn btn-danger" @click="openModal(p.id)">Hapus</button>
                </div>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Delete Modal -->
  <div class="modal-overlay" :class="{ active: showModal }">
    <div class="modal-content">
      <h3>Konfirmasi Hapus</h3>
      <p>Apakah Anda yakin ingin menghapus produk ini?</p>
      <div class="modal-buttons">
        <button class="btn-cancel" @click="showModal = false">Batal</button>
        <button class="btn-confirm" @click="confirmDelete">Hapus</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { api } from '../../api'
import { useAuthStore } from '../../stores/auth'

const router = useRouter()
const auth   = useAuthStore()

const allProducts    = ref([])
const loading        = ref(false)
const search         = ref('')
const categoryFilter = ref('')
const showModal      = ref(false)
const deleteId       = ref(null)
const alertMsg       = ref('')
const alertType      = ref('success')
const categories     = ['Elektronik', 'Fashion', 'Rumah Tangga', 'Kecantikan', 'Makanan', 'Aksesoris']

const BASE_IMG = 'http://localhost:8000/storage/'
function imgSrc(image) {
  if (!image) return 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=80'
  return image.startsWith('http') ? image : BASE_IMG + image
}
function formatPrice(price) {
  return 'Rp' + Number(price).toLocaleString('id-ID')
}
function showAlert(msg, type = 'success') {
  alertMsg.value  = msg
  alertType.value = type
  setTimeout(() => alertMsg.value = '', 3000)
}

const filtered = computed(() => {
  return allProducts.value.filter(p => {
    const matchSearch   = !search.value || p.productName.toLowerCase().includes(search.value.toLowerCase())
    const matchCategory = !categoryFilter.value || p.category === categoryFilter.value
    return matchSearch && matchCategory
  })
})

async function loadProducts() {
  loading.value = true
  try {
    allProducts.value = await api.get('/admin/products')
  } catch (_) {
    allProducts.value = []
  } finally {
    loading.value = false
  }
}

function openModal(id) {
  deleteId.value = id
  showModal.value = true
}

async function confirmDelete() {
  try {
    await api.delete(`/admin/products/${deleteId.value}`)
    showModal.value = false
    showAlert('Produk berhasil dihapus')
    loadProducts()
  } catch (_) {
    showAlert('Gagal menghapus produk', 'error')
  }
}

async function handleLogout() {
  await auth.logout()
  router.push('/login')
}

onMounted(() => loadProducts())
</script>

<style scoped>
.btn-danger { background: rgba(220,38,38,0.1); color: #dc2626; border: 1px solid rgba(220,38,38,0.2); }
.btn-danger:hover { background: rgba(220,38,38,0.2); }
.btn-small { height: 40px; font-size: 13px; padding: 0 16px; }
.stat-text { font-size: 14px; color: var(--c6); line-height: 1.8; }
.stat-text strong { color: var(--c1); }
.modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:200; align-items:center; justify-content:center; }
.modal-overlay.active { display:flex; }
.modal-content { background:#fff; border-radius:24px; padding:32px; max-width:400px; width:90%; }
.modal-content h3 { font-size:20px; color:var(--c1); margin-bottom:12px; }
.modal-content p { color:var(--c6); margin-bottom:24px; }
.modal-buttons { display:flex; gap:12px; }
.modal-buttons button { flex:1; height:46px; border-radius:14px; font-size:14px; font-weight:800; cursor:pointer; border:none; }
.btn-cancel { background:rgba(210,253,156,0.28); border:1px solid rgba(97,145,17,0.2) !important; color:var(--c1); }
.btn-confirm { background:#dc2626; color:#fff; }
</style>

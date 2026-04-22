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
        <RouterLink to="/admin/products">Kelola Produk</RouterLink>
      </nav>
      <div class="nav-actions">
        <button class="logout-btn" @click="handleLogout">Logout</button>
      </div>
    </div>
  </header>

  <main>
    <section class="catalog-section">
      <div class="container">
        <div class="section-top">
          <div>
            <span class="section-label">{{ isEdit ? 'EDIT PRODUK' : 'TAMBAH PRODUK' }}</span>
            <h2>{{ isEdit ? 'Edit Produk' : 'Produk Baru' }}</h2>
          </div>
          <p>Isi semua informasi produk dengan lengkap dan benar.</p>
        </div>

        <div v-if="alertMsg" class="alert" :class="`alert-${alertType}`">{{ alertMsg }}</div>

        <div class="form-card">
          <form @submit.prevent="handleSubmit">
            <div class="form-group">
              <label>Nama Produk *</label>
              <input v-model="form.productName" type="text" required />
              <span v-if="errors.productName" class="error-message">{{ errors.productName }}</span>
            </div>

            <div class="form-group">
              <label>Deskripsi *</label>
              <textarea v-model="form.description" required></textarea>
              <span v-if="errors.description" class="error-message">{{ errors.description }}</span>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Harga (Rp) *</label>
                <input v-model="form.price" type="number" step="0.01" required />
                <span v-if="errors.price" class="error-message">{{ errors.price }}</span>
              </div>
              <div class="form-group">
                <label>Stok *</label>
                <input v-model="form.stock" type="number" required />
                <span v-if="errors.stock" class="error-message">{{ errors.stock }}</span>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Kategori *</label>
                <select v-model="form.category" required>
                  <option value="">Pilih Kategori</option>
                  <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                </select>
                <span v-if="errors.category" class="error-message">{{ errors.category }}</span>
              </div>
              <div class="form-group">
                <label>Lokasi *</label>
                <input v-model="form.location" type="text" placeholder="Contoh: Jakarta" required />
                <span v-if="errors.location" class="error-message">{{ errors.location }}</span>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Rating (0-5)</label>
                <input v-model="form.rating" type="number" step="0.1" min="0" max="5" />
              </div>
              <div class="form-group">
                <label>Label</label>
                <input v-model="form.label" type="text" placeholder="Contoh: Terlaris" />
              </div>
            </div>

            <div class="form-group">
              <label>Gambar Produk</label>
              <img v-if="imgPreview" :src="imgPreview" class="img-preview" alt="Preview" />
              <input type="file" accept="image/*" @change="onFileChange" />
            </div>

            <div class="form-actions-row">
              <RouterLink to="/admin/products" class="btn btn-outline">Batal</RouterLink>
              <button type="submit" class="btn btn-primary" :disabled="loading">
                {{ loading ? 'Menyimpan...' : (isEdit ? 'Perbarui Produk' : 'Simpan Produk') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { api } from '../../api'
import { useAuthStore } from '../../stores/auth'

const route  = useRoute()
const router = useRouter()
const auth   = useAuthStore()

const isEdit     = computed(() => !!route.params.id)
const loading    = ref(false)
const imgPreview = ref(null)
const imageFile  = ref(null)
const alertMsg   = ref('')
const alertType  = ref('success')
const errors     = reactive({})
const categories = ['Elektronik', 'Fashion', 'Rumah Tangga', 'Kecantikan', 'Makanan', 'Aksesoris']

const BASE_IMG = 'http://localhost:8000/storage/'

const form = reactive({
  productName: '', description: '', price: '', stock: '',
  category: '', location: '', rating: '', label: '',
})

function onFileChange(e) {
  imageFile.value = e.target.files[0]
  if (imageFile.value) imgPreview.value = URL.createObjectURL(imageFile.value)
}

function showAlert(msg, type = 'success') {
  alertMsg.value  = msg
  alertType.value = type
}

async function handleSubmit() {
  Object.keys(errors).forEach(k => delete errors[k])
  loading.value = true

  const fd = new FormData()
  Object.entries(form).forEach(([k, v]) => { if (v !== '') fd.append(k, v) })
  if (imageFile.value) fd.append('image', imageFile.value)
  if (isEdit.value) fd.append('_method', 'PUT')

  const token = localStorage.getItem('token')
  const url   = isEdit.value
    ? `http://localhost:8000/api/admin/products/${route.params.id}`
    : 'http://localhost:8000/api/admin/products'

  try {
    const res  = await fetch(url, {
      method: 'POST',
      headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' },
      body: fd,
    })
    const data = await res.json()

    if (!res.ok) {
      if (data.errors) Object.assign(errors, Object.fromEntries(Object.entries(data.errors).map(([k, v]) => [k, v[0]])))
      else showAlert(data.message || 'Terjadi kesalahan', 'error')
      return
    }

    router.push('/admin/products')
  } catch (_) {
    showAlert('Gagal menyimpan produk', 'error')
  } finally {
    loading.value = false
  }
}

async function handleLogout() {
  await auth.logout()
  router.push('/login')
}

onMounted(async () => {
  if (isEdit.value) {
    try {
      const p = await api.get(`/admin/products/${route.params.id}`)
      Object.assign(form, {
        productName: p.productName, description: p.description,
        price: p.price, stock: p.stock, category: p.category,
        location: p.location, rating: p.rating ?? '', label: p.label ?? '',
      })
      if (p.image) imgPreview.value = p.image.startsWith('http') ? p.image : BASE_IMG + p.image
    } catch (_) {}
  }
})
</script>

<style scoped>
.form-card { background:rgba(255,255,255,0.88); border:1px solid rgba(57,69,8,0.08); border-radius:24px; padding:32px; box-shadow:var(--shadow-md); max-width:800px; margin:0 auto; }
.form-row { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.form-group textarea { width:100%; min-height:120px; border-radius:14px; background:#f7fbef; border:1px solid rgba(57,69,8,0.10); padding:12px 16px; font-size:14px; color:var(--c1); resize:vertical; font-family:"Manrope",sans-serif; }
.form-group select { width:100%; height:50px; border-radius:14px; background:#f7fbef; border:1px solid rgba(57,69,8,0.10); padding:0 16px; font-size:14px; color:var(--c1); }
.img-preview { max-width:200px; border-radius:12px; margin-bottom:12px; display:block; }
.form-actions-row { display:flex; gap:12px; margin-top:32px; }
.form-actions-row .btn { flex:1; justify-content:center; }
.logout-btn { height:46px; padding:0 22px; border-radius:14px; background:rgba(220,38,38,0.1); color:#dc2626; font-size:14px; font-weight:800; cursor:pointer; border:1px solid rgba(220,38,38,0.2); }
</style>

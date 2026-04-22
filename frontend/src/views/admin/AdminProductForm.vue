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
            <span class="section-label">{{ isEdit ? 'EDIT PRODUK' : 'TAMBAH PRODUK' }}</span>
            <h2>{{ isEdit ? 'Edit Produk' : 'Tambah Produk Baru' }}</h2>
          </div>
          <p>{{ isEdit ? 'Perbarui informasi produk Anda' : 'Tambahkan produk baru ke katalog' }}</p>
        </div>

        <div class="form-container">
          <form @submit.prevent="handleSubmit">
            <div class="form-row">
              <div class="form-group">
                <label for="productName">Nama Produk *</label>
                <input v-model="form.productName" type="text" id="productName" placeholder="Masukkan nama produk" :class="{ 'is-invalid': errors.productName }" required />
                <span v-if="errors.productName" class="error-message">{{ errors.productName }}</span>
              </div>
              <div class="form-group">
                <label for="category">Kategori *</label>
                <select v-model="form.category" id="category" :class="{ 'is-invalid': errors.category }" required>
                  <option value="">Pilih Kategori</option>
                  <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                </select>
                <span v-if="errors.category" class="error-message">{{ errors.category }}</span>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="price">Harga (Rp) *</label>
                <input v-model.number="form.price" type="number" id="price" placeholder="0" min="0" :class="{ 'is-invalid': errors.price }" required />
                <span v-if="errors.price" class="error-message">{{ errors.price }}</span>
              </div>
              <div class="form-group">
                <label for="stock">Stok *</label>
                <input v-model.number="form.stock" type="number" id="stock" placeholder="0" min="0" :class="{ 'is-invalid': errors.stock }" required />
                <span v-if="errors.stock" class="error-message">{{ errors.stock }}</span>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="location">Lokasi *</label>
                <input v-model="form.location" type="text" id="location" placeholder="Kota/Provinsi" :class="{ 'is-invalid': errors.location }" required />
                <span v-if="errors.location" class="error-message">{{ errors.location }}</span>
              </div>
              <div class="form-group">
                <label for="rating">Rating (0-5)</label>
                <input v-model.number="form.rating" type="number" id="rating" placeholder="4.5" min="0" max="5" step="0.1" />
                <span v-if="errors.rating" class="error-message">{{ errors.rating }}</span>
              </div>
            </div>

            <div class="form-group">
              <label for="description">Deskripsi *</label>
              <textarea v-model="form.description" id="description" placeholder="Masukkan deskripsi produk" rows="5" :class="{ 'is-invalid': errors.description }" required></textarea>
              <span v-if="errors.description" class="error-message">{{ errors.description }}</span>
            </div>

            <div class="form-group">
              <label for="image">Gambar Produk</label>
              <div class="image-upload">
                <input v-model="form.label" type="text" placeholder="Label (Terlaris, Diskon, Baru, dll)" />
                <input type="file" id="image" accept="image/*" @change="handleImageChange" />
              </div>
              <span v-if="errors.image" class="error-message">{{ errors.image }}</span>
              <div v-if="imagePreview" class="image-preview">
                <img :src="imagePreview" :alt="form.productName" />
              </div>
            </div>

            <div class="form-actions">
              <RouterLink to="/admin/products" class="btn btn-outline">Batal</RouterLink>
              <button type="submit" class="btn btn-primary" :disabled="loading">
                {{ loading ? 'Memproses...' : (isEdit ? 'Perbarui Produk' : 'Tambah Produk') }}
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
import { useRouter, useRoute } from 'vue-router'
import { api } from '../../api'
import { useAuthStore } from '../../stores/auth'

const router = useRouter()
const route = useRoute()
const auth = useAuthStore()

const form = reactive({
  productName: '',
  description: '',
  price: 0,
  stock: 0,
  category: '',
  location: '',
  image: null,
  rating: null,
  label: '',
})

const errors = reactive({
  productName: '',
  description: '',
  price: '',
  stock: '',
  category: '',
  location: '',
  image: '',
  rating: '',
})

const imagePreview = ref(null)
const loading = ref(false)
const alertMsg = ref('')
const alertType = ref('success')
const categories = ['Elektronik', 'Fashion', 'Rumah Tangga', 'Kecantikan', 'Makanan', 'Aksesoris']

const isEdit = computed(() => !!route.params.id)

function handleImageChange(e) {
  const file = e.target.files?.[0]
  if (file) {
    form.image = file
    const reader = new FileReader()
    reader.onload = (event) => {
      imagePreview.value = event.target?.result
    }
    reader.readAsDataURL(file)
  }
}

function showAlert(msg, type = 'success') {
  alertMsg.value = msg
  alertType.value = type
  setTimeout(() => alertMsg.value = '', 3000)
}

async function handleSubmit() {
  Object.keys(errors).forEach(key => errors[key] = '')
  loading.value = true

  try {
    const formData = new FormData()
    formData.append('productName', form.productName)
    formData.append('description', form.description)
    formData.append('price', form.price)
    formData.append('stock', form.stock)
    formData.append('category', form.category)
    formData.append('location', form.location)
    if (form.rating) formData.append('rating', form.rating)
    if (form.label) formData.append('label', form.label)
    if (form.image) formData.append('image', form.image)

    if (isEdit.value) {
      await api.postForm(`/admin/products/${route.params.id}`, formData)
      showAlert('Produk berhasil diperbarui')
    } else {
      await api.postForm('/admin/products', formData)
      showAlert('Produk berhasil ditambahkan')
    }

    setTimeout(() => router.push('/admin/products'), 1500)
  } catch (err) {
    if (err.status === 422 && err.data.errors) {
      Object.keys(err.data.errors).forEach(key => {
        errors[key] = err.data.errors[key]?.[0] || ''
      })
    } else {
      showAlert(err.data?.message || 'Gagal menyimpan produk', 'error')
    }
  } finally {
    loading.value = false
  }
}

async function loadProduct() {
  try {
    const product = await api.get(`/admin/products/${route.params.id}`)
    form.productName = product.productName
    form.description = product.description
    form.price = product.price
    form.stock = product.stock
    form.category = product.category
    form.location = product.location
    form.rating = product.rating
    form.label = product.label
    if (product.image) {
      imagePreview.value = product.image.startsWith('http') ? product.image : `http://localhost:8000/storage/${product.image}`
    }
  } catch (_) {
    showAlert('Gagal memuat produk', 'error')
  }
}

async function handleLogout() {
  await auth.logout()
  router.push('/login')
}

onMounted(() => {
  if (isEdit.value) loadProduct()
})
</script>

<style scoped>
.form-container { background: rgba(255,255,255,0.88); border: 1px solid rgba(57,69,8,0.08); border-radius: 24px; padding: 32px; box-shadow: var(--shadow-md); }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; font-size: 14px; font-weight: 700; color: var(--c1); margin-bottom: 8px; }
.form-group input, .form-group select, .form-group textarea { width: 100%; border-radius: 14px; background: #f7fbef; border: 1px solid rgba(57,69,8,0.10); padding: 12px 16px; font-size: 14px; color: var(--c1); font-family: inherit; transition: 0.25s ease; }
.form-group input:focus, .form-group select:focus, .form-group textarea:focus { background: #ffffff; border-color: var(--c4); box-shadow: 0 0 0 3px rgba(97,145,17,0.1); }
.form-group input.is-invalid, .form-group select.is-invalid, .form-group textarea.is-invalid { border-color: var(--error); background: rgba(220,38,38,0.05); }
.error-message { font-size: 13px; color: var(--error); margin-top: 6px; display: block; }
.image-upload { display: flex; gap: 12px; }
.image-upload input[type="text"] { flex: 1; }
.image-upload input[type="file"] { flex: 1; }
.image-preview { margin-top: 16px; border-radius: 14px; overflow: hidden; max-width: 200px; }
.image-preview img { width: 100%; height: auto; }
.form-actions { display: flex; gap: 12px; margin-top: 32px; }
.form-actions .btn { flex: 1; }
</style>

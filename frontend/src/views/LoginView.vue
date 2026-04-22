<template>
  <div class="page-bg"></div>
  <AppNavbar />

  <main>
    <section class="login-section">
      <div class="container login-grid">
        <div class="login-left">
          <span class="login-tag">FITUR LAPAKIN · LOGIN</span>
          <h2>Masuk ke akun Anda dan <span>mulai belanja produk lokal</span></h2>
          <p>Dengan login, Anda dapat mengakses riwayat pembelian, menyimpan produk favorit, dan menikmati pengalaman belanja yang lebih personal di LAPAKIN.</p>
          <div class="login-benefits">
            <div v-for="benefit in benefits" :key="benefit" class="benefit-item">
              <div class="benefit-icon">✓</div>
              <div class="benefit-text">{{ benefit }}</div>
            </div>
          </div>
        </div>

        <div class="login-right">
          <h3>Masuk</h3>
          <p>Gunakan email dan password Anda untuk login</p>

          <div v-if="errorMsg" class="alert alert-error">{{ errorMsg }}</div>

          <form @submit.prevent="handleLogin">
            <div class="form-group">
              <label for="email">Email</label>
              <input v-model="form.email" type="email" id="email" placeholder="Masukkan email Anda" :class="{ 'is-invalid': errors.email }" required />
              <span v-if="errors.email" class="error-message">{{ errors.email }}</span>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input v-model="form.password" type="password" id="password" placeholder="Masukkan password Anda" :class="{ 'is-invalid': errors.password }" required />
              <span v-if="errors.password" class="error-message">{{ errors.password }}</span>
            </div>
            <div class="form-actions">
              <a href="#">Lupa password?</a>
            </div>
            <button type="submit" class="btn btn-primary" :disabled="loading">
              {{ loading ? 'Memproses...' : 'Masuk' }}
            </button>
          </form>

          <div class="divider">atau</div>
          <div class="signup-link">Belum punya akun? <a href="#">Daftar di sini</a></div>
        </div>
      </div>
    </section>
  </main>

  <AppFooter />
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import AppNavbar from '../components/AppNavbar.vue'
import AppFooter from '../components/AppFooter.vue'

const router = useRouter()
const auth   = useAuthStore()

const form     = reactive({ email: '', password: '' })
const errors   = reactive({ email: '', password: '' })
const errorMsg = ref('')
const loading  = ref(false)

const benefits = [
  'Akses riwayat pembelian dan pesanan',
  'Simpan produk favorit untuk dibeli nanti',
  'Dapatkan penawaran eksklusif dan promo khusus',
  'Checkout lebih cepat dengan data tersimpan',
]

async function handleLogin() {
  errors.email = ''
  errors.password = ''
  errorMsg.value = ''
  loading.value = true

  try {
    await auth.login(form.email, form.password)
    if (auth.user?.role === 'admin') {
      router.push('/admin/products')
    } else {
      router.push('/products')
    }
  } catch (err) {
    if (err.status === 422 && err.data.errors) {
      errors.email    = err.data.errors.email?.[0] || ''
      errors.password = err.data.errors.password?.[0] || ''
    } else {
      errorMsg.value = err.data?.message || 'Login gagal'
    }
  } finally {
    loading.value = false
  }
}
</script>

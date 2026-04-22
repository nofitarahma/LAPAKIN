<template>
  <div class="page-bg"></div>
  <AppNavbar />

  <main>
    <section class="checkout-section">
      <div class="container">

        <!-- Loading -->
        <p v-if="loading" class="empty-products">Memuat ringkasan pesanan...</p>

        <!-- Keranjang kosong -->
        <div v-else-if="!summaryItems.length" class="cart-items-container">
          <div class="empty-cart">
            <div class="empty-cart-icon">🛒</div>
            <h3>Keranjang Anda Kosong</h3>
            <p>Tambahkan produk ke keranjang terlebih dahulu.</p>
            <RouterLink to="/products" class="btn btn-primary">Mulai Belanja</RouterLink>
          </div>
        </div>

        <!-- Order success -->
        <div v-else-if="orderResult" class="order-success">
          <div class="success-icon">✅</div>
          <h2>Pesanan Berhasil Dibuat!</h2>
          <p>Nomor pesanan Anda:</p>
          <div class="order-number">{{ orderResult.order_number }}</div>

          <div class="order-summary-box">
            <div class="summary-row" v-for="item in orderResult.items" :key="item.product_name">
              <span>{{ item.product_name }} ({{ item.quantity }}x)</span>
              <span>{{ formatPrice(item.subtotal) }}</span>
            </div>
            <div class="summary-row total">
              <span>Total</span>
              <span>{{ formatPrice(orderResult.total_amount) }}</span>
            </div>
          </div>

          <div class="payment-instruction">
            <p>💳 {{ orderResult.payment_instruction }}</p>
          </div>

          <div class="success-actions">
            <RouterLink to="/products" class="btn btn-primary">Lanjut Belanja</RouterLink>
          </div>
        </div>

        <!-- Form checkout -->
        <div v-else class="checkout-layout">
          <div class="checkout-items">
            <h3>Ringkasan Pesanan</h3>
            <div v-for="item in summaryItems" :key="item.product_id" class="checkout-item">
              <div class="checkout-item-info">
                <span class="checkout-item-name">{{ item.product_name }}</span>
                <span class="checkout-item-qty">{{ item.quantity }}x</span>
              </div>
              <span class="checkout-item-price">{{ formatPrice(item.subtotal) }}</span>
            </div>
            <div class="summary-row total" style="margin-top: 16px;">
              <span>Total</span>
              <span>{{ formatPrice(summaryTotal) }}</span>
            </div>
          </div>

          <div class="checkout-form-card">
            <h3>Data Pengiriman</h3>

            <div v-if="alertMsg" class="alert" :class="`alert-${alertType}`">{{ alertMsg }}</div>

            <form @submit.prevent="handleCheckout">
              <div class="form-group">
                <label>Nama Penerima *</label>
                <input v-model="form.name" type="text" placeholder="Nama lengkap penerima" required />
                <span v-if="errors.name" class="error-message">{{ errors.name }}</span>
              </div>

              <div class="form-group">
                <label>Alamat Pengiriman *</label>
                <textarea v-model="form.address" placeholder="Alamat lengkap pengiriman" required></textarea>
                <span v-if="errors.address" class="error-message">{{ errors.address }}</span>
              </div>

              <div class="form-group">
                <label>Nomor Telepon *</label>
                <input v-model="form.phone" type="tel" placeholder="Contoh: 08123456789" required />
                <span v-if="errors.phone" class="error-message">{{ errors.phone }}</span>
              </div>

              <div class="checkout-form-actions">
                <RouterLink to="/cart" class="btn btn-outline">← Kembali</RouterLink>
                <button type="submit" class="btn btn-primary" :disabled="submitting">
                  {{ submitting ? 'Memproses...' : 'Buat Pesanan' }}
                </button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </section>
  </main>

  <AppFooter />
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { api } from '../api'
import AppNavbar from '../components/AppNavbar.vue'
import AppFooter from '../components/AppFooter.vue'

const loading      = ref(true)
const submitting   = ref(false)
const summaryItems = ref([])
const summaryTotal = ref(0)
const orderResult  = ref(null)
const alertMsg     = ref('')
const alertType    = ref('error')
const errors       = reactive({})
const form         = reactive({ name: '', address: '', phone: '' })

function formatPrice(price) {
  return 'Rp' + Number(price).toLocaleString('id-ID')
}

function showAlert(msg, type = 'error') {
  alertMsg.value  = msg
  alertType.value = type
  setTimeout(() => alertMsg.value = '', 4000)
}

// Ambil ringkasan pesanan dari GET /api/checkout
async function loadSummary() {
  loading.value = true
  try {
    const data     = await api.get('/checkout')
    summaryItems.value = data.items
    summaryTotal.value = data.total_price
  } catch (err) {
    summaryItems.value = []
  } finally {
    loading.value = false
  }
}

// Kirim POST /api/checkout untuk buat pesanan
async function handleCheckout() {
  Object.keys(errors).forEach(k => delete errors[k])
  submitting.value = true

  try {
    const data   = await api.post('/checkout', { ...form })
    orderResult.value = data
  } catch (err) {
    if (err.status === 422 && err.data.errors) {
      Object.assign(errors, Object.fromEntries(
        Object.entries(err.data.errors).map(([k, v]) => [k, v[0]])
      ))
    } else {
      showAlert(err.data?.message || 'Gagal membuat pesanan')
    }
  } finally {
    submitting.value = false
  }
}

onMounted(() => loadSummary())
</script>

<style scoped>
.checkout-section { padding: 40px 0 64px; }
.checkout-layout {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 32px;
  align-items: start;
}
.checkout-items {
  background: rgba(255,255,255,0.88);
  border: 1px solid rgba(57,69,8,0.08);
  border-radius: 24px;
  padding: 28px;
  box-shadow: var(--shadow-md);
}
.checkout-items h3 {
  font-size: 20px;
  font-weight: 800;
  color: var(--c1);
  margin-bottom: 20px;
}
.checkout-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 0;
  border-bottom: 1px solid rgba(57,69,8,0.06);
  font-size: 14px;
}
.checkout-item-info { display: flex; gap: 12px; align-items: center; }
.checkout-item-name { font-weight: 700; color: var(--c1); }
.checkout-item-qty { color: var(--c6); }
.checkout-item-price { font-weight: 800; color: var(--c1); }
.checkout-form-card {
  background: rgba(255,255,255,0.88);
  border: 1px solid rgba(57,69,8,0.08);
  border-radius: 24px;
  padding: 28px;
  box-shadow: var(--shadow-md);
}
.checkout-form-card h3 {
  font-size: 20px;
  font-weight: 800;
  color: var(--c1);
  margin-bottom: 24px;
}
.form-group textarea {
  width: 100%;
  min-height: 100px;
  border-radius: 14px;
  background: #f7fbef;
  border: 1px solid rgba(57,69,8,0.10);
  padding: 12px 16px;
  font-size: 14px;
  color: var(--c1);
  font-family: "Poppins", sans-serif;
  resize: vertical;
}
.checkout-form-actions {
  display: flex;
  gap: 12px;
  margin-top: 24px;
}
.checkout-form-actions .btn { flex: 1; justify-content: center; }

/* Order success */
.order-success {
  max-width: 600px;
  margin: 0 auto;
  text-align: center;
  background: rgba(255,255,255,0.88);
  border: 1px solid rgba(57,69,8,0.08);
  border-radius: 24px;
  padding: 48px 40px;
  box-shadow: var(--shadow-md);
}
.success-icon { font-size: 64px; margin-bottom: 16px; }
.order-success h2 { font-size: 28px; font-weight: 800; color: var(--c1); margin-bottom: 8px; }
.order-success > p { font-size: 14px; color: var(--c6); margin-bottom: 8px; }
.order-number {
  font-size: 22px;
  font-weight: 800;
  color: var(--c4);
  background: rgba(210,253,156,0.3);
  border-radius: 12px;
  padding: 12px 24px;
  display: inline-block;
  margin-bottom: 24px;
}
.order-summary-box {
  text-align: left;
  background: #f7fbef;
  border-radius: 16px;
  padding: 20px;
  margin-bottom: 20px;
}
.payment-instruction {
  background: rgba(210,253,156,0.2);
  border: 1px solid rgba(97,145,17,0.2);
  border-radius: 14px;
  padding: 16px;
  font-size: 14px;
  color: var(--c1);
  margin-bottom: 24px;
  text-align: left;
}
.success-actions { display: flex; justify-content: center; }
</style>

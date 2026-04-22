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
        <RouterLink to="/admin/payments" class="active">Konfirmasi Pembayaran</RouterLink>
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
            <span class="section-label">KONFIRMASI PEMBAYARAN</span>
            <h2>Verifikasi Pembayaran Customer</h2>
          </div>
          <p>Periksa bukti transfer dan konfirmasi pembayaran dari customer.</p>
        </div>

        <div class="toolbar">
          <div class="search-area">
            <input v-model="search" type="text" placeholder="Cari berdasarkan nama customer atau order ID..." @keyup.enter="loadPayments" />
          </div>
          <div class="toolbar-controls">
            <select v-model="statusFilter">
              <option value="">Semua Status</option>
              <option value="pending">Pending</option>
              <option value="diterima">Diterima</option>
              <option value="ditolak">Ditolak</option>
            </select>
            <button class="btn btn-primary btn-small" @click="loadPayments">Cari</button>
          </div>
        </div>

        <div class="catalog-layout">
          <aside class="sidebar">
            <div class="side-card">
              <h3>Statistik</h3>
              <p class="stat-text">
                <strong>Total Pembayaran:</strong> {{ allPayments.length }}<br />
                <strong>Pending:</strong> {{ allPayments.filter(p => p.confirmation_status === 'pending').length }}<br />
                <strong>Diterima:</strong> {{ allPayments.filter(p => p.confirmation_status === 'diterima').length }}<br />
                <strong>Ditolak:</strong> {{ allPayments.filter(p => p.confirmation_status === 'ditolak').length }}
              </p>
            </div>
          </aside>

          <div class="payment-list">
            <p v-if="loading" class="empty-products">Memuat pembayaran...</p>
            <p v-else-if="!filtered.length" class="empty-products">Tidak ada pembayaran ditemukan</p>
            <div v-else v-for="payment in filtered" :key="payment.id" class="payment-card">
              <div class="payment-header">
                <div class="payment-info">
                  <h3>Order #{{ payment.order_id }}</h3>
                  <p class="customer-name">{{ payment.order?.user?.name }}</p>
                  <p class="customer-email">{{ payment.order?.user?.email }}</p>
                </div>
                <div class="payment-status" :class="`status-${payment.confirmation_status}`">
                  {{ formatStatus(payment.confirmation_status) }}
                </div>
              </div>

              <div class="payment-details">
                <div class="detail-row">
                  <span class="label">Nama Pengirim:</span>
                  <span class="value">{{ payment.sender_name }}</span>
                </div>
                <div class="detail-row">
                  <span class="label">Tanggal Transfer:</span>
                  <span class="value">{{ formatDate(payment.transfer_date) }}</span>
                </div>
                <div class="detail-row">
                  <span class="label">Total Pembayaran:</span>
                  <span class="value">{{ formatPrice(payment.order?.total_price) }}</span>
                </div>
              </div>

              <div v-if="payment.proof_of_transfer" class="proof-section">
                <p class="proof-label">Bukti Transfer:</p>
                <img :src="getImageUrl(payment.proof_of_transfer)" :alt="'Bukti transfer order ' + payment.order_id" class="proof-image" @click="openImageModal(payment.proof_of_transfer)" />
              </div>

              <div v-if="payment.confirmation_status === 'pending'" class="payment-actions">
                <button class="btn btn-danger" @click="openConfirmModal(payment.id, 'ditolak')">Tolak</button>
                <button class="btn btn-primary" @click="openConfirmModal(payment.id, 'diterima')">Terima</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Confirmation Modal -->
  <div class="modal-overlay" :class="{ active: showConfirmModal }">
    <div class="modal-content">
      <h3>{{ confirmAction === 'diterima' ? 'Terima Pembayaran?' : 'Tolak Pembayaran?' }}</h3>
      <p>{{ confirmAction === 'diterima' ? 'Pembayaran akan dikonfirmasi dan order akan diproses.' : 'Pembayaran akan ditolak dan customer akan diberitahu.' }}</p>
      <div class="modal-buttons">
        <button class="btn-cancel" @click="showConfirmModal = false">Batal</button>
        <button class="btn-confirm" :class="{ 'btn-danger': confirmAction === 'ditolak' }" @click="confirmPayment">{{ confirmAction === 'diterima' ? 'Terima' : 'Tolak' }}</button>
      </div>
    </div>
  </div>

  <!-- Image Modal -->
  <div class="modal-overlay" :class="{ active: showImageModal }">
    <div class="image-modal-content">
      <button class="close-btn" @click="showImageModal = false">✕</button>
      <img :src="selectedImage" alt="Bukti transfer" class="modal-image" />
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { api } from '../../api'
import { useAuthStore } from '../../stores/auth'

const router = useRouter()
const auth = useAuthStore()

const allPayments = ref([])
const loading = ref(false)
const search = ref('')
const statusFilter = ref('')
const showConfirmModal = ref(false)
const showImageModal = ref(false)
const selectedPaymentId = ref(null)
const confirmAction = ref('')
const selectedImage = ref('')
const alertMsg = ref('')
const alertType = ref('success')

function formatStatus(status) {
  const statusMap = {
    pending: 'Pending',
    diterima: 'Diterima',
    ditolak: 'Ditolak',
  }
  return statusMap[status] || status
}

function formatDate(date) {
  return new Date(date).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })
}

function formatPrice(price) {
  return 'Rp' + Number(price).toLocaleString('id-ID')
}

function getImageUrl(image) {
  if (!image) return ''
  return image.startsWith('http') ? image : `http://localhost:8000/storage/${image}`
}

function showAlert(msg, type = 'success') {
  alertMsg.value = msg
  alertType.value = type
  setTimeout(() => alertMsg.value = '', 3000)
}

const filtered = computed(() => {
  return allPayments.value.filter(p => {
    const matchSearch = !search.value || 
      p.order?.user?.name.toLowerCase().includes(search.value.toLowerCase()) ||
      p.order_id.toString().includes(search.value)
    const matchStatus = !statusFilter.value || p.confirmation_status === statusFilter.value
    return matchSearch && matchStatus
  })
})

async function loadPayments() {
  loading.value = true
  try {
    allPayments.value = await api.get('/admin/payments/pending')
  } catch (_) {
    allPayments.value = []
  } finally {
    loading.value = false
  }
}

function openConfirmModal(paymentId, action) {
  selectedPaymentId.value = paymentId
  confirmAction.value = action
  showConfirmModal.value = true
}

function openImageModal(image) {
  selectedImage.value = getImageUrl(image)
  showImageModal.value = true
}

async function confirmPayment() {
  try {
    await api.post(`/admin/payments/${selectedPaymentId.value}/confirm`, {
      status: confirmAction.value,
    })
    showConfirmModal.value = false
    showAlert(`Pembayaran berhasil di${confirmAction.value === 'diterima' ? 'terima' : 'tolak'}`)
    await loadPayments()
  } catch (error) {
    console.error('Error confirming payment:', error)
    showAlert('Gagal memproses pembayaran: ' + (error.message || 'Unknown error'), 'error')
  }
}

async function handleLogout() {
  await auth.logout()
  router.push('/login')
}

onMounted(() => loadPayments())
</script>

<style scoped>
.payment-list { display: flex; flex-direction: column; gap: 16px; }
.payment-card { background: rgba(255,255,255,0.88); border: 1px solid rgba(57,69,8,0.08); border-radius: 24px; padding: 24px; box-shadow: var(--shadow-md); }
.payment-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid rgba(57,69,8,0.08); }
.payment-info h3 { font-size: 18px; font-weight: 800; color: var(--c1); margin-bottom: 8px; }
.customer-name { font-size: 14px; font-weight: 700; color: var(--c1); }
.customer-email { font-size: 13px; color: var(--c6); margin-top: 4px; }
.payment-status { display: inline-block; padding: 8px 14px; border-radius: 999px; font-size: 12px; font-weight: 800; }
.status-pending { background: rgba(251,146,60,0.1); color: #fb923c; }
.status-diterima { background: rgba(34,197,94,0.1); color: #22c55e; }
.status-ditolak { background: rgba(220,38,38,0.1); color: #dc2626; }
.payment-details { margin-bottom: 20px; }
.detail-row { display: flex; justify-content: space-between; padding: 10px 0; font-size: 14px; border-bottom: 1px solid rgba(57,69,8,0.05); }
.detail-row .label { color: var(--c6); font-weight: 700; }
.detail-row .value { color: var(--c1); font-weight: 700; }
.proof-section { margin-bottom: 20px; }
.proof-label { font-size: 13px; font-weight: 800; color: var(--c1); margin-bottom: 12px; }
.proof-image { max-width: 300px; max-height: 300px; border-radius: 14px; cursor: pointer; border: 2px solid rgba(57,69,8,0.1); transition: 0.25s ease; }
.proof-image:hover { border-color: var(--c4); }
.payment-actions { display: flex; gap: 12px; }
.payment-actions .btn { flex: 1; height: 46px; font-size: 13px; }
.btn-danger { background: rgba(220,38,38,0.1); color: #dc2626; border: 1px solid rgba(220,38,38,0.2); }
.btn-danger:hover { background: rgba(220,38,38,0.2); }
.image-modal-content { position: relative; background: rgba(0,0,0,0.9); border-radius: 24px; padding: 20px; max-width: 90vw; max-height: 90vh; display: flex; align-items: center; justify-content: center; }
.close-btn { position: absolute; top: 16px; right: 16px; width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.2); color: #fff; font-size: 24px; cursor: pointer; border: none; display: flex; align-items: center; justify-content: center; }
.close-btn:hover { background: rgba(255,255,255,0.3); }
.modal-image { max-width: 100%; max-height: 100%; }
.btn-confirm { background: var(--c1); color: #fff; }
.btn-confirm:hover { background: #2d3607; }
</style>

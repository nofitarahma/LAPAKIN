<template>
  <div class="page-bg"></div>
  <AppNavbar />

  <main>
    <section class="cart-section">
      <div class="container">
        <div class="section-top">
          <div>
            <span class="section-label">KERANJANG BELANJA</span>
            <h2>Keranjang Anda</h2>
          </div>
          <p>Lihat semua produk yang telah Anda tambahkan, hapus item yang tidak diinginkan, atau lanjutkan berbelanja.</p>
        </div>

        <div v-if="alertMsg" class="alert" :class="`alert-${alertType}`">{{ alertMsg }}</div>

        <p v-if="loading" class="empty-products">Memuat keranjang...</p>

        <template v-else>
          <div v-if="items.length" class="cart-layout">
            <div class="cart-items-container">
              <h3>Item Keranjang ({{ items.length }})</h3>
              <div v-for="item in items" :key="item.id" class="cart-item">
                <div class="cart-item-image">
                  <img :src="imgSrc(item.product.image)" :alt="item.product.productName" />
                </div>
                <div class="cart-item-details">
                  <h4>{{ item.product.productName }}</h4>
                  <p>{{ item.product.category }}</p>
                  <p class="cart-item-price">{{ formatPrice(item.product.price) }}</p>
                  <p class="cart-item-location">{{ item.product.location }}</p>
                  <p class="cart-item-stock" :class="{ 'stock-empty': item.product.stock <= 0, 'stock-low': item.product.stock > 0 && item.product.stock < 10 }">
                    Stok: {{ item.product.stock <= 0 ? 'Habis' : item.product.stock }}
                  </p>
                </div>
                <div class="cart-item-quantity">
                  <div class="quantity-controls">
                    <button class="qty-btn" @click="updateQuantity(item.id, item.quantity - 1)" :disabled="item.quantity <= 1 || item.product.stock <= 0">-</button>
                    <input 
                      type="number" 
                      v-model.number="item.quantity" 
                      @change="updateQuantity(item.id, item.quantity)"
                      min="1" 
                      :max="item.product.stock"
                      :disabled="item.product.stock <= 0"
                      class="qty-input"
                    />
                    <button class="qty-btn" @click="updateQuantity(item.id, item.quantity + 1)" :disabled="item.quantity >= item.product.stock || item.product.stock <= 0">+</button>
                  </div>
                  <p class="item-subtotal">{{ formatPrice(item.subtotal) }}</p>
                  <p v-if="item.product.stock <= 0" class="stock-warning">⚠️ Produk habis stok</p>
                </div>
                <div class="cart-item-actions">
                  <button class="btn-delete" @click="removeItem(item.id)" title="Hapus item">✕</button>
                </div>
              </div>
            </div>

            <div class="cart-summary">
              <h3>Ringkasan Pesanan</h3>
              <div class="summary-row"><span>Subtotal</span><span>{{ formatPrice(totalPrice) }}</span></div>
              <div class="summary-row"><span>Ongkos Kirim</span><span>Rp0</span></div>
              <div class="summary-row"><span>Diskon</span><span>Rp0</span></div>
              <div class="summary-row total"><span>Total</span><span>{{ formatPrice(totalPrice) }}</span></div>
              <button class="checkout-btn" @click="$router.push('/checkout')">Lanjut ke Pembayaran</button>
              <RouterLink to="/products">
                <button class="continue-shopping">Lanjut Belanja</button>
              </RouterLink>
            </div>
          </div>

          <div v-else class="cart-items-container">
            <div class="empty-cart">
              <div class="empty-cart-icon">🛒</div>
              <h3>Keranjang Anda Kosong</h3>
              <p>Belum ada produk yang ditambahkan ke keranjang. Mulai belanja sekarang!</p>
              <RouterLink to="/products" class="btn btn-primary">Mulai Belanja</RouterLink>
            </div>
          </div>
        </template>
      </div>
    </section>
  </main>

  <AppFooter />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { api } from '../api'
import AppNavbar from '../components/AppNavbar.vue'
import AppFooter from '../components/AppFooter.vue'

const items      = ref([])
const totalPrice = ref(0)
const loading    = ref(true)
const alertMsg   = ref('')
const alertType  = ref('success')

const BASE_IMG = 'http://127.0.0.1:8000/storage/'
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

async function loadCart() {
  loading.value = true
  try {
    const data   = await api.get('/cart')
    items.value  = data.items
    totalPrice.value = data.totalPrice
  } catch (_) {
    items.value = []
  } finally {
    loading.value = false
  }
}

async function removeItem(itemId) {
  try {
    await api.delete(`/cart/${itemId}`)
    showAlert('Item berhasil dihapus dari keranjang')
    loadCart()
  } catch (_) {
    showAlert('Gagal menghapus item', 'error')
  }
}

async function updateQuantity(itemId, newQuantity) {
  if (newQuantity < 1) return
  
  try {
    await api.put(`/cart/${itemId}`, { quantity: newQuantity })
    showAlert('Jumlah item berhasil diperbarui')
    loadCart()
  } catch (error) {
    if (error.response?.status === 422) {
      showAlert(error.response.data.message || 'Stok tidak cukup', 'error')
    } else {
      showAlert('Gagal memperbarui jumlah item', 'error')
    }
    loadCart() // Reload untuk reset quantity jika gagal
  }
}

onMounted(() => loadCart())
</script>

<style scoped>
.stock-empty {
  color: #dc2626 !important;
  font-weight: 600;
}

.stock-low {
  color: #f59e0b !important;
  font-weight: 600;
}

.stock-warning {
  color: #dc2626;
  font-size: 12px;
  font-weight: 600;
  margin-top: 4px;
}

.qty-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.qty-input:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  background-color: #f3f4f6;
}
</style>

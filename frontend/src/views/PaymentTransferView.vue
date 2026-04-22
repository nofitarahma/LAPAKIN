<template>
  <div class="page-bg"></div>
  <div class="payment-container">
    <div class="payment-header">
      <h1>Pembayaran Transfer Bank</h1>
      <p>Selesaikan pembayaran Anda melalui transfer bank</p>
    </div>

    <div class="payment-content">
      <!-- Order Details (Left) -->
      <div class="payment-left">
        <div class="order-card">
          <h2>Detail Pesanan</h2>
          
          <div class="order-info">
            <div class="info-row">
              <span class="label">Nomor Pesanan:</span>
              <span class="value">{{ order.order_number }}</span>
            </div>
            <div class="info-row">
              <span class="label">Nama Penerima:</span>
              <span class="value">{{ order.name }}</span>
            </div>
            <div class="info-row">
              <span class="label">Alamat:</span>
              <span class="value">{{ order.address }}</span>
            </div>
            <div class="info-row">
              <span class="label">Telepon:</span>
              <span class="value">{{ order.phone }}</span>
            </div>
          </div>

          <div class="divider"></div>

          <div class="items-section">
            <h3>Barang yang Dipesan</h3>
            <div class="items-list">
              <div v-for="item in order.items" :key="item.product_name" class="item-row">
                <div class="item-info">
                  <span class="item-name">{{ item.product_name }}</span>
                  <span class="item-qty">{{ item.quantity }}x @ Rp{{ formatPrice(item.price) }}</span>
                </div>
                <span class="item-subtotal">Rp{{ formatPrice(item.subtotal) }}</span>
              </div>
            </div>
          </div>

          <div class="divider"></div>

          <div class="total-section">
            <span class="total-label">Total Pembayaran:</span>
            <span class="total-amount">Rp{{ formatPrice(order.total_price) }}</span>
          </div>
        </div>
      </div>

      <!-- Transfer Account Info (Right) -->
      <div class="payment-right">
        <div class="transfer-card">
          <h2>Informasi Transfer</h2>
          
          <div class="bank-info">
            <div class="bank-header">
              <span class="bank-label">Bank Tujuan</span>
              <span class="bank-name">{{ transferAccount.bank_name }}</span>
            </div>

            <div class="account-details">
              <div class="detail-item">
                <span class="detail-label">Nomor Rekening</span>
                <div class="detail-value-box">
                  <span class="detail-value">{{ transferAccount.account_number }}</span>
                  <button @click="copyToClipboard(transferAccount.account_number)" class="copy-btn">
                    📋 Salin
                  </button>
                </div>
              </div>

              <div class="detail-item">
                <span class="detail-label">Atas Nama</span>
                <div class="detail-value-box">
                  <span class="detail-value">{{ transferAccount.account_holder_name }}</span>
                  <button @click="copyToClipboard(transferAccount.account_holder_name)" class="copy-btn">
                    📋 Salin
                  </button>
                </div>
              </div>

              <div class="detail-item">
                <span class="detail-label">Jumlah Transfer</span>
                <div class="detail-value-box highlight">
                  <span class="detail-value">Rp{{ formatPrice(order.total_price) }}</span>
                </div>
              </div>
            </div>
          </div>

          <div class="divider"></div>

          <div class="instruction-section">
            <h3>Langkah-Langkah Transfer</h3>
            <ol class="instruction-list">
              <li>Buka aplikasi atau website bank Anda</li>
              <li>Pilih menu Transfer atau Kirim Uang</li>
              <li>Masukkan nomor rekening tujuan di atas</li>
              <li>Masukkan jumlah transfer sesuai total pembayaran</li>
              <li>Konfirmasi dan selesaikan transaksi</li>
              <li>Simpan bukti transfer (screenshot atau struk)</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Confirmation Form -->
    <div v-if="!confirmationSuccess" class="confirmation-section">
      <div class="confirmation-card">
        <h2>Konfirmasi Pembayaran</h2>
        <p class="confirmation-desc">Setelah melakukan transfer, silakan upload bukti transfer Anda di bawah ini</p>

        <form @submit.prevent="submitPaymentConfirmation" class="confirmation-form">
          <div class="form-group">
            <label for="transfer_date">Tanggal Transfer</label>
            <input 
              v-model="formData.transfer_date" 
              type="date" 
              id="transfer_date" 
              required
              class="form-input"
            />
          </div>

          <div class="form-group">
            <label for="sender_name">Nama Pengirim</label>
            <input 
              v-model="formData.sender_name" 
              type="text" 
              id="sender_name" 
              placeholder="Masukkan nama Anda"
              required
              class="form-input"
            />
          </div>

          <div class="form-group">
            <label for="proof_of_transfer">Bukti Transfer (JPG, PNG, PDF - Max 5MB)</label>
            <div class="file-input-wrapper">
              <input 
                @change="handleFileUpload" 
                type="file" 
                id="proof_of_transfer" 
                accept=".jpg,.jpeg,.png,.pdf"
                required
                class="file-input"
              />
              <span class="file-name">{{ fileName || 'Pilih file...' }}</span>
            </div>
          </div>

          <button type="submit" class="btn-submit" :disabled="isSubmitting">
            {{ isSubmitting ? 'Mengirim...' : 'Kirim Bukti Transfer' }}
          </button>
        </form>
      </div>
    </div>

    <!-- Success Message -->
    <div v-else class="confirmation-section">
      <div class="confirmation-card success-message">
        <div class="success-icon">✅</div>
        <h2>Bukti Transfer Berhasil Dikirim!</h2>
        <p>Pesanan Anda sedang diproses. Tim kami akan memverifikasi bukti transfer Anda dalam waktu 1-2 jam kerja.</p>
        <div class="success-details">
          <div class="detail-row">
            <span>Nomor Pesanan:</span>
            <strong>{{ order.order_number }}</strong>
          </div>
          <div class="detail-row">
            <span>Status:</span>
            <strong style="color: #22c55e;">Menunggu Verifikasi</strong>
          </div>
        </div>
        <div class="success-actions">
          <button @click="goToProducts" class="btn btn-primary">Lanjut Belanja</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { api } from '@/api'

export default {
  name: 'PaymentTransferView',
  data() {
    return {
      order: {
        order_number: '',
        name: '',
        address: '',
        phone: '',
        total_price: 0,
        items: [],
      },
      transferAccount: {
        bank_name: '',
        account_number: '',
        account_holder_name: '',
      },
      formData: {
        transfer_date: '',
        sender_name: '',
        proof_of_transfer: null,
      },
      fileName: '',
      isSubmitting: false,
      confirmationSuccess: false,
    }
  },
  computed: {
    orderId() {
      return this.$route.params.orderId
    },
  },
  methods: {
    async fetchPaymentData() {
      try {
        const response = await api.get(`/payment/transfer/${this.orderId}`)
        console.log('Payment data response:', response)
        
        // Ambil data checkout dari localStorage
        const checkoutData = JSON.parse(localStorage.getItem('checkoutData') || '{}')
        
        this.order = {
          ...response.order,
          name: checkoutData.name || response.order.name,
          address: checkoutData.address || response.order.address,
          phone: checkoutData.phone || response.order.phone,
        }
        this.transferAccount = response.transfer_account
      } catch (error) {
        console.error('Error fetching payment data:', error)
        console.error('Error status:', error.status)
        console.error('Error data:', error.data)
        alert('Gagal memuat data pembayaran. Silakan refresh halaman.')
      }
    },
    handleFileUpload(event) {
      const file = event.target.files[0]
      if (file) {
        this.formData.proof_of_transfer = file
        this.fileName = file.name
      }
    },
    async submitPaymentConfirmation() {
      if (!this.formData.proof_of_transfer) {
        alert('Silakan pilih file bukti transfer')
        return
      }

      this.isSubmitting = true
      try {
        const formData = new FormData()
        formData.append('transfer_date', this.formData.transfer_date)
        formData.append('sender_name', this.formData.sender_name)
        formData.append('proof_of_transfer', this.formData.proof_of_transfer)

        console.log('Submitting payment with orderId:', this.orderId)
        console.log('Form data:', {
          transfer_date: this.formData.transfer_date,
          sender_name: this.formData.sender_name,
          proof_of_transfer: this.formData.proof_of_transfer.name
        })

        const response = await api.postForm(`/payment/transfer/${this.orderId}`, formData)
        console.log('Payment submission response:', response)
        this.confirmationSuccess = true
      } catch (error) {
        console.error('Error submitting payment:', error)
        console.error('Error status:', error.status)
        console.error('Error data:', error.data)
        alert('Gagal mengirim bukti transfer. Silakan coba lagi.')
      } finally {
        this.isSubmitting = false
      }
    },
    copyToClipboard(text) {
      navigator.clipboard.writeText(text)
      alert('Berhasil disalin ke clipboard!')
    },
    formatPrice(price) {
      return new Intl.NumberFormat('id-ID').format(price)
    },
    goToProducts() {
      this.$router.push('/products')
    },
  },
  mounted() {
    this.fetchPaymentData()
  },
}
</script>

<style scoped src="@/assets/transfer.css"></style>

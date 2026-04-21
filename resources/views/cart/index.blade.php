<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LAPAKIN - Keranjang Belanja</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    :root {
      --c1: #394508;
      --c2: #ffffff;
      --c3: #d2fd9c;
      --c4: #619111;
      --c5: #77912a;
      --c6: #5d5d5d;
      --c7: #000000;

      --bg-main: linear-gradient(180deg, #f8ffef 0%, #f3f8ea 100%);
      --hero-bg: linear-gradient(135deg, #394508 0%, #619111 52%, #77912A 100%);
      --card-bg: rgba(255, 255, 255, 0.88);
      --shadow-xl: 0 24px 60px rgba(57, 69, 8, 0.16);
      --shadow-lg: 0 16px 40px rgba(57, 69, 8, 0.12);
      --shadow-md: 0 10px 24px rgba(57, 69, 8, 0.10);
      --radius-xl: 32px;
      --radius-lg: 24px;
      --radius-md: 18px;
      --radius-sm: 14px;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
      min-width: 1440px;
      font-family: "Manrope", sans-serif;
      color: var(--c7);
      background: var(--bg-main);
      position: relative;
    }

    .page-bg {
      position: fixed;
      inset: 0;
      background:
        radial-gradient(circle at 10% 10%, rgba(210, 253, 156, 0.26), transparent 24%),
        radial-gradient(circle at 90% 0%, rgba(119, 145, 42, 0.18), transparent 24%),
        radial-gradient(circle at 90% 80%, rgba(97, 145, 17, 0.12), transparent 24%);
      pointer-events: none;
      z-index: -1;
    }

    img { width: 100%; display: block; }
    a { text-decoration: none; color: inherit; }
    button, input, select {
      font-family: "Manrope", sans-serif;
      border: none;
      outline: none;
    }

    .container { width: 1320px; margin: 0 auto; }

    .navbar {
      position: sticky;
      top: 0;
      z-index: 100;
      background: rgba(255, 255, 255, 0.78);
      backdrop-filter: blur(14px);
      border-bottom: 1px solid rgba(57, 69, 8, 0.08);
    }

    .navbar-inner {
      height: 94px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .brand { display: flex; align-items: center; gap: 14px; }

    .brand-icon {
      width: 54px;
      height: 54px;
      border-radius: 18px;
      background: linear-gradient(145deg, var(--c3), var(--c4));
      color: var(--c1);
      font-size: 24px;
      font-weight: 800;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: var(--shadow-md);
    }

    .brand-copy h1 {
      font-size: 24px;
      font-weight: 800;
      color: var(--c1);
      letter-spacing: -0.03em;
    }

    .brand-copy p {
      font-size: 12px;
      color: var(--c6);
      margin-top: 4px;
    }

    .nav-links { display: flex; gap: 28px; }

    .nav-links a {
      font-size: 15px;
      font-weight: 700;
      color: var(--c6);
      position: relative;
    }

    .nav-links a.active, .nav-links a:hover { color: var(--c1); }

    .nav-links a.active::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: -8px;
      width: 100%;
      height: 3px;
      background: var(--c4);
      border-radius: 999px;
    }

    .nav-actions { display: flex; align-items: center; gap: 12px; }

    .icon-button {
      width: 44px;
      height: 44px;
      border-radius: 14px;
      background: rgba(210, 253, 156, 0.45);
      color: var(--c1);
      font-size: 18px;
      cursor: pointer;
    }

    .login-btn {
      height: 46px;
      padding: 0 22px;
      border-radius: 14px;
      background: var(--c1);
      color: var(--c2);
      font-size: 14px;
      font-weight: 800;
      cursor: pointer;
    }

    .cart-section { padding: 44px 0 64px; }

    .section-top {
      display: flex;
      justify-content: space-between;
      align-items: end;
      gap: 28px;
      margin-bottom: 26px;
    }

    .section-label {
      font-size: 13px;
      font-weight: 800;
      color: var(--c4);
      letter-spacing: 0.1em;
    }

    .section-top h2 {
      margin-top: 10px;
      font-size: 38px;
      color: var(--c1);
      letter-spacing: -0.03em;
    }

    .section-top p {
      max-width: 520px;
      font-size: 15px;
      line-height: 1.9;
      color: var(--c6);
      text-align: right;
    }

    .cart-layout {
      display: grid;
      grid-template-columns: 1fr 340px;
      gap: 24px;
    }

    .cart-items-container {
      background: rgba(255, 255, 255, 0.86);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(57, 69, 8, 0.08);
      border-radius: 24px;
      padding: 28px;
      box-shadow: var(--shadow-md);
    }

    .cart-items-container h3 {
      font-size: 20px;
      font-weight: 800;
      color: var(--c1);
      margin-bottom: 24px;
    }

    .cart-item {
      display: grid;
      grid-template-columns: 120px 1fr 120px 80px;
      gap: 20px;
      align-items: center;
      padding: 20px;
      background: rgba(255, 255, 255, 0.6);
      border: 1px solid rgba(57, 69, 8, 0.06);
      border-radius: 18px;
      margin-bottom: 16px;
    }

    .cart-item-image {
      width: 120px;
      height: 120px;
      border-radius: 14px;
      overflow: hidden;
      background: linear-gradient(180deg, rgba(210, 253, 156, 0.35), rgba(119, 145, 42, 0.14));
    }

    .cart-item-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .cart-item-details h4 {
      font-size: 16px;
      font-weight: 800;
      color: var(--c1);
      margin-bottom: 8px;
    }

    .cart-item-details p {
      font-size: 14px;
      color: var(--c6);
      margin-bottom: 8px;
    }

    .cart-item-price {
      font-size: 18px;
      font-weight: 800;
      color: var(--c1);
    }

    .cart-item-quantity {
      text-align: center;
      font-size: 16px;
      font-weight: 700;
      color: var(--c1);
    }

    .cart-item-actions {
      display: flex;
      gap: 8px;
    }

    .btn-delete {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: rgba(255, 107, 107, 0.2);
      color: #ff6b6b;
      font-size: 18px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: 0.25s ease;
    }

    .btn-delete:hover {
      background: rgba(255, 107, 107, 0.4);
    }

    .empty-cart {
      text-align: center;
      padding: 60px 40px;
    }

    .empty-cart-icon {
      font-size: 64px;
      margin-bottom: 20px;
    }

    .empty-cart h3 {
      font-size: 24px;
      font-weight: 800;
      color: var(--c1);
      margin-bottom: 12px;
    }

    .empty-cart p {
      font-size: 15px;
      color: var(--c6);
      margin-bottom: 24px;
    }

    .btn {
      height: 50px;
      padding: 0 22px;
      border-radius: 15px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      font-weight: 800;
      cursor: pointer;
      transition: 0.25s ease;
    }

    .btn-primary { background: var(--c3); color: var(--c1); }
    .btn-primary:hover { background: #c7f88a; }

    .btn-dark { background: var(--c1); color: var(--c2); }
    .btn-dark:hover { background: #2d3607; }

    .cart-summary {
      background: rgba(255, 255, 255, 0.86);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(57, 69, 8, 0.08);
      border-radius: 24px;
      padding: 28px;
      box-shadow: var(--shadow-md);
      height: fit-content;
      position: sticky;
      top: 120px;
    }

    .cart-summary h3 {
      font-size: 18px;
      font-weight: 800;
      color: var(--c1);
      margin-bottom: 20px;
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 14px;
      font-size: 14px;
      color: var(--c6);
    }

    .summary-row.total {
      border-top: 2px solid rgba(57, 69, 8, 0.1);
      padding-top: 14px;
      margin-top: 14px;
      font-size: 18px;
      font-weight: 800;
      color: var(--c1);
    }

    .summary-row.total span:last-child {
      color: var(--c4);
    }

    .checkout-btn {
      width: 100%;
      height: 50px;
      margin-top: 24px;
      border-radius: 15px;
      background: var(--c1);
      color: var(--c2);
      font-size: 14px;
      font-weight: 800;
      cursor: pointer;
      transition: 0.25s ease;
    }

    .checkout-btn:hover {
      background: #2d3607;
    }

    .continue-shopping {
      width: 100%;
      height: 50px;
      margin-top: 12px;
      border-radius: 15px;
      background: rgba(210, 253, 156, 0.28);
      border: 1px solid rgba(97, 145, 17, 0.20);
      color: var(--c1);
      font-size: 14px;
      font-weight: 800;
      cursor: pointer;
      transition: 0.25s ease;
    }

    .continue-shopping:hover {
      background: rgba(210, 253, 156, 0.48);
    }

    .alert {
      padding: 16px 20px;
      border-radius: 14px;
      margin-bottom: 20px;
      font-size: 14px;
      font-weight: 600;
    }

    .alert-success {
      background: rgba(76, 175, 80, 0.15);
      color: #2e7d32;
      border: 1px solid rgba(76, 175, 80, 0.3);
    }

    .alert-error {
      background: rgba(244, 67, 54, 0.15);
      color: #c62828;
      border: 1px solid rgba(244, 67, 54, 0.3);
    }

    .footer {
      background: linear-gradient(135deg, #2d3607 0%, #394508 50%, #4c640d 100%);
      color: var(--c2);
      padding: 56px 0;
      margin-top: 64px;
    }

    .footer-inner {
      display: flex;
      justify-content: space-between;
      gap: 50px;
    }

    .footer-left { max-width: 460px; }

    .footer-left h3 {
      font-size: 32px;
      font-weight: 800;
      color: var(--c3);
      margin-bottom: 14px;
    }

    .footer-left p {
      font-size: 15px;
      line-height: 1.9;
      color: rgba(255, 255, 255, 0.82);
    }

    .footer-right {
      display: flex;
      gap: 72px;
    }

    .footer-right h4 {
      font-size: 18px;
      font-weight: 800;
      margin-bottom: 16px;
    }

    .footer-right a {
      display: block;
      margin-bottom: 12px;
      font-size: 14px;
      color: rgba(255, 255, 255, 0.82);
    }

    .footer-right a:hover { color: var(--c3); }
  </style>
</head>
<body>
  <div class="page-bg"></div>

  <header class="navbar">
    <div class="container navbar-inner">
      <div class="brand">
        <div class="brand-icon">L</div>
        <div class="brand-copy">
          <h1>LAPAKIN</h1>
          <p>E-Commerce Lokal Indonesia</p>
        </div>
      </div>

      <nav class="nav-links">
        <a href="/">Beranda</a>
        <a href="/products" class="active">Produk</a>
        <a href="#">Kategori</a>
        <a href="#">Promo</a>
        <a href="#">Tentang</a>
      </nav>

      <div class="nav-actions">
        <button class="icon-button">♡</button>
        <button class="icon-button">🛒</button>
        <button class="login-btn">Masuk</button>
      </div>
    </div>
  </header>

  <main>
    <section class="cart-section">
      <div class="container">
        <div class="section-top">
          <div>
            <span class="section-label">KERANJANG BELANJA</span>
            <h2>Keranjang Anda</h2>
          </div>
          <p>
            Lihat semua produk yang telah Anda tambahkan ke keranjang,
            hapus item yang tidak diinginkan, atau lanjutkan berbelanja.
          </p>
        </div>

        @if ($message = Session::get('success'))
          <div class="alert alert-success">
            {{ $message }}
          </div>
        @endif

        @if ($message = Session::get('error'))
          <div class="alert alert-error">
            {{ $message }}
          </div>
        @endif

        @if ($cartItems->count() > 0)
          <div class="cart-layout">
            <div class="cart-items-container">
              <h3>Item Keranjang ({{ $cartItems->count() }})</h3>

              @foreach ($cartItems as $item)
                <div class="cart-item">
                  <div class="cart-item-image">
                    <img src="{{ $item->product->image ?? 'https://via.placeholder.com/120' }}" alt="{{ $item->product->productName }}" />
                  </div>

                  <div class="cart-item-details">
                    <h4>{{ $item->product->productName }}</h4>
                    <p>{{ $item->product->category }}</p>
                    <p class="cart-item-price">Rp{{ number_format($item->product->price, 0, ',', '.') }}</p>
                    <p style="font-size: 13px; color: var(--c6); margin-top: 4px;">{{ $item->product->location }}</p>
                  </div>

                  <div class="cart-item-quantity">
                    {{ $item->quantity }}x
                  </div>

                  <div class="cart-item-actions">
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display: inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn-delete" title="Hapus item">✕</button>
                    </form>
                  </div>
                </div>
              @endforeach
            </div>

            <div class="cart-summary">
              <h3>Ringkasan Pesanan</h3>

              <div class="summary-row">
                <span>Subtotal</span>
                <span>Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
              </div>

              <div class="summary-row">
                <span>Ongkos Kirim</span>
                <span>Rp0</span>
              </div>

              <div class="summary-row">
                <span>Diskon</span>
                <span>Rp0</span>
              </div>

              <div class="summary-row total">
                <span>Total</span>
                <span>Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
              </div>

              <button class="checkout-btn">Lanjut ke Pembayaran</button>
              <a href="/products">
                <button class="continue-shopping">Lanjut Belanja</button>
              </a>
            </div>
          </div>
        @else
          <div class="cart-items-container">
            <div class="empty-cart">
              <div class="empty-cart-icon">🛒</div>
              <h3>Keranjang Anda Kosong</h3>
              <p>Belum ada produk yang ditambahkan ke keranjang. Mulai belanja sekarang!</p>
              <a href="/products">
                <button class="btn btn-primary">Mulai Belanja</button>
              </a>
            </div>
          </div>
        @endif
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container footer-inner">
      <div class="footer-left">
        <h3>LAPAKIN</h3>
        <p>
          Platform e-commerce lokal dengan pengalaman berbelanja yang mudah,
          aman, dan menyenangkan.
        </p>
      </div>

      <div class="footer-right">
        <div>
          <h4>Navigasi</h4>
          <a href="/">Beranda</a>
          <a href="/products">Produk</a>
          <a href="#">Kategori</a>
          <a href="#">Promo</a>
        </div>
        <div>
          <h4>Bantuan</h4>
          <a href="#">Pusat Bantuan</a>
          <a href="#">Cara Belanja</a>
          <a href="#">Kontak</a>
          <a href="#">Kebijakan</a>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>

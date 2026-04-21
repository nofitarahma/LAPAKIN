<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $product->productName }} - LAPAKIN</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    :root {
      --c1: #394508;
      --c2: #ffffff;
      --c3: #d2fd9c;
      --c4: #619111;
      --c6: #5d5d5d;
      --c7: #000000;
      --bg-main: linear-gradient(180deg, #f8ffef 0%, #f3f8ea 100%);
      --shadow-md: 0 10px 24px rgba(57, 69, 8, 0.10);
      --radius-lg: 24px;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
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
    }
    .nav-links a:hover { color: var(--c1); }
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
    .detail-section { padding: 40px 0 64px; }
    .detail-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      background: rgba(255, 255, 255, 0.88);
      border: 1px solid rgba(57, 69, 8, 0.08);
      border-radius: var(--radius-lg);
      padding: 40px;
      box-shadow: var(--shadow-md);
    }
    .detail-image {
      height: 500px;
      border-radius: 20px;
      overflow: hidden;
      background: linear-gradient(180deg, rgba(210, 253, 156, 0.35), rgba(119, 145, 42, 0.14));
    }
    .detail-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .detail-info h1 {
      font-size: 36px;
      color: var(--c1);
      margin-bottom: 16px;
      line-height: 1.2;
    }
    .detail-meta {
      display: flex;
      gap: 20px;
      margin-bottom: 24px;
      font-size: 16px;
      color: var(--c6);
    }
    .detail-price {
      font-size: 32px;
      font-weight: 800;
      color: var(--c1);
      margin-bottom: 24px;
    }
    .detail-description {
      font-size: 15px;
      line-height: 1.8;
      color: var(--c6);
      margin-bottom: 32px;
    }
    .detail-actions {
      display: flex;
      gap: 12px;
      margin-bottom: 32px;
    }
    .btn {
      height: 50px;
      padding: 0 28px;
      border-radius: 15px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      font-weight: 800;
      cursor: pointer;
      transition: 0.25s ease;
      flex: 1;
    }
    .btn-primary { background: var(--c3); color: var(--c1); }
    .btn-primary:hover { background: #c7f88a; }
    .btn-outline {
      background: rgba(210, 253, 156, 0.28);
      border: 1px solid rgba(97, 145, 17, 0.20);
      color: var(--c1);
    }
    .btn-outline:hover { background: rgba(210, 253, 156, 0.48); }
    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: var(--c1);
      font-weight: 700;
      margin-bottom: 24px;
      text-decoration: none;
    }
    .back-link:hover { color: var(--c4); }
    .footer {
      background: linear-gradient(135deg, #2d3607 0%, #394508 50%, #4c640d 100%);
      color: var(--c2);
      padding: 56px 0;
      margin-top: 70px;
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
        <a href="/products">Produk</a>
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
    <section class="detail-section">
      <div class="container">
        <a href="/products" class="back-link">← Kembali ke Katalog</a>

        <div class="detail-container">
          <div class="detail-image">
            <img src="{{ $product->image }}" alt="{{ $product->productName }}" />
          </div>

          <div class="detail-info">
            <h1>{{ $product->productName }}</h1>

            <div class="detail-meta">
              <span>⭐ {{ $product->rating }}</span>
              <span>{{ $product->category }}</span>
              <span>📍 {{ $product->location }}</span>
            </div>

            <div class="detail-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>

            <p class="detail-description">{{ $product->description }}</p>

            <div style="margin-bottom: 24px; padding: 16px; background: rgba(210, 253, 156, 0.2); border-radius: 12px; border-left: 4px solid var(--c4);">
              <strong style="color: var(--c1);">Stok Tersedia:</strong>
              <span style="color: var(--c6); margin-left: 8px;">{{ $product->stock }} unit</span>
            </div>

            <div class="detail-actions">
              <button class="btn btn-outline">❤ Wishlist</button>
              <button class="btn btn-primary">🛒 Tambah ke Keranjang</button>
            </div>

            <div style="padding: 20px; background: rgba(255, 255, 255, 0.5); border-radius: 12px; border: 1px solid rgba(57, 69, 8, 0.08);">
              <p style="font-size: 14px; color: var(--c6); line-height: 1.8;">
                <strong style="color: var(--c1);">Informasi Penting:</strong><br>
                Produk ini dijamin original dan berkualitas. Kami menyediakan garansi kepuasan pelanggan 100%.
                Jika ada pertanyaan, hubungi customer service kami.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container footer-inner">
      <div class="footer-left">
        <h3>LAPAKIN</h3>
        <p>
          Platform e-commerce lokal dengan tampilan produk yang informatif,
          rapi, dan mudah dipahami oleh customer.
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

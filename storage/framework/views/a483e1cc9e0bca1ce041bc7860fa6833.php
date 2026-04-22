<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LAPAKIN - Melihat Produk</title>
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
      --hero-bg: linear-gradient(135deg, #394508 0%, #619111 52%, #77912A 100%);
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
    .catalog-section { padding: 40px 0 64px; }
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
    .toolbar {
      display: flex;
      justify-content: space-between;
      gap: 16px;
      background: rgba(255, 255, 255, 0.82);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(57, 69, 8, 0.08);
      border-radius: 24px;
      padding: 18px;
      box-shadow: var(--shadow-md);
      margin-bottom: 24px;
    }
    .search-area { flex: 1; }
    .search-area input {
      width: 100%;
      height: 56px;
      border-radius: 16px;
      background: #f7fbef;
      border: 1px solid rgba(57, 69, 8, 0.10);
      padding: 0 20px;
      font-size: 15px;
      color: var(--c1);
    }
    .toolbar-controls {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .toolbar-controls select {
      width: 190px;
      height: 56px;
      border-radius: 16px;
      background: #f7fbef;
      border: 1px solid rgba(57, 69, 8, 0.10);
      padding: 0 16px;
      font-size: 14px;
      color: var(--c1);
      cursor: pointer;
    }
    .catalog-layout {
      display: grid;
      grid-template-columns: 290px 1fr;
      gap: 24px;
    }
    .sidebar {
      display: flex;
      flex-direction: column;
      gap: 18px;
    }
    .side-card {
      background: rgba(255, 255, 255, 0.86);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(57, 69, 8, 0.08);
      border-radius: 24px;
      padding: 24px;
      box-shadow: var(--shadow-md);
    }
    .side-card h3 {
      font-size: 20px;
      font-weight: 800;
      color: var(--c1);
      margin-bottom: 18px;
    }
    .side-card ul {
      list-style: none;
      display: grid;
      gap: 14px;
    }
    .side-card ul a {
      color: var(--c6);
      font-size: 14px;
      font-weight: 700;
    }
    .side-card ul a:hover { color: var(--c1); }
    .promo-panel {
      background: linear-gradient(180deg, #d2fd9c 0%, #f1fadf 100%);
    }
    .promo-pill {
      display: inline-block;
      padding: 8px 14px;
      border-radius: 999px;
      background: rgba(57, 69, 8, 0.12);
      color: var(--c1);
      font-size: 12px;
      font-weight: 800;
    }
    .promo-panel p {
      margin: 12px 0 18px;
      font-size: 14px;
      line-height: 1.8;
      color: var(--c1);
    }
    .product-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 22px;
    }
    .product-card {
      background: rgba(255, 255, 255, 0.88);
      border: 1px solid rgba(57, 69, 8, 0.08);
      border-radius: 28px;
      overflow: hidden;
      box-shadow: var(--shadow-md);
      transition: 0.25s ease;
    }
    .product-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 26px 44px rgba(57, 69, 8, 0.16);
    }
    .product-thumb {
      position: relative;
      height: 248px;
      overflow: hidden;
      background: linear-gradient(180deg, rgba(210, 253, 156, 0.35), rgba(119, 145, 42, 0.14));
    }
    .product-thumb img {
      height: 100%;
      object-fit: cover;
    }
    .label-chip {
      position: absolute;
      top: 16px;
      left: 16px;
      padding: 8px 12px;
      border-radius: 999px;
      background: var(--c1);
      color: var(--c2);
      font-size: 12px;
      font-weight: 800;
    }
    .alt-chip {
      background: var(--c3);
      color: var(--c1);
    }
    .product-body { padding: 22px; }
    .category {
      display: inline-block;
      font-size: 12px;
      font-weight: 800;
      color: var(--c4);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin-bottom: 10px;
    }
    .product-body h3 {
      font-size: 22px;
      line-height: 1.35;
      color: var(--c1);
      min-height: 60px;
      letter-spacing: -0.02em;
    }
    .meta {
      margin-top: 10px;
      font-size: 14px;
      color: var(--c6);
    }
    .price-row {
      display: flex;
      justify-content: space-between;
      gap: 12px;
      align-items: center;
      margin-top: 18px;
      margin-bottom: 18px;
    }
    .price-row h4 {
      font-size: 24px;
      font-weight: 800;
      color: var(--c1);
    }
    .price-row span {
      font-size: 13px;
      font-weight: 700;
      color: var(--c6);
    }
    .product-buttons {
      display: flex;
      gap: 10px;
    }
    .btn {
      height: 46px;
      padding: 0 22px;
      border-radius: 15px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
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
    .btn-dark { background: var(--c1); color: var(--c2); width: 100%; }
    .pagination {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 34px;
    }
    .page {
      min-width: 48px;
      height: 48px;
      padding: 0 16px;
      border-radius: 14px;
      background: rgba(255, 255, 255, 0.88);
      color: var(--c1);
      border: 1px solid rgba(57, 69, 8, 0.08);
      font-size: 14px;
      font-weight: 800;
      cursor: pointer;
    }
    .page.active {
      background: var(--c1);
      color: var(--c2);
    }
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
    <section class="catalog-section" id="produk">
      <div class="container">
        <div class="section-top">
          <div>
            <span class="section-label">KATALOG PRODUK</span>
            <h2>Produk Pilihan untuk Customer</h2>
          </div>
          <p>
            Customer dapat melihat daftar produk, membaca informasi awal,
            lalu memilih salah satu produk untuk masuk ke halaman detail produk.
          </p>
        </div>

        <form method="GET" action="/products" class="toolbar">
          <div class="search-area">
            <input type="text" name="search" placeholder="Cari produk, kategori, atau toko..." value="<?php echo e(request('search')); ?>" />
          </div>

          <div class="toolbar-controls">
            <select name="category">
              <option value="">Semua Kategori</option>
              <option value="Elektronik" <?php echo e(request('category') == 'Elektronik' ? 'selected' : ''); ?>>Elektronik</option>
              <option value="Fashion" <?php echo e(request('category') == 'Fashion' ? 'selected' : ''); ?>>Fashion</option>
              <option value="Rumah Tangga" <?php echo e(request('category') == 'Rumah Tangga' ? 'selected' : ''); ?>>Rumah Tangga</option>
              <option value="Kecantikan" <?php echo e(request('category') == 'Kecantikan' ? 'selected' : ''); ?>>Kecantikan</option>
              <option value="Makanan" <?php echo e(request('category') == 'Makanan' ? 'selected' : ''); ?>>Makanan</option>
              <option value="Aksesoris" <?php echo e(request('category') == 'Aksesoris' ? 'selected' : ''); ?>>Aksesoris</option>
            </select>

            <select name="sort">
              <option value="">Urutkan Produk</option>
              <option value="Terbaru" <?php echo e(request('sort') == 'Terbaru' ? 'selected' : ''); ?>>Terbaru</option>
              <option value="Harga Terendah" <?php echo e(request('sort') == 'Harga Terendah' ? 'selected' : ''); ?>>Harga Terendah</option>
              <option value="Harga Tertinggi" <?php echo e(request('sort') == 'Harga Tertinggi' ? 'selected' : ''); ?>>Harga Tertinggi</option>
              <option value="Rating Tertinggi" <?php echo e(request('sort') == 'Rating Tertinggi' ? 'selected' : ''); ?>>Rating Tertinggi</option>
            </select>

            <button type="submit" class="btn btn-primary">Terapkan</button>
          </div>
        </form>

        <div class="catalog-layout">
          <aside class="sidebar">
            <div class="side-card">
              <h3>Kategori</h3>
              <ul>
                <li><a href="/products?category=Elektronik">Elektronik</a></li>
                <li><a href="/products?category=Fashion">Fashion</a></li>
                <li><a href="/products?category=Rumah Tangga">Rumah Tangga</a></li>
                <li><a href="/products?category=Kecantikan">Kecantikan</a></li>
                <li><a href="/products?category=Makanan">Makanan</a></li>
                <li><a href="/products?category=Aksesoris">Aksesoris</a></li>
              </ul>
            </div>

            <div class="side-card promo-panel">
              <span class="promo-pill">PROMO KHUSUS</span>
              <h3>Belanja lokal lebih hemat</h3>
              <p>Dapatkan penawaran spesial untuk produk pilihan minggu ini.</p>
              <a href="#" class="btn btn-dark">Lihat Promo</a>
            </div>
          </aside>

          <div class="product-grid">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <article class="product-card">
                <div class="product-thumb">
                  <?php if(str_starts_with($product->image, 'http')): ?>
                    <img src="<?php echo e($product->image); ?>" alt="<?php echo e($product->productName); ?>" />
                  <?php else: ?>
                    <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->productName); ?>" />
                  <?php endif; ?>
                  <?php if($product->label): ?>
                    <span class="label-chip <?php echo e(in_array($product->label, ['Diskon', 'Promo']) ? 'alt-chip' : ''); ?>"><?php echo e($product->label); ?></span>
                  <?php endif; ?>
                </div>
                <div class="product-body">
                  <span class="category"><?php echo e($product->category); ?></span>
                  <h3><?php echo e($product->productName); ?></h3>
                  <p class="meta">⭐ <?php echo e($product->rating); ?> · <?php echo e($product->stock > 0 ? 'Stok tersedia' : 'Stok habis'); ?></p>
                  <div class="price-row">
                    <h4>Rp<?php echo e(number_format($product->price, 0, ',', '.')); ?></h4>
                    <span><?php echo e($product->location); ?></span>
                  </div>
                  <div class="product-buttons">
                    <a href="/products/<?php echo e($product->id); ?>" class="btn btn-outline">Lihat Detail</a>
                    <button class="btn btn-primary">+ Keranjang</button>
                  </div>
                </div>
              </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <p style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--c6);">Tidak ada produk yang ditemukan</p>
            <?php endif; ?>
          </div>
        </div>

        <div class="pagination">
          <?php echo e($products->links('pagination::bootstrap-4')); ?>

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
<?php /**PATH C:\xampp\htdocs\LAPAKIN\resources\views/products/index.blade.php ENDPATH**/ ?>
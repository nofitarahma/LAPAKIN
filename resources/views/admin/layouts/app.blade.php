<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title') - LAPAKIN Admin</title>
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
    button, input, select, textarea {
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

    .logout-btn {
      height: 46px;
      padding: 0 22px;
      border-radius: 14px;
      background: var(--c1);
      color: var(--c2);
      font-size: 14px;
      font-weight: 800;
      cursor: pointer;
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

    .btn-outline {
      background: rgba(210, 253, 156, 0.28);
      border: 1px solid rgba(97, 145, 17, 0.20);
      color: var(--c1);
    }

    .btn-outline:hover { background: rgba(210, 253, 156, 0.48); }

    .btn-danger {
      background: #ff6b6b;
      color: var(--c2);
    }

    .btn-danger:hover { background: #ff5252; }

    .btn-small { height: 48px; }
    .full-width { width: 100%; }

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

    .side-card label {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 14px;
      font-size: 14px;
      color: var(--c6);
    }

    .side-card input[type="checkbox"] { accent-color: var(--c4); }

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

    .product-buttons .btn {
      flex: 1;
      height: 46px;
      font-size: 13px;
    }

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

    .alert {
      padding: 16px 20px;
      border-radius: 16px;
      margin-bottom: 20px;
      font-size: 14px;
      font-weight: 600;
    }

    .alert-success {
      background: rgba(210, 253, 156, 0.6);
      color: var(--c1);
      border: 1px solid rgba(97, 145, 17, 0.3);
    }

    .alert-error {
      background: rgba(255, 107, 107, 0.2);
      color: #c92a2a;
      border: 1px solid rgba(255, 107, 107, 0.3);
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 14px;
      font-weight: 700;
      color: var(--c1);
      margin-bottom: 8px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 12px 16px;
      border-radius: 12px;
      background: #f7fbef;
      border: 1px solid rgba(57, 69, 8, 0.10);
      font-size: 14px;
      color: var(--c1);
    }

    .form-group textarea {
      resize: vertical;
      min-height: 120px;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
      border-color: var(--c4);
      background: #ffffff;
    }

    .error-text {
      color: #c92a2a;
      font-size: 12px;
      margin-top: 4px;
    }

    .modal-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.5);
      z-index: 1000;
      align-items: center;
      justify-content: center;
    }

    .modal-overlay.active {
      display: flex;
    }

    .modal-content {
      background: white;
      border-radius: 24px;
      padding: 32px;
      max-width: 400px;
      box-shadow: var(--shadow-xl);
    }

    .modal-content h3 {
      font-size: 20px;
      font-weight: 800;
      color: var(--c1);
      margin-bottom: 12px;
    }

    .modal-content p {
      font-size: 14px;
      color: var(--c6);
      margin-bottom: 24px;
    }

    .modal-buttons {
      display: flex;
      gap: 12px;
    }

    .modal-buttons .btn {
      flex: 1;
      height: 46px;
    }

    main {
      padding: 40px 0;
    }

    .catalog-section {
      padding: 10px 0 64px;
    }
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
          <p>Admin Panel</p>
        </div>
      </div>

      <nav class="nav-links">
        <a href="{{ route('admin.products.index') }}" class="@if(Route::currentRouteName() == 'admin.products.index') active @endif">Kelola Produk</a>
      </nav>

      <div class="nav-actions">
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
          @csrf
          <button type="submit" class="logout-btn">Logout</button>
        </form>
      </div>
    </div>
  </header>

  <main>
    <div class="container">
      @if($message = Session::get('success'))
        <div class="alert alert-success">
          {{ $message }}
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-error">
          <strong>Terjadi kesalahan:</strong>
          <ul style="margin-top: 8px;">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @yield('content')
    </div>
  </main>

  <div class="modal-overlay" id="deleteModal">
    <div class="modal-content">
      <h3>Konfirmasi Hapus</h3>
      <p>Apakah Anda yakin ingin menghapus produk ini?</p>
      <div class="modal-buttons">
        <button class="btn btn-outline" onclick="closeDeleteModal()">Batal</button>
        <form id="deleteForm" method="POST" style="flex: 1;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger full-width">Hapus</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    function openDeleteModal(productId) {
      const form = document.getElementById('deleteForm');
      form.action = `/admin/products/${productId}`;
      document.getElementById('deleteModal').classList.add('active');
    }

    function closeDeleteModal() {
      document.getElementById('deleteModal').classList.remove('active');
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeDeleteModal();
      }
    });
  </script>

  @yield('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LAPAKIN - Login</title>
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
      --error: #dc2626;

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

    .login-section { padding: 60px 0; }

    .login-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      align-items: center;
    }

    .login-left {
      background: var(--hero-bg);
      color: var(--c2);
      border-radius: var(--radius-xl);
      padding: 44px;
      box-shadow: var(--shadow-xl);
      position: relative;
      overflow: hidden;
    }

    .login-left::before {
      content: "";
      position: absolute;
      width: 420px;
      height: 420px;
      border-radius: 50%;
      background: rgba(210, 253, 156, 0.16);
      top: -100px;
      right: -100px;
    }

    .login-left::after {
      content: "";
      position: absolute;
      width: 260px;
      height: 260px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.08);
      bottom: -80px;
      left: -50px;
    }

    .login-tag {
      position: relative;
      z-index: 1;
      display: inline-block;
      padding: 10px 16px;
      border-radius: 999px;
      background: rgba(210, 253, 156, 0.18);
      border: 1px solid rgba(210, 253, 156, 0.30);
      color: var(--c3);
      font-size: 13px;
      font-weight: 800;
      letter-spacing: 0.08em;
    }

    .login-left h2 {
      position: relative;
      z-index: 1;
      margin-top: 22px;
      font-size: 48px;
      line-height: 1.15;
      letter-spacing: -0.04em;
    }

    .login-left h2 span { color: var(--c3); }

    .login-left p {
      position: relative;
      z-index: 1;
      margin-top: 20px;
      font-size: 16px;
      line-height: 1.8;
      color: rgba(255, 255, 255, 0.88);
    }

    .login-benefits {
      position: relative;
      z-index: 1;
      margin-top: 32px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .benefit-item {
      display: flex;
      gap: 12px;
      align-items: flex-start;
    }

    .benefit-icon {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: rgba(210, 253, 156, 0.25);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      flex-shrink: 0;
    }

    .benefit-text {
      font-size: 14px;
      line-height: 1.6;
    }

    .login-right {
      background: rgba(255, 255, 255, 0.88);
      border: 1px solid rgba(57, 69, 8, 0.08);
      border-radius: var(--radius-lg);
      padding: 44px;
      box-shadow: var(--shadow-lg);
    }

    .login-right h3 {
      font-size: 32px;
      font-weight: 800;
      color: var(--c1);
      margin-bottom: 10px;
    }

    .login-right p {
      font-size: 14px;
      color: var(--c6);
      margin-bottom: 32px;
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

    .form-group input {
      width: 100%;
      height: 50px;
      border-radius: 14px;
      background: #f7fbef;
      border: 1px solid rgba(57, 69, 8, 0.10);
      padding: 0 16px;
      font-size: 14px;
      color: var(--c1);
      transition: 0.25s ease;
    }

    .form-group input:focus {
      background: #ffffff;
      border-color: var(--c4);
      box-shadow: 0 0 0 3px rgba(97, 145, 17, 0.1);
    }

    .form-group input::placeholder {
      color: rgba(57, 69, 8, 0.5);
    }

    .error-message {
      font-size: 13px;
      color: var(--error);
      margin-top: 6px;
      display: block;
    }

    .form-group input.is-invalid {
      border-color: var(--error);
      background: rgba(220, 38, 38, 0.05);
    }

    .form-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
      font-size: 13px;
    }

    .form-actions a {
      color: var(--c4);
      font-weight: 700;
    }

    .form-actions a:hover {
      color: var(--c1);
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
      width: 100%;
    }

    .btn-primary {
      background: var(--c1);
      color: var(--c2);
    }

    .btn-primary:hover {
      background: #2d3607;
    }

    .divider {
      display: flex;
      align-items: center;
      gap: 12px;
      margin: 24px 0;
      font-size: 13px;
      color: var(--c6);
    }

    .divider::before,
    .divider::after {
      content: "";
      flex: 1;
      height: 1px;
      background: rgba(57, 69, 8, 0.10);
    }

    .signup-link {
      text-align: center;
      font-size: 14px;
      color: var(--c6);
    }

    .signup-link a {
      color: var(--c4);
      font-weight: 800;
    }

    .signup-link a:hover {
      color: var(--c1);
    }

    .alert {
      padding: 14px 16px;
      border-radius: 12px;
      margin-bottom: 20px;
      font-size: 14px;
      display: flex;
      gap: 10px;
      align-items: flex-start;
    }

    .alert-error {
      background: rgba(220, 38, 38, 0.1);
      border: 1px solid rgba(220, 38, 38, 0.3);
      color: var(--error);
    }

    .alert-success {
      background: rgba(34, 197, 94, 0.1);
      border: 1px solid rgba(34, 197, 94, 0.3);
      color: #22c55e;
    }

    .footer {
      background: linear-gradient(135deg, #2d3607 0%, #394508 50%, #4c640d 100%);
      color: var(--c2);
      padding: 56px 0;
      margin-top: 60px;
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
        <a href="/produk">Produk</a>
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
    <section class="login-section">
      <div class="container login-grid">
        <div class="login-left">
          <span class="login-tag">FITUR LAPAKIN · LOGIN</span>
          <h2>
            Masuk ke akun Anda dan
            <span>mulai belanja produk lokal</span>
          </h2>
          <p>
            Dengan login, Anda dapat mengakses riwayat pembelian, menyimpan produk favorit,
            dan menikmati pengalaman belanja yang lebih personal di LAPAKIN.
          </p>

          <div class="login-benefits">
            <div class="benefit-item">
              <div class="benefit-icon">✓</div>
              <div class="benefit-text">Akses riwayat pembelian dan pesanan</div>
            </div>
            <div class="benefit-item">
              <div class="benefit-icon">✓</div>
              <div class="benefit-text">Simpan produk favorit untuk dibeli nanti</div>
            </div>
            <div class="benefit-item">
              <div class="benefit-icon">✓</div>
              <div class="benefit-text">Dapatkan penawaran eksklusif dan promo khusus</div>
            </div>
            <div class="benefit-item">
              <div class="benefit-icon">✓</div>
              <div class="benefit-text">Checkout lebih cepat dengan data tersimpan</div>
            </div>
          </div>
        </div>

        <div class="login-right">
          <h3>Masuk</h3>
          <p>Gunakan email dan password Anda untuk login</p>

          <?php if($errors->any()): ?>
            <div class="alert alert-error">
              <span>⚠</span>
              <div>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div><?php echo e($error); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          <?php endif; ?>

          <form method="POST" action="/login">
            <?php echo csrf_field(); ?>

            <div class="form-group">
              <label for="email">Email</label>
              <input
                type="email"
                id="email"
                name="email"
                placeholder="Masukkan email Anda"
                value="<?php echo e(old('email')); ?>"
                class="<?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                required
              />
              <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="error-message"><?php echo e($message); ?></span>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password Anda"
                class="<?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                required
              />
              <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="error-message"><?php echo e($message); ?></span>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-actions">
              <a href="#">Lupa password?</a>
            </div>

            <button type="submit" class="btn btn-primary">Masuk</button>
          </form>

          <div class="divider">atau</div>

          <div class="signup-link">
            Belum punya akun? <a href="/register">Daftar di sini</a>
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
          Platform e-commerce lokal dengan sistem login yang aman dan mudah digunakan
          untuk pengalaman belanja yang lebih baik.
        </p>
      </div>

      <div class="footer-right">
        <div>
          <h4>Navigasi</h4>
          <a href="/">Beranda</a>
          <a href="/produk">Produk</a>
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
<?php /**PATH C:\xampp\htdocs\LAPAKIN\resources\views/auth/login.blade.php ENDPATH**/ ?>
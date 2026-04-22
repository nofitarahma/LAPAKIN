# LAPAKIN — Backend (Laravel API)

## Setup

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

API berjalan di `http://localhost:8000/api`

## Endpoints

| Method | Endpoint | Auth | Keterangan |
|--------|----------|------|------------|
| POST | /api/login | - | Login, returns token |
| POST | /api/logout | ✓ | Logout |
| GET | /api/me | ✓ | Data user login |
| GET | /api/products | - | List produk |
| GET | /api/products/{id} | - | Detail produk |
| GET | /api/cart | ✓ | Isi keranjang |
| POST | /api/cart/add | ✓ | Tambah ke keranjang |
| DELETE | /api/cart/{id} | ✓ | Hapus dari keranjang |
| GET | /api/admin/products | ✓ | List produk (admin) |
| POST | /api/admin/products | ✓ | Tambah produk |
| PUT | /api/admin/products/{id} | ✓ | Update produk |
| DELETE | /api/admin/products/{id} | ✓ | Hapus produk |

Auth menggunakan Bearer Token (Laravel Sanctum).

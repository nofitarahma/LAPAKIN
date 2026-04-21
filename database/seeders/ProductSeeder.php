<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'productName' => 'Smartphone X12 Pro',
                'description' => 'Smartphone flagship dengan spesifikasi tinggi',
                'price' => 3499000,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=80',
                'category' => 'Elektronik',
                'location' => 'Jakarta',
                'rating' => 4.8,
            ],
            [
                'productName' => 'Kaos Polos Premium',
                'description' => 'Kaos polos berkualitas premium dengan bahan nyaman',
                'price' => 89000,
                'stock' => 200,
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=80',
                'category' => 'Fashion',
                'location' => 'Bandung',
                'rating' => 4.7,
            ],
            [
                'productName' => 'Headphone Wireless',
                'description' => 'Headphone wireless dengan kualitas suara jernih',
                'price' => 249000,
                'stock' => 75,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=80',
                'category' => 'Elektronik',
                'location' => 'Surabaya',
                'rating' => 4.9,
            ],
            [
                'productName' => 'Blender Dapur Mini',
                'description' => 'Blender mini untuk kebutuhan dapur rumah tangga',
                'price' => 179000,
                'stock' => 100,
                'image' => 'https://images.unsplash.com/photo-1616628182509-6f4d67dbdcce?auto=format&fit=crop&w=900&q=80',
                'category' => 'Rumah Tangga',
                'location' => 'Malang',
                'rating' => 4.6,
            ],
            [
                'productName' => 'Hoodie Casual Unisex',
                'description' => 'Hoodie casual yang nyaman untuk sehari-hari',
                'price' => 155000,
                'stock' => 150,
                'image' => 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=900&q=80',
                'category' => 'Fashion',
                'location' => 'Yogyakarta',
                'rating' => 4.8,
            ],
            [
                'productName' => 'Brightening Serum 30ml',
                'description' => 'Serum kecantikan untuk mencerahkan kulit',
                'price' => 129000,
                'stock' => 120,
                'image' => 'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?auto=format&fit=crop&w=900&q=80',
                'category' => 'Kecantikan',
                'location' => 'Bekasi',
                'rating' => 4.7,
            ],
            [
                'productName' => 'Jam Tangan Digital',
                'description' => 'Jam tangan digital dengan fitur lengkap',
                'price' => 199000,
                'stock' => 80,
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=900&q=80',
                'category' => 'Aksesoris',
                'location' => 'Depok',
                'rating' => 4.5,
            ],
            [
                'productName' => 'Sepatu Sneakers Urban',
                'description' => 'Sepatu sneakers dengan desain urban modern',
                'price' => 329000,
                'stock' => 60,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80',
                'category' => 'Fashion',
                'location' => 'Semarang',
                'rating' => 4.9,
            ],
            [
                'productName' => 'Kopi Bubuk Arabika',
                'description' => 'Kopi bubuk arabika pilihan dari Aceh',
                'price' => 65000,
                'stock' => 300,
                'image' => 'https://images.unsplash.com/photo-1515003197210-e0cd71810b5f?auto=format&fit=crop&w=900&q=80',
                'category' => 'Makanan',
                'location' => 'Aceh',
                'rating' => 4.8,
            ],
            [
                'productName' => 'Tas Selempang Casual',
                'description' => 'Tas selempang casual untuk penggunaan sehari-hari',
                'price' => 119000,
                'stock' => 90,
                'image' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?auto=format&fit=crop&w=900&q=80',
                'category' => 'Aksesoris',
                'location' => 'Bogor',
                'rating' => 4.6,
            ],
            [
                'productName' => 'Lampu Meja Minimalis',
                'description' => 'Lampu meja dengan desain minimalis modern',
                'price' => 149000,
                'stock' => 110,
                'image' => 'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?auto=format&fit=crop&w=900&q=80',
                'category' => 'Rumah Tangga',
                'location' => 'Solo',
                'rating' => 4.7,
            ],
            [
                'productName' => 'Hydrating Face Mask',
                'description' => 'Masker wajah untuk hidrasi kulit',
                'price' => 49000,
                'stock' => 200,
                'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?auto=format&fit=crop&w=900&q=80',
                'category' => 'Kecantikan',
                'location' => 'Tangerang',
                'rating' => 4.5,
            ],
            [
                'productName' => 'Speaker Bluetooth Mini',
                'description' => 'Speaker bluetooth mini dengan suara jernih',
                'price' => 219000,
                'stock' => 85,
                'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=900&q=80',
                'category' => 'Elektronik',
                'location' => 'Medan',
                'rating' => 4.8,
            ],
            [
                'productName' => 'Set Alat Masak Premium',
                'description' => 'Set lengkap alat masak berkualitas premium',
                'price' => 459000,
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=900&q=80',
                'category' => 'Rumah Tangga',
                'location' => 'Makassar',
                'rating' => 4.9,
            ],
            [
                'productName' => 'Dompet Kulit Pria',
                'description' => 'Dompet kulit asli untuk pria',
                'price' => 139000,
                'stock' => 70,
                'image' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&w=900&q=80',
                'category' => 'Aksesoris',
                'location' => 'Palembang',
                'rating' => 4.6,
            ],
            [
                'productName' => 'Keripik Pisang Coklat',
                'description' => 'Keripik pisang dengan lapisan coklat',
                'price' => 35000,
                'stock' => 250,
                'image' => 'https://images.unsplash.com/photo-1615486363973-2f15ee89f580?auto=format&fit=crop&w=900&q=80',
                'category' => 'Makanan',
                'location' => 'Lampung',
                'rating' => 4.7,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

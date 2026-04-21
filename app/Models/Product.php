<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'productName',
        'description',
        'price',
        'stock',
        'image',
        'category',
        'rating',
        'label',
        'location',
    ];

    public function getProductDetail(): array
    {
        return $this->toArray();
    }

    public function updateStock(int $quantity): void
    {
        $this->decrement('stock', $quantity);
    }
}

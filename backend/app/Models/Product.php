<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'location',
        'rating',
        'label',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'rating' => 'decimal:2',
    ];

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getProductDetail()
    {
        return [
            'id' => $this->id,
            'productName' => $this->productName,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image' => $this->image,
            'category' => $this->category,
            'location' => $this->location,
            'rating' => $this->rating,
            'isOutOfStock' => $this->stock <= 0,
            'isLowStock' => $this->stock > 0 && $this->stock < 10,
        ];
    }

    public function updateStock($quantity)
    {
        $this->stock -= $quantity;
        $this->save();
    }
}

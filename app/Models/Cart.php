<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'createdAt',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function addItem($productId, $quantity)
    {
        $existingItem = $this->cartItems()->where('product_id', $productId)->first();

        if ($existingItem) {
            $existingItem->quantity += $quantity;
            $existingItem->calculateSubtotal();
        } else {
            $product = Product::find($productId);
            CartItem::create([
                'cart_id' => $this->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'subtotal' => $product->price * $quantity,
            ]);
        }
    }

    public function removeItem($cartItemId)
    {
        CartItem::find($cartItemId)->delete();
    }

    public function getCartItems()
    {
        return $this->cartItems()->with('product')->get();
    }

    public function getTotalPrice()
    {
        return $this->cartItems()->sum('subtotal');
    }
}

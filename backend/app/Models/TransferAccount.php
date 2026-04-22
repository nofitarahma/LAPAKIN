<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransferAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'account_number',
        'account_holder_name',
    ];

    /* ── Relations ── */

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /* ── Business Logic ── */

    /**
     * Display account info untuk ditampilkan ke customer
     */
    public function displayAccountInfo(): array
    {
        return [
            'id' => $this->id,
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'account_holder_name' => $this->account_holder_name,
        ];
    }
}

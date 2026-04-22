<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentConfirmation extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'transfer_date',
        'proof_of_transfer',
        'sender_name',
        'confirmation_status',
    ];

    protected $casts = [
        'transfer_date' => 'datetime',
    ];

    /* ── Relations ── */

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /* ── Business Logic ── */

    /**
     * Submit confirmation - set status to pending
     */
    public function submitConfirmation(): bool
    {
        $this->confirmation_status = 'pending';
        return $this->save();
    }

    /**
     * Validate confirmation - set status to verified
     */
    public function validateConfirmation(): bool
    {
        $this->confirmation_status = 'verified';
        return $this->save();
    }
}

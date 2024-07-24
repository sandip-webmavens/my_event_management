<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'amount',
        'payment_method',
        'transaction_id',
        'paid_at',
    ];

    /**
     * Get the ticket that owns the payment.
     */
    public function ticket()
    {
        return $this->belongsTo(Tickets::class);
    }
}

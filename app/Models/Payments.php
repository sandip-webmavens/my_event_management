<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'transaction_id'
    ];

    public function eventorder()
    {
        return $this->belongsTo(EventOrders::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'quantity',
        'is_paid',
        'status',
        'qr_code',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function ticketPayments()
    {
        return $this->hasMany(TicketPayment::class);
    }
}

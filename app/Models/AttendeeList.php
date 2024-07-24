<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendeeList extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'event_id', 'tickets_id', 'status', 'qr_codes'];

    public function ticket()
    {
        return $this->belongsTo(Tickets::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}

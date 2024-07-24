<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'organization_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'is_public',
        'ticket_price',
        'total_ticket',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // An event belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tickets()
    {
        return $this->hasMany(Tickets::class);
    }

    public function attendees()
    {
        return $this->hasMany(AttendeeList::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmarks::class);
    }
    public function eventorder()
    {
        return $this->hasMany(EventOrders::class);
    }

    public function eventCategory()
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

}

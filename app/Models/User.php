<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use SoftDeletes, Notifiable, HasFactory, InteractsWithMedia;

    protected $table = 'users';

    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'approved',
        'remember_token',
        'consumer_key',
        'consumer_secret',
        'access_token',
        'access_token_secret',
        'bearer_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'role_id',
        'google_id',
        'twitter_id',
        'linkedin_id'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->width(50)
            ->height(50)
            ->performOnCollections('image');
    }

    public function organization()
    {
        return $this->hasMany(Organization::class);
    }

    public function event()
    {
        return $this->hasMany(Event::class);
    }

    public function attendees()
    {
        return $this->hasMany(AttendeeList::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function eventcategory()
    {
        return $this->hasMany(EventCategory::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmarks::class);
    }

    public function eventorder()
    {
        return $this->hasMany(EventOrders::class);
    }
}

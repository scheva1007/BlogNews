<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $dates = ['blocked_until'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function news ()
    {
        return $this->hasMany(News::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    public function isBlocked()
    {

        return $this->blocked_until && $this->blocked_until->isFuture();
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAuthor()
    {
        return $this->role === 'author';
    }

    public function isRegistered()
    {
        return $this->role === 'registered';
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class,'subscriber_id');
    }

    public function subscribers()
    {
        return $this->hasMany(Subscription::class, 'author_id');
    }

    public function subscriberAuthor($authorId)
    {
        return $this->subscriptions()->where('author_id', $authorId)->exists();
    }
}



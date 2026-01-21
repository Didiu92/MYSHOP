<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_WORKER = 'worker';
    public const ROLE_GUEST = 'guest';

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is a standard authenticated customer.
     */
    public function isGuest(): bool
    {
        return $this->role === self::ROLE_GUEST;
    }

    /**
     * Check if user is a worker (invited staff) without full admin powers.
     */
    public function isWorker(): bool
    {
        return $this->role === self::ROLE_WORKER || $this->isAdmin();
    }

    /**
     * True only for the limited worker profile (non-admin staff).
     */
    public function isWorkerGuest(): bool
    {
        return $this->role === self::ROLE_WORKER;
    }

    /**
     * Get the products in the user's cart (N:M relationship).
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_user')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}

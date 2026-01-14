<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'offer_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the offer that applies to this product.
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * Get the users who have this product in their cart (N:M relationship).
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'product_user')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Get the product's final price after applying discounts.
     */
    protected function finalPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->offer && $this->offer->discount_percentage > 0) {
                    $discount = $this->price * ($this->offer->discount_percentage / 100);
                    return round($this->price - $discount, 2);
                }
                return $this->price;
            },
        );
    }
}

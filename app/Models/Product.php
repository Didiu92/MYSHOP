<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Product extends Model
{
 use HasFactory;
 protected $fillable = [
 'name',
 'description',
 'image', // Añadimos el campo de imagen
 'price',
 'category_id',
 'offer_id',
 ];
 /**
 * Get the attributes that should be cast.
 */
 protected function casts(): array
 {
 return [
 'price' => 'decimal:2',
 ];
 }
 /**
 * Calculate the final price after applying offer discount.
 *
 * @return Attribute
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
 * The users that have this product in their wishlist.
 */
 public function users(): BelongsToMany
 {
 return $this->belongsToMany(User::class)
 ->withPivot('quantity')
 ->withTimestamps();
 }
}
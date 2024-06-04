<?php

namespace App\Models;

use App\Traits\Models\HasImage;
use App\Traits\Traits\Models\HiddenTimestamps;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    use HiddenTimestamps;
    use HasImage;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'regular_price',
        'sale_price',
        'brand_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'regular_price' => 'double',
        'sale_price' => 'double',
        'brand_id' => 'integer',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    protected function onSale(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->sale_price != null,
        );
    }

    protected function isFavoriteForCurrentUser(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->favorites()->where('user_id', auth()->id())->count() == 1,
        );
    }

    protected function discountPercentage(): Attribute
    {
        return Attribute::make(
            get: fn() => (($this->regular_price - $this->sale_price) / $this->regular_price) * 100,
        );
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites', 'product_id', 'user_id');
    }
}

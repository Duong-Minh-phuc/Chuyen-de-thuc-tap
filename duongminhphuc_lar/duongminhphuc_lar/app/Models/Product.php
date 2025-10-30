<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
use App\Models\Brand;
    
class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    public function category(): BelongsTo
    {
    return $this->belongsTo (Category::class, 'category_id', 'id');
    }

    public function brand(): BelongsTo
    {
    return $this->belongsTo (Brand::class, 'brand_id', 'id');
    }
    public function orderdetail(): HasMany
    {
    return $this->hasMany (OrderDetail::class, 'product_id', 'id');
    }
}
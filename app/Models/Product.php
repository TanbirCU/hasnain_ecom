<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'name',
        'small_description',
        'unit_id',
        'stock',
        'min_order_quantity',
        'purchase_price',
        'selling_price',
        'description',
        'status',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

      // Many-to-Many: Product ↔ Color
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color'); // Changed from 'product_colors'
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size'); // Changed from 'product_sizes'
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['store_id', 'category_id', 'name', 'sku', 'price', 'stock', 'is_available', 'image', 'toppings'];

    protected $casts = [
        'toppings' => 'array',
        'is_available' => 'boolean'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

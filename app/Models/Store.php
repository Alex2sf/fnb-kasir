<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['user_id', 'name', 'address', 'phone', 'logo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}

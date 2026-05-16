<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['store_id', 'name', 'phone', 'email'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}

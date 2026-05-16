<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = ['store_id', 'name', 'type', 'value', 'is_active'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}

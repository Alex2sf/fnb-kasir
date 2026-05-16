<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'store_id', 'user_id', 'customer_id', 'table_id', 'discount_id',
        'receipt_number', 'subtotal', 'discount_amount', 'tax_amount',
        'grand_total', 'payment_method', 'paid_amount', 'change_amount'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}

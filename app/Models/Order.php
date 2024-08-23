<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'seller_id',
        'checkout_id',
        'total_amount',
        'status'
    ];

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class);
    }

    public function checkout()
    {
        return $this->belongsTo(Checkout::class, 'checkout_id');
    }
}
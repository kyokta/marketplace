<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailCheckout extends Model
{
    use HasFactory;

    protected $table = 'detail_checkouts';

    protected $fillable = [
        'checkout_id',
        'product_id',
        'quantity',
        'price',
        'total_price',
    ];

    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
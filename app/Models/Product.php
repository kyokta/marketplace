<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'store',
        'category_id',
        'price',
        'stock',
        'image',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'store');
    }

    public function detailCheckouts()
    {
        return $this->hasMany(DetailCheckout::class);
    }

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class, 'product_id');
    }
}
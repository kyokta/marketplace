<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $table = 'checkouts';

    protected $fillable = [
        'user_id',
        'total_amount',
        'status'
    ];

    public function detailCheckouts()
    {
        return $this->hasMany(DetailCheckout::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

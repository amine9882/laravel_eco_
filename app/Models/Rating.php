<?php

namespace App\Models;
use App\Models\Product;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $table = 'ratings';
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    protected $with = ['product'];
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id', 'id');
    }
}

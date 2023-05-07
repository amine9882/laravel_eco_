<?php

namespace App\Models;
use App\Models\Order;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderitems extends Model
{
    use HasFactory;
    protected $table = 'orderitems';
    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'price',
        'purchased',
        'user_id',
    ];
    protected $with = ['Order'];
    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
   
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id', 'id');
    }

    public function ratings()
    {
    return $this->hasMany(Rating::class);
    }

}   


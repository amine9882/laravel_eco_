<?php

namespace App\Models;
use App\Models\Order;

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
        'price'
    ];
    protected $with = ['Order'];
    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}

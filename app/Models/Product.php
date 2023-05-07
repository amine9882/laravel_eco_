<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Rating;
use App\Models\Orderitem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'category_id',
        'slug',
        'name',
        'description',
        'brand',
        'selling_price',
        'original_price',
        'qty',
        'image',
        'featured',
        'popular',
        'status',
    ];
    
    protected $with = ['category'];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    
    // public function ratings()
    // {
    //     return $this->belongsTo(Rating::class, 'product_id', 'id');
    // }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    public function orderitem()
    {
        return $this->hasMany(Orderitem::class);
    }
    
    

    
}
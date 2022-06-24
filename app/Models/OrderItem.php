<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = FALSE;

    protected $fillable = [
        "product_id",
        "order_id",
        "qty",
        "unit_price",
        "total_price",
    ];

    /**
     * Get the order that owns the order_item.
     */
    public function order(){
        return $this->belongsTo('App\Models\Order');
    }

    /**
     * Get the product that owns the order_item.
     */
    public function product(){
        return $this->belongsTo('App\Models\ViewProduct');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewProduct extends Model
{
    public $timestamps = FALSE;

    /**
     * Get the category that owns the product.
     */
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * Get the image_items record associated with the product.
     */
    public function imageItems(){
        return $this->hasMany('App\Models\ImageItem', 'product_id');
    }

    /**
     * Get the brand that owns the product.
     */
    public function brand(){
        return $this->belongsTo('App\Models\Brand');
    }

    /**
     * Get the comments record associated with the product.
     */
    public function comments(){
        return $this->hasMany('App\Models\Comment', 'product_id');
    }

    /**
     * Get the order_item record associated with the product.
     */
    public function orderItem(){
        return $this->hasMany('App\Models\OrderItem');
    }
}

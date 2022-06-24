<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = FALSE;
    protected $fillable = [
        "barcode", "sku", "name", "price", "inventory_qty", "category_id", "brand_id", "description", "star", "featured", "created_date", "discount_percentage", "discount_from_date", "discount_to_date", "featured_image",
    ];

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
        return $this->hasMany('App\Models\ImageItem');
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
        return $this->hasMany('App\Models\Comment');
    }

    /**
     * Get the order_item record associated with the product.
     */
    public function orderItem(){
        return $this->hasMany('App\Models\OrderItem');
    }

    public function getPriceAttribute($value){
        return number_format($value);
    }

    public function getSalePriceAttribute($value){
        return number_format($value);
    }
}

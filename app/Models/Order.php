<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = FALSE;

    protected $fillable = [
        "created_date", "order_status_id", "staff_id", "customer_id", "shipping_fullname", "shipping_mobile", "payment_method", "shipping_ward_id", "shipping_housenumber_street", "shipping_fee", "delivered_date", "price_total", "discount_code", "discount_amount", "sub_total", "tax", "price_inc_tax_total", "voucher_code", "voucher_amount", "payment_total",
    ];

    /**
     * Get the customer that owns the order.
     */
    public function customer(){
        return $this->belongsTo('App\Models\Customer');
    }

    /**
     * Get the staff that owns the order.
     */
    public function staff(){
        return $this->belongsTo('App\Models\Staff');
    }

    /**
     * Get the ward that owns the order.
     */
    public function ward(){
        return $this->belongsTo('App\Models\Ward', 'shipping_ward_id');
    }

    /**
     * Get the order_items record associated with the order.
     */
    public function orderItems(){
        return $this->hasMany('App\Models\OrderItem');
    }
    
    /**
     * Get the status that owns the order.
     */
    public function status(){
        return $this->belongsTo('App\Models\Status', 'order_status_id');
    }
}

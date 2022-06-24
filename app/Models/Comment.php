<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'product_id',
        'star',
        'created_date',
        'description',
    ];

    protected $casts = [
        'created_date' => 'datetime:d-m-Y H:i:s'
    ];

    /**
     * Get the product that owns the comment.
     */
    public function product(){
        return $this->belongsTo('App\Models\ViewProduct');
    }

    /**
     * Get the customer that owns the comment.
     */
    public function customer(){
        return $this->belongsTo('App\Models\Customer');
    }
}

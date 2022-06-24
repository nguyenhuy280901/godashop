<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageItem extends Model
{
    public $timestamps = FALSE;
    
    /**
     * Get the product that owns the image item.
     */
    public function product(){
        return $this->belongsTo('App\Models\Product');
    }
}

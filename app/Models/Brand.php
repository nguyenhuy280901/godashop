<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $timestamps = FALSE;

    /**
     * Get the products record associated with the brand.
     */
    public function products(){
        return $this->hasMany('App\Models\ViewProduct', 'brand_id');
    }
}

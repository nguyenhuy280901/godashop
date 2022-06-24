<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = FALSE;

    protected $fillable = [
        "name",
    ];

    /**
     * Get the products record associated with the category.
     */
    public function products(){
        return $this->hasMany('App\Models\ViewProduct');
    }
}

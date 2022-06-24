<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ViewProduct;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $categories = Category::with('products')->get();
        return view(config('constant.site_view').'home.index', [
            "categories" => $categories,
        ]);
    }
}

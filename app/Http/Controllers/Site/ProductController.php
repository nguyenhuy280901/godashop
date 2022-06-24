<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ViewProduct;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $numOfItem = config('constant.product_per_page');
        $conditions = array();
        $columnsSort = [
            "alpha" => "name",
            "price" => "sale_price",
            "created" => "created_date"
        ];
        $sort = [
            "column" => $columnsSort["created"],
            "type" => "desc"
        ];

        // Filter by category_id
        if(isset($request->category_id)){
            array_push($conditions, ['category_id', '=', $request->category_id]);
        }

        // Filter by price_range
        if(isset($request->price_range)){
            $range = explode('-', $request->price_range);
            array_push($conditions, ['sale_price', '>=', $range[0]]);
            array_push($conditions, ['sale_price', '<=', $range[1] != "greater" ? $range[1] : PHP_INT_MAX]);
        }

        // Sort list products
        if(isset($request->sortby)){
            $sortInfo = explode('-' ,$request->sortby);
            $sort["column"] = $columnsSort[$sortInfo[0]];
            $sort["type"] = $sortInfo[1];
        }

        $categories = Category::all();
        $products = ViewProduct::where($conditions)->orderBy($sort["column"], $sort["type"])->paginate($numOfItem);

        $data = [
            'products' => $products,
            'filterCategory' => Category::find($request->category_id),
            'priceRange' => $request->price_range,
            'sortby' => $request->sortby,
            'categories' => $categories,
        ];

        return view(config('constant.site_view').'product.list', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = Category::all();
        $product = ViewProduct::with([
            'category',
            'brand',
            'comments',
            'imageItems'
        ])->find($id);
        
        $data = [
            'product' => $product,
            'categories' => $categories,
        ];
        return view(config('constant.site_view').'product.detail', $data);
    }

    /**
     * Search product for ajax request.
     *
     * @param  string $pattern
     * @return \Illuminate\Http\Response
     */
    public function ajaxSearch($pattern)
    {
        $search = "%$pattern%";
        $products = ViewProduct::where('id', 'LIKE', $search)->orWhere('name', 'LIKE', $search)->get();
        if($products->count() == 0){
            return "";
        }
        return view(config('constant.site_view').'product.ajaxSearch',[
            "products" => $products
        ]);
    }

    /**
     * Search product by form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $numOfItem = config('constant.product_per_page');
        $search = "%" . $request->search . "%";
        $products = ViewProduct::where('id', 'LIKE', $search)->orWhere('name', 'LIKE', $search)->paginate($numOfItem);

        return view(config('constant.site_view').'product.list', [
            'products' => $products,
            'search' => $request->search
        ]);
    }
}

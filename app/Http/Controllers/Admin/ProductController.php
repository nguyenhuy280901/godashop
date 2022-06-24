<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ViewProduct;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = ViewProduct::with('brand', 'category')->get();
        $data = [
            "products" => $products,
        ];
        return view('admin.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $data = [
            "categories" => $categories,
            "brands" => $brands,
        ];
        return view('admin.product.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image = $request->featured_image;
        $file_extension = $image->getClientOriginalExtension();
        $file_name = "$request->barcode.$file_extension";
        $image->move('images/', $file_name);

        $data = [
            "created_date" => date('Y-m-d'),
            "discount_percentage" => $request->discount_percentage ?? 0,
            "discount_from_date" => $request->discount_from_date ?? date('0000-00-00'),
            "discount_to_date" => $request->discount_to_date ?? date('0000-00-00'),
            "featured_image" => $file_name,
        ];

        $product_info = array_merge($data, $request->only("barcode", "sku", "name", "price", "inventory_qty", "category_id", "brand_id", "description", "star", "featured"));
        
        try {
            Product::Create($product_info);
            $message_type = "success";
            $message = "Thêm sản phẩm thành công";
        } catch (Exception $e) {
            dd($e);
            $message_type = "error";
            $message = "Thêm sản phẩm thất bại";
        }

        session()->put($message_type, $message);
        return redirect()->route('admin.product.index');
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
        $brands = Brand::all();
        $data = [
            "categories" => $categories,
            "brands" => $brands,
        ];
        return view('admin.product.edit', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Search product by barcode
     */
    public function search($pattern){
        $products = ViewProduct::where("barcode", "LIKE", "%$pattern%")->get();
        $data = [
            "products" =>$products
        ];
        return view('admin.product.search', $data);
    }

    /**
     * Search product by barcode
     */
    public function find($barcode){
        $product = ViewProduct::where("barcode", $barcode)->first();
        return json_encode($product);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Exception;

class CategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index()
    {
        $categories = Category::all();
		$data = [
			'categories' => $categories
		];
		return view('admin.category.index', $data);
    }

	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
    	return view('admin.category.add', $data);
    }

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		try {
			Category::create($request->all());
			$message_type = "success";
            $message = "Thêm danh mục thành công";
		} catch (Exception $e) {
			$message_type = "error";
            $message = "Thêm danh mục thất bại";
		}

		session()->put($message_type, $message);
		return redirect()->route('admin.category.index');
    }

	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
		$data = [
			'category' => $category
		];
		return view('admin.category.edit', $data);
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
		try {
			Category::find($id)->update($request->only("name"));
			$message_type = "success";
            $message = "Cập nhật danh mục thành công";
		} catch (Exception $e) {
			$message_type = "error";
            $message = "Cập nhật danh mục thất bại";
		}
		
		session()->put($message_type, $message);
		return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		try {
			Category::find($id)->delete();
			$message_type = "success";
            $message = "Xóa danh mục thành công";
		} catch (Exception $e) {
			$message_type = "error";
            $message = "Xóa danh mục thất bại";
		}
		
        session()->put($message_type, $message);
		return redirect()->route('admin.category.index');
    }
}
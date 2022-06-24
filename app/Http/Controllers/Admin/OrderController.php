<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Province;
use App\Models\Staff;
use App\Models\Status;
use App\Models\ViewProduct;
use Exception;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conds = [];
        $orders = Order::where($conds)->with(['customer', 'staff', 'ward', 'status', 'ward.district', 'ward.district.province'])->get();
        $data = [
            'orders' => $orders,
        ];
        return view('admin.order.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = Status::all();
        $staffs = Staff::all();
        $customers = Customer::all();
        $provinces = Province::all();

        $data = [
            'statuses' => $statuses,
            'staffs' => $staffs,
            'customers' => $customers,
            'provinces' => $provinces,
        ];
        return view('admin.order.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = [
            "created_date" => date('Y-m-d H:i:s'),
            "shipping_ward_id" => $request->ward,
            "shipping_housenumber_street" => $request->housenumber_street,
        ];
        $price = $this->getPrice($request->product_ids, $request->qties, $request->shipping_fee);
        $order_info = array_merge($data, $price, $request->only("order_status_id", "shipping_fullname", "shipping_mobile", "payment_method", "delivered_date", "staff_id", "customer_id", "shipping_fee"));
        
        try {
            $order = Order::create($order_info);
            $this->storeOrderItem($order, $request->product_ids, $request->qties);
            $message_type = "success";
            $message = "Thêm đơn hàng thành công";
        } catch (Exception $e) {
            $message_type = "error";
            $message = "Thêm đơn hàng thất bại";
        }

        session()->put($message_type, $message);
        return redirect()->route('admin.order.index');
    }

    public function getPrice($product_ids, $qties, $shipping_fee)
    {
        $result = [
            "price_total" => 0,
            "sub_total" => 0,
            "tax" => 0,
            "price_inc_tax_total" => 0,
            "payment_total" => 0,
        ];

        $products = ViewProduct::whereIn('id', $product_ids)->get(["sale_price"]);
        foreach($products as $key => $product){
            $result["price_total"] += $product->sale_price * $qties[$key];
        }

        $result["sub_total"] = $result["price_total"];
        $result["tax"] = $result["sub_total"] * env("TAX_PERCENT", 10) / 100;
        $result["price_inc_tax_total"] = $result["sub_total"] + $result["tax"];
        $result["payment_total"] = $result["price_inc_tax_total"] + $shipping_fee;

        return $result;
    }

    public function storeOrderItem($order, $product_ids, $qties) {
        $products = ViewProduct::whereIn('id', $product_ids)->get(["id", "sale_price"]);
        foreach($products as $key => $product){
            OrderItem::create([
                "order_id" => $order->id,
                "product_id" => $product->id,
                "qty" => $qties[$key],
                "unit_price" => $product->sale_price,
                "total_price" => $product->sale_price * $qties[$key],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $order = Order::findOrFail($id);
        } catch(ModelNotFoundException $e) {
            session()->put("error", "Không tìm thấy đơn hàng bạn muốn xem!");
            return redirect()->route('admin.order.index');
        }

        $data = [
            'order' => $order,
        ];
        return view('admin.order.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $order = Order::findOrFail($id);
        } catch(ModelNotFoundException $e) {
            session()->put("error", "Không tìm thấy đơn hàng bạn muốn sửa!");
            return redirect()->route('admin.order.index');
        }

        $statuses = Status::all();
        $staffs = Staff::all();
        $provinces = Province::all();

        $data = [
            'order' => $order,
            'statuses' => $statuses,
            'staffs' => $staffs,
            'provinces' => $provinces,
        ];
        return view('admin.order.edit', $data);
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
        $data = $request->only("order_status_id", "shipping_fullname", "shipping_mobile", "payment_method", "delivered_date", "staff_id", "shipping_fee");
        $data["shipping_ward_id"] = $request->ward;
        $data["shipping_housenumber_street"] = $request->housenumber_street;
        try {
            Order::find($id)->update($data);
            $message_type = "success";
            $message = "Cập nhật đơn hàng thành công";
        } catch (Exception $e) {
            // dd($e);
            $message_type = "error";
            $message = "Cập nhật đơn hàng thất bại";
        }

        session()->put($message_type, $message);
        return redirect()->route('admin.order.index');
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
			Order::find($id)->delete();
			$message_type = "success";
            $message = "Xóa đơn hàng thành công";
		} catch (Exception $e) {
			$message_type = "error";
            $message = "Xóa đơn hàng thất bại";
		}
		
        session()->put($message_type, $message);
		return redirect()->route('admin.order.index');
    }

    public function confirm($id)
    {
        // 2 is status_id of cancel order
        Order::find($id)->update(["order_status_id" => 2]);
        return redirect()->back();
    }
}

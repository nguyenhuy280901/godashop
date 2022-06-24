<?php

namespace App\Http\Controllers\Site;

use Cart;
use Auth;
use Mail;
use Session;
use Exception;
use App\Models\Ward;
use App\Models\Order;
use App\Models\Province;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Discount;

class PaymentController extends Controller
{   
    /**
     * Display check out page
     * 
     * @return \Illuminate\Http\Response
     */
    public function checkout(){
        $cart = Cart::content();
        $customer = Auth::user();
        $provinces = Province::all();
        
        // Chưa active acount
        if(isset($customer) && $customer->is_active == 0){
            Session::flash("status", "error");
            Session::flash("message", config('message.unverified_account'));

            return redirect()->back();
        }

        $customer_ward = null;
        $customer_district = null;
        $customer_province = null;
        $transport = null;

        if(isset($customer) && isset($customer->ward_id)){
            $customer_ward = $customer->ward;
            $customer_district = $customer_ward->district;
            $customer_province = $customer_district->province;
            $transport = $customer_province->transport;
        }

        return view(config('constant.site_view').'payment.checkout', [
            "cart" => $cart,
            "transport" => $transport,
            "customer" => $customer,
            "provinces" => $provinces,
            "customer_ward" => $customer_ward,
            "customer_district" => $customer_district,
            "customer_province" => $customer_province,
        ]);
    }

    /**
     * Store new order
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        // Store order
        $orderInfo = $this->getOrderInfo();
        try {
            $order = Order::create($orderInfo);
        } catch (Exception $e) {
            dd($e);
            Session::flash("status", "error");
            Session::flash("message", config('message.order_fail'));
            return redirect()->back();
        }

        // Store order item
        $this->storeOrderItem($order);

        // Update usage discount and voucher code
        $this->updateUsageDiscountCode($order);

        // Send mail
        $this->sendMail($order);

        // Delete cart
        $this->eraseFromDB();
        Cart::destroy();

        request()->session()->put("order_id", $order->id);
        return redirect()->route('order.store.success');
    }

    public function getOrderInfo() {
        $customer_id =  Auth::user()->id ?? config('constant.passersby_id');
        $delivery_days = config('constant.delivery_days');
        $delivered_date = strtotime("+$delivery_days day");

        $voucher_amount = session()->pull("voucher_amount") ?? 0;
        $shippingfee = request()->shippingfee;

        return [
            "created_date" => date("Y-m-d H:i:s"),
            "order_status_id" => 1,
            "customer_id" => $customer_id,
            "shipping_fullname" => request()->fullname,
            "shipping_mobile" => request()->mobile,
            "payment_method" => request()->payment_method,
            "shipping_ward_id" => request()->ward,
            "shipping_housenumber_street" => request()->housenumber_street,
            "shipping_fee" => $shippingfee,
            "delivered_date" => date("Y-m-d", $delivered_date),
            "price_total" => Cart::priceTotal(0, "", ""),
            "discount_code" => session()->pull("discount_code"),
            "discount_amount" => Cart::discount(0,"", ""),
            "sub_total" => Cart::subtotal(0, "", ""),
            "tax" => Cart::tax(0, "", ""),
            "price_inc_tax_total" => Cart::total(0, "", ""),
            "voucher_code" => session()->pull("voucher_code"),
            "voucher_amount" => $voucher_amount,
            "payment_total" => Cart::total(0, "", "") + $shippingfee - $voucher_amount,
        ];
    }

    public function storeOrderItem($order) {
        $order_id = $order->id;
        foreach(Cart::content() as $item){
            OrderItem::Create([
                "product_id" => $item->id,
                "order_id" => $order_id,
                "qty" => $item->qty,
                "unit_price" => $item->price,
                "total_price" => $item->qty * $item->price,
            ]);
        }
    }

    public function sendMail($order) {
        if(!Auth::check()){
            return;
        }

        $customer = Auth::user();
        $subtotal = Cart::total();
        $shipping_address = $this->getAddress($order->shipping_ward_id, $order->shipping_housenumber_street);
        $total = number_format(Cart::total(0, "", "") + $order->shipping_fee - $order->voucher_amount);

        $data = [
            "order" => $order,
            "subtotal" => $subtotal,
            "total" => $total,
            "shipping_address" => $shipping_address,
        ];

        Mail::send(config('constant.site_view').'mail.orderSuccess', $data, function($message) use($customer) {
            $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
            $message->sender(env('MAIL_USERNAME'), env('APP_NAME'));
            $message->to($customer->email, $customer->name);
            $message->subject(env('APP_NAME') . ': Order Success');
        });
    }

    public function storeSuccess(){
        $order_id = session()->pull('order_id');
        if(!$order_id) {
            return redirect()->route('home');
        }
        return view(config('constant.site_view').'payment.orderSuccess', ['order_id' => $order_id]);
    }

    public function updateUsageDiscountCode($order){
        $discounts = Discount::whereIn("code", [$order->discount_code, $order->voucher_code])->get();

        foreach($discounts as $discount){
            $discount->current_usage++;
            $discount->update();
        }
    }

    public function getAddress($ward_id, $housenumber_street){
        $ward = Ward::find($ward_id);
        $district = $ward->district;
        $province = $district->province;

        $address = $housenumber_street;
        $address .= ", " . $ward->name;
        $address .= ", " . $district->name;
        $address .= ", " . $province->name;

        return $address;
    }

    public function eraseFromDB(){
        if(Auth::check()){
            Cart::erase(Auth::user()->email);
        }
    }
}

<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use Session;
use Hash;
use Auth;

class CustomerController extends Controller
{
    /**
     * Display information of customer
     * @return \Illuminate\Http\Response
     */
    public function info(){
        $customer = Auth::user();
        return view(config('constant.site_view').'customer.info', [
            "customer" => $customer
        ]);
    }

    /**
     * Update information of customer
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        $customer = Auth::user();

        if($request->action == 'update-info'){
            $customer->name = $request->fullname;
            $customer->mobile = $request->mobile;
            $message = config('message.update_info_success');
        }else{
            $customer->password = Hash::make($request->password);
            $message = config('message.reset_pwd_success');
        }

        $customer->update();

        Session::flash('status', "success");
        Session::flash('message', $message); 
        return redirect()->route('customer.info.show');
    }

    /**
     * Display information of shipping
     * @return \Illuminate\Http\Response
     */
    public function shipping(){
        $customer = Auth::user();
        $provinces = Province::all();

        $customer_ward = null;
        $customer_district = null;
        $customer_province = null;

        if(isset($customer->ward_id)){
            $customer_ward = $customer->ward;
            $customer_district = $customer_ward->district;
            $customer_province = $customer_district->province;
        }
        
        return view(config('constant.site_view').'customer.shipping', [
            "customer" => $customer,
            "provinces" => $provinces,
            "customer_ward" => $customer_ward,
            "customer_district" => $customer_district,
            "customer_province" => $customer_province
        ]);
    }

    /**
     * Update shipping information of customer
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateShipping(Request $request){
        $customer = Auth::user();

        $customer->shipping_name = $request->fullname;
        $customer->shipping_mobile = $request->mobile;
        $customer->ward_id = $request->ward;
        $customer->housenumber_street = $request->housenumber_street;
        $customer->update();

        Session::flash('status', "success");
        Session::flash('message', config('message.update_info_success')); 
        return redirect()->back();
    }

    /**
     * Display list order of customer
     * @return \Illuminate\Http\Response
     */
    public function listOrder(){
        $customer = Auth::user()->load(['orders', 'orders.orderItems', 'orders.orderItems.product', 'orders.status']);
        return view(config('constant.site_view').'order.list', [
            "customer" => $customer
        ]);
    }
}

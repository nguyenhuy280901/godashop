<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\ViewProduct;
use Cart;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CartController extends Controller
{
    /**
     * get cart
     * 
     * @return \Illuminate\Http\Response
     */
    public function get(){
        $this->restoreFromDB();
        $this->storeIntoDB();

        $cart = Cart::content();
        return json_encode($cart);
    }

    /**
     * Add item into cart
     * 
     * @param int $id
     * @param int $qty
     * @return \Illuminate\Http\Response
     */
    public function add($id, $qty){
        $product = ViewProduct::find($id);

        $this->restoreFromDB();

        Cart::add([
            'id' => $id,
            'name' => $product->name,
            'qty' => $qty,
            'price' => intval(str_replace(',', '', $product->sale_price)),
            'weight' => 0,
            'options' => [
                'featured_image' => $product->featured_image
            ]
        ]);

        $this->storeIntoDB();
        return json_encode(Cart::content());
    }

    /**
     * Update quanlity of item in cart
     * 
     * @param int $id
     * @param int $qty
     * @return \Illuminate\Http\Response
     */
    public function update($id, $qty){
        $this->restoreFromDB();

        Cart::update($id, $qty);

        $this->storeIntoDB();
        return json_encode(Cart::content());
    }

    /**
     * Delete item in cart
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        $this->restoreFromDB();

        Cart::remove($id);

        $this->storeIntoDB();
        return json_encode(Cart::content());
    }

    public function storeIntoDB(){
        if(Auth::check()){
            Cart::store(Auth::user()->email);
        }
    }

    public function restoreFromDB(){
        if(Auth::check()){
            Cart::restore(Auth::user()->email);
        }
    }

    public function discount() {
        $discount_code = request()->input('discount-code');
        $conds = [
            ["code", "=", $discount_code],
            ["is_fixed", "=", 0],// 0 is type of discount code
        ];

        try {
            $discount = Discount::where($conds)->firstOrFail();

            $today = date("Y-m-d H:i:s");
            $checkCode = $today >= $discount->starts_at;
            $checkCode &= $today <= $discount->expires_at;
            $checkCode &= $discount->limited_quantity > $discount->current_usage;

            if($checkCode){
                $discount_amount = $discount->discount_amount;

                request()->session()->forget("error_discount_code");
                request()->session()->put("discount_code", $discount_code);
            } else {
                $discount_amount = 0;

                request()->session()->forget("discount_code");
                request()->session()->put("error_discount_code", config("message.invalid_discount_code"));
            }
        } catch (ModelNotFoundException $e) {
            $discount_amount = 0;

            request()->session()->forget("discount_code");
            request()->session()->put("error_discount_code", config("message.invalid_discount_code"));
        }

        $this->restoreFromDb();
        Cart::setGlobalDiscount($discount_amount);
        $this->storeIntoDb();

        return redirect()->back();
    }

    public function voucher(){
        $voucher_code = request()->input('voucher-code');
        $conds = [
            ["code", "=", $voucher_code],
            ["is_fixed", "=", 1],// 1 is type of voucher code
        ];

        try {
            $discount = Discount::where($conds)->firstOrFail();

            $today = date("Y-m-d H:i:s");
            $checkCode = $today >= $discount->starts_at;
            $checkCode &= $today <= $discount->expires_at;
            $checkCode &= $discount->limited_quantity > $discount->current_usage;

            if($checkCode){
                $discount_amount = $discount->discount_amount;

                request()->session()->forget("error_voucher_code");
                request()->session()->put("voucher_code", $voucher_code);
            } else {
                $discount_amount = 0;

                request()->session()->forget("voucher_code");
                request()->session()->put("error_voucher_code", config("message.invalid_voucher_code"));
            }
        } catch (ModelNotFoundException $e) {
            $discount_amount = 0;

            request()->session()->forget("voucher_code");
            request()->session()->put("error_voucher_code", config("message.invalid_voucher_code"));
        }
        
        request()->session()->put("voucher_amount", $discount_amount);

        return redirect()->back();
    }
}

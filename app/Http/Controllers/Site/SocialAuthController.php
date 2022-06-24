<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Auth;
use Session;
use Socialite;

class SocialAuthController extends Controller
{
    /**
     * 
     * 
     * @param string $social
     * @return \Illuminate\Http\Response
     */
    public function redirect($social){
        return Socialite::driver($social)->redirect();
    }

    /**
     * Get informmation of user after login Facebook
     * 
     * @param string $social
     * @return \Illuminate\Http\Response
     */
    public function callback($social){
        $user = Socialite::driver($social)->user();
        // dd($user->id);
        if(Customer::where('email', $user->email)->whereNotIn('login_by', [$social])->first() instanceof Customer){
            Session::flash('status', "error");
            Session::flash('message', config('message.login_social_fail.registered_email'));
            return redirect()->route('home');
        }

        $customer = Customer::firstOrNew([
            "social_id" => $user->id,
            "email" => $user->email,
            "login_by" => $social
        ]);

        if (!$customer->exists) {
            // user created from 'new', does not exist in database.
            $customer->name = $user->name;
            $customer->is_active = 1;
            $customer->save();
        } else if($customer->name != $user->name) {
            $customer->name = $user->name;
            $customer->save();
        }

        Auth::login($customer, false);
        return redirect()->route('home');
    }
}

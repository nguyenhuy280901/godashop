<?php

namespace App\Http\Controllers\Site;

use Str;
use Auth;
use Mail;
use Hash;
use Crypt;
use Session;
use Validator;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    /**
     * Login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        $credentials = $request->only('email', 'password', 'login_by');
        $remember = isset($request->remember_me);
        if(Auth::attempt($credentials, $remember)){
            return redirect()->back();
        }

        // Login fail
        Session::flash('status', "error");
        Session::flash('message', config('message.login_fail')); 
        return redirect()->back();
    }

    /**
     * Register account
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){
        // Check validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|max:100',
            'password' => 'required|max:100',
            'mobile' => 'required|max:15',
            'g-recaptcha-response' => 'required|captcha', // Check captcha
        ]);

        // Validate data fail
        if($validator->fails()){
            Session::flash('status', "error");
            Session::flash('message', config('message.register_fail')); 
            return redirect()->back();
        }

        // Send verify mail
        $token = Crypt::encryptString($request->email);
        $email = $request->email;
        $name = $request->name;
        Mail::send(config('constant.site_view').'mail.activeAcount', ["token" => $token, "name" => $request->name], function($message) use ($email, $name){
            $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
            $message->sender(env('MAIL_USERNAME'), env('APP_NAME'));
            $message->to($email, $name);
            $message->subject(env('APP_NAME') . ': Verify account');
        });

        // Send mail fail
        if(Mail::failures()){
            Session::flash('status', "error");
            Session::flash('message', config('message.register_fail')); 
            return redirect()->back();
        }

        // Create customer
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'login_by' => "form",
            'shipping_name' => $request->name,
            'shipping_mobile' => $request->mobile
        ];
        $customer = Customer::create($data);
        Auth::login($customer, false);
        
        // Set session message and redirect
        Session::flash('status', 'success');
        Session::flash('message', Str::replaceFirst('#email', $request->email, config('message.register_success')));
        return redirect()->back();
    }

    /**
     * Verify email
     * @param string $token
     * @return \Illuminate\Http\Response
     */
    public function verify($token){
        try {
            $email = Crypt::decryptString($token);
            $customer = Customer::where('email', $email)->firstOrFail();
            // if email has already verify
            Auth::login($customer);
            if($customer->is_active == 1){
                Session::flash('status', "success");
                Session::flash('message', config('message.verify_before')); 
                return redirect()->route('home');
            }

            // Active acount
            $customer->is_active = 1;
            $customer->update();

            Session::flash('status', "success");
            Session::flash('message', config('message.verify_success')); 
            return redirect()->route('home');
        } catch (ModelNotFoundException | DecryptException $e) {
            Session::flash('status', "error");
            Session::flash('message', config('message.verify_fail'));
            return redirect()->route('home');
        }
    }

    /**
     * Send mail reset password for customer
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(Request $request){
        try{
            $token = Str::random(60);
            $customer = Customer::where('email', $request->email)->firstOrFail();

            PasswordReset::create([
                "token" => $token,
                "email" => $customer->email
            ]);

            // Send mail
            $email = $customer->email;
            $name = $customer->name;
            Mail::send(config('constant.site_view').'mail.resetPassword', ["token" => $token, "email" => $email, "name" => $name], function($message) use ($email, $name){
                $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
                $message->sender(env('MAIL_USERNAME'), env('APP_NAME'));
                $message->to($email, $name);
                $message->subject(env('APP_NAME') . ': Reset Password');
            });

            // Send mail fail
            if(Mail::failures()){
                Session::flash('status', "error");
                Session::flash('message', config('message.send_mail_fail')); 
                return redirect()->back();
            }

            Session::flash('status', "success");
            Session::flash('message', Str::replaceFirst('#email', $email, config('message.send_mail_success')));
            return redirect()->back();
        }catch(ModelNotFoundException $e){
            Session::flash('status', "error");
            Session::flash('message', config('message.unregistered_email')); 
            return redirect()->back();
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     * @param  string $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm($token, $email){
        try{
            $resetpassWord = PasswordReset::where([
                ['token', $token],
                ['email', $email]
            ])->firstOrFail();

            $customer = Customer::where('email', $resetpassWord->email)->firstOrFail();
            Auth::login($customer);

            $resetpassWord->delete();
            return view(config('constant.site_view').'customer.info', [
                "customer" => $customer
            ]);
        }catch(ModelNotFoundException $e){
            Session::flash('status', "error");
            Session::flash('message', config('message.show_reset_form_fail')); 
            return redirect()->back();
        }
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(){
        Auth::logout();
        return redirect()->back();
    }
}

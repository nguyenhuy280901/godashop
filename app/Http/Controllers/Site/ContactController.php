<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;

class ContactController extends Controller
{
    /**
     * Display contact page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(config('constant.site_view').'contact.index');
    }

    /**
     * send contact information email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendMail(Request $request)
    {
        $data = [
            "fullname" => $request->fullname,
            "email" => $request->email,
            "mobile" => $request->mobile,
            "content" => $request->content,
            "date" => date('l jS \, F Y h:i:s A')
        ];
        Mail::send(config('constant.site_view').'mail.contact', $data, function ($message) {
            $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
            $message->sender(env('MAIL_USERNAME'), env('APP_NAME'));
            $message->to(env('MAIL_USERNAME'), "Quản trị viên");
            $message->subject('Customer information');
        });

        // check for failures
        if (Mail::failures()) {
            // return response showing failed emails
            return "fail";
        }

        // otherwise everything is okay ...
        return "success";
    }
}

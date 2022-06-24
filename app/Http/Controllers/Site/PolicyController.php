<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PolicyController extends Controller
{
    /**
     * Display a page of return policy.
     *
     * @return \Illuminate\Http\Response
     */
    public function return()
    {
        return view(config('constant.site_view').'policy.return');
    }

    /**
     * Display a page of delivery policy.
     *
     * @return \Illuminate\Http\Response
     */
    public function delivery()
    {
        return view(config('constant.site_view').'policy.delivery');
    }

    /**
     * Display a page of payment policy.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment()
    {
        return view(config('constant.site_view').'policy.payment');
    }
}

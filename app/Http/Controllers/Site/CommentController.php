<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Auth;

class CommentController extends Controller
{
    /**
     * Post the comment
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request){
        $customer = Auth::user();

        $data = [
            "customer_id" => $customer->id,
            "product_id" => $request->product_id,
            "star" => $request->rating,
            "description" => $request->description,
        ];
        $comment = Comment::create($data);
        

        return view(config('constant.site_view').'comment.comment', [
            "comment" => $comment
        ]);
    }
}

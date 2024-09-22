<?php

namespace App\Http\Controllers\User\UserGuest;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class UserGuestController extends Controller
{
    public function get_all_blog()
    {
        try {
            $blogs = Blog::where('status', true)->get();
    
            if($blogs->count() > 0){
                return response()->json([
                    'status' => 200,
                    'blogs' => $blogs
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'msg' => "No blogs available",
                ], 404);
            }
    
        } catch (\Exception $err) {
            return response()->json([
                'status' => 500,
                'msg' => "Internal Server Error",
                'err_msg' => $err->getMessage()
            ], 500);
        }
    }
    
}

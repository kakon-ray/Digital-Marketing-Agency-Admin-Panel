<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $total_user = Admin::where('role','admin')->count();
        $total_user_request = Admin::where('role','user')->count();
        $total_blog = Blog::count();
        $total_blog_category = BlogCategory::count();
        return view('admin.dashboard.dashboard',compact('total_user','total_blog','total_blog_category','total_user_request'));
    }

    public function admin_manage()
    {
        $admin = Admin::get();
        return view('admin.admin_role.admin_manage', compact('admin'));
    }

    public function admin_manage_toggle(Request $request)
    {
        $admin = Admin::find($request->id);

        if (is_null($admin)) {
            return response()->json([
                'msg' => "Blog Doesn't Exist",
                'status' => 404
            ], 404);
        } else {
            try {
                if ($admin->role == 'user') {
                    $admin->role = 'admin';
                    $message = 'Admin Permission Enable';
                } else if($admin->role == 'admin'){
                    $admin->role = 'user';
                    $message = 'Admin Permission Disable';
                }

                // Save the updated status
                $admin->save();

                return response()->json([
                    'status' => 200,
                    'msg' => $message,
                ], 200);
            } catch (\Exception $err) {
                return response()->json([
                    'msg' => "Internal Server Error",
                    'status' => 500,
                    'err_msg' => $err->getMessage()
                ], 500);
            }
        }
    }


    // add course  ck editor image upload
    public function storeImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('img/blog'), $fileName);

            $url = asset('img/blog/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }
}

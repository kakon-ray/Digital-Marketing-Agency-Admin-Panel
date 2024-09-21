<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;


class BlogController extends Controller
{
    public function blog_create()
    {
        return view('admin.blog.blog_add');
        
    }

    public function blog_update(Request $request)
    {
        $blog = Blog::where('id',$request->id)->first();
        return view('admin.blog.blog_update',compact('blog'));
        
    }
    
    public function blog_submit(Request $request)
    {
        $arrayRequest = [
            "title" => $request->title,
            "desc" => $request->desc,
            "image" => $request->image,
            "category" => $request->category,

        ];

        $arrayValidate  = [
            'title' => 'required',
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'desc' => 'required',
            'category' => 'required',

        ];

        $response = Validator::make($arrayRequest, $arrayValidate);

        if ($response->fails()) {
            $msg = '';
            foreach ($response->getMessageBag()->toArray() as $item) {
                $msg = $item;
            };

            return response()->json([
                'status' => 400,
                'msg' => $msg[0]
            ]);
        } else {
            // Db::beginTransaction();

            try {
                $slug = Str::slug($request->title, '-');
                $file = $request->file('image');
                $filename = $slug . '-' . hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
    
                $img = Image::make($file);
                $img->resize(500, 300)->save(public_path('blogs/' . $filename));
    
                $host = $_SERVER['HTTP_HOST'];
                $image = "http://" . $host . "/blogs/" . $filename;

                $blog = Blog::create([
                    'title' => $request->title,
                    'desc' => $request->desc,
                    'image' => $image,
                    'category' => $request->category,
                ]);

                // DB::commit();

            } catch (\Exception $err) {
                $blog = null;
            }

            if ($blog != null) {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Blog Add Successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'msg' => 'Internal Server Error',
                    'err_msg' => $err->getMessage()
                ]);
            }
        }
        
    }


    public function blog_update_submit(Request $request)
    {
        $blog = Blog::find($request->id);

        if (is_null($blog)) {
            return response()->json([
                'msg' => "Blog dosen't exists",
                'status' => 404
            ], 404);
        } else {
            if ($request->image) {
                $arrayRequest = [
                    'title' => $request->title,
                    'desc' => $request->desc,
                    'category' => $request->category,
                    'image' => $request->image,
                ];

                $arrayValidate  = [
                    'title' => 'required',
                    'desc' => 'required',
                    'category' => 'required',
                    'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg'],

                ];
            } else {
                $arrayRequest = [
                    'title' => $request->title,
                    'desc' => $request->desc,
                    'category' => $request->category,
                ];

                $arrayValidate  = [
                    'title' => 'required',
                    'desc' => 'required',
                    'category' => 'required',

                ];
            }


            $response = Validator::make($arrayRequest, $arrayValidate);

            if ($response->fails()) {
                $msg = '';
                foreach ($response->getMessageBag()->toArray() as $item) {
                    $msg = $item;
                };

                return response()->json([
                    'status' => 400,
                    'msg' => $msg
                ]);
            } else {
              

                try {

                    $slug = Str::slug($request->title, '-');
                    if ($request->image) {
                        $pathinfo = pathinfo($blog->image);
                        $filename = $pathinfo['basename'];
                        $image_path = public_path("/uploads/") . $filename;

                        if (File::exists($image_path)) {
                            File::delete($image_path);
                        }

                        $file = $request->file('image');
                        $filename = $slug . '-' . hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            
                        $img = Image::make($file);
                        $img->resize(500, 300)->save(public_path('blogs/' . $filename));
            
                        $host = $_SERVER['HTTP_HOST'];
                        $image = "http://" . $host . "/blogs/" . $filename;
                    } else {
                        $image = $request->old_image;
                    }


                    $blog->title = $request->title;
                    $blog->desc = $request->desc;
                    $blog->category = $request->category;
                    $blog->image = $image;

                    $blog->save();
 

                } catch (\Exception $err) {
                    $blog = null;
                }

                if (is_null($blog)) {
                    return response()->json([
                        'status' => 500,
                        'msg' => 'Internal Server Error',
                        'err_msg' => $err->getMessage()
                    ]);
                } else {
                    return response()->json([
                        'status' => 200,
                        'msg' => 'Blog Update Successfylly'
                    ]);
                }
            }
        }
        
    }

    public function blog_manage(Request $request){
        $blogs = Blog::all();
        return view('admin.blog.blog_manage',compact('blogs'));
    }

    public function blog_delete(Request $request){
        $blog = Blog::find($request->id);

        if (is_null($blog)) {

            return response()->json([
                'msg' => "Blog Doesnt Exists",
                'status' => 404
            ], 404);
        } else {


            try {

                $pathinfo = pathinfo($blog->image);
                $filename = $pathinfo['basename'];
                $image_path = public_path("/blogs/") . $filename;

                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                
                $blog->delete();

                return response()->json([
                    'status' => 200,
                    'msg' => 'Delete Blog',
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
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;


class BlogController extends Controller
{

    // this is blog category section
    public function blog_category_create()
    {
        return view('admin.blog_category.add_category');
    }

    public function blog_category_update(Request $request)
    {
        $blog = BlogCategory::where('id', $request->id)->first();
        return view('admin.blog_category.update_category', compact('blog'));
    }
    public function blog_category_manage()
    {
        $categories = BlogCategory::all();
        return view('admin.blog_category.category_manage', compact('categories'));
    }
    public function blog_category_submit(Request $request)
    {
        $slug = Str::slug($request->category_name, '-');

        $existCategory = BlogCategory::where('category_slug', $slug)->count();
        if ($existCategory) {
            return response()->json([
                'status' => 200,
                'msg' => 'Already have this category please enter new category'
            ]);
        }

        $arrayRequest = [
            "category_name" => $request->category_name,
        ];

        $arrayValidate  = [
            'category_name' => 'required',
        ];

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
        }

        try {


            $blogcategory = BlogCategory::create([
                'category_name' => $request->category_name,
                'category_slug' =>  $slug,
            ]);

            if ($blogcategory) {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Blog Category Add Successfully'
                ]);
            }
        } catch (\Exception $err) {
            return response()->json([
                'status' => 500,
                'msg' => 'Internal Server Error',
                'err_msg' => $err->getMessage()
            ]);
        }
    }
    public function blog_category_update_submit(Request $request)
    {
        $slug = Str::slug($request->category_name, '-');

        // Check if the category slug already exists
        $existCategory = BlogCategory::where('category_slug', $slug)->count();
        if ($existCategory) {
            return response()->json([
                'status' => 200,
                'msg' => 'This category already exists, please enter a new category'
            ]);
        }

        // Prepare the data for validation
        $arrayRequest = [
            "category_name" => $request->category_name,
        ];

        // Set validation rules
        $arrayValidate  = [
            'category_name' => 'required',
        ];

        // Perform validation
        $response = Validator::make($arrayRequest, $arrayValidate);

        if ($response->fails()) {
            $msg = '';
            foreach ($response->getMessageBag()->toArray() as $item) {
                $msg = $item;
            }

            return response()->json([
                'status' => 400,
                'msg' => $msg
            ]);
        }

        try {
            // Update the blog category
            $blogcategory = BlogCategory::where('id', $request->id)->update([
                'category_name' => $request->category_name,
                'category_slug' =>  $slug,
            ]);

            if ($blogcategory) {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Blog Category Updated Successfully'
                ]);
            }
        } catch (\Exception $err) {
            return response()->json([
                'status' => 500,
                'msg' => 'Internal Server Error',
                'err_msg' => $err->getMessage()
            ]);
        }
    }

    public function blog_cateogry_delete(Request $request)
    {
        $blogcategory = BlogCategory::find($request->id);

        if (is_null($blogcategory)) {

            return response()->json([
                'msg' => "Blog Category Doesnt Exists",
                'status' => 404
            ], 404);
        } else {


            try {

                $blogcategory->delete();

                return response()->json([
                    'status' => 200,
                    'msg' => 'Delete Blog Category',
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


    // this is blog section
    public function blog_create()
    {
        $blog_category = BlogCategory::all();
        return view('admin.blog.blog_add', compact('blog_category'));
    }

    public function blog_update(Request $request)
    {
        $blog = Blog::where('id', $request->id)->first();
        $blog_category = BlogCategory::all();
        return view('admin.blog.blog_update', compact('blog', 'blog_category'));
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
                    'blogcategory_id' => $request->category,
                    'status' => false,
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
                    $blog->blogcategory_id = $request->category;
                    $blog->image = $image;
                    $blog->status = false;

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

    public function blog_manage(Request $request)
    {
        $blogs = Blog::all();
        $blog_category = BlogCategory::all();
        return view('admin.blog.blog_manage', compact('blogs', 'blog_category'));
    }

    public function blog_delete(Request $request)
    {
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


    public function blog_status(Request $request)
    {
        $blog = Blog::find($request->id);

        if (is_null($blog)) {
            return response()->json([
                'msg' => "Blog Doesn't Exist",
                'status' => 404
            ], 404);
        } else {
            try {
                if ($blog->status == false) {
                    $blog->status = true;
                    $message = 'Publish Blog';
                } else {
                    $blog->status = false;
                    $message = 'Unpublish Blog';
                }

                // Save the updated status
                $blog->save();

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
}

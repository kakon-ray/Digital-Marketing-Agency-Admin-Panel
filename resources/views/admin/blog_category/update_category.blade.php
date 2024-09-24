@extends('layouts.admin.master')
@section('title') {{'Dashboard | Laravel Auth '}} @endsection

@section('content')
<style>
    #add_services_image_show {
        max-width: 445px;
        height: 300px;
        margin-left: -4px;

    }

    .ck-editor__editable_inline {
        min-height: 400px;
    }

    #add_course_editor {
        height: 400px;
    }
</style>



<div class="container-fluid">

    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-header text-center">Update Blog Category</div>

                <div class="card-body mt-0">
                    <form method="POST" action="{{ route('blog.cateogry.update.submit') }}" id="submit_blog_category"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{$blog->id}}">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="my-4">
                                    <label>Category name</label>
                                    <input required type="text" class="form-control" name="category_name"
                                        placeholder="Enter New Category name">
                                </div>
                            </div>

                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
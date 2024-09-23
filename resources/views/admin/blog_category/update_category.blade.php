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

    <div class="card">
        <div class="card-header text-center">Update Blog Category</div>

        <div class="card-body mt-0">
            <form method="POST" action="{{ route('blog.submit') }}" id="submit_blog" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="my-4">
                            <label>Category name</label>
                            <input required type="text" class="form-control" name="title" placeholder="Enter New Category name">
                        </div>
                    </div>

                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
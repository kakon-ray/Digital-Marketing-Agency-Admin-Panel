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
        <div class="card-header text-center">Add Blog</div>

        <div class="card-body mt-0">
            <form method="POST" action="{{ route('blog.submit') }}" id="submit_blog" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="my-4">
                            <label>Blog Title</label>
                            <input required type="text" class="form-control" name="title" placeholder="Blog Title">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="my-4">
                            <div class="my-4">
                                <label class="form-label">Category</label>
                                <select class="form-control rounded-0" name="category">
                                    <option value="" >Select Blog Category</option>
                                    @foreach($blog_category as $item)
                                      <option value="{{$item->id}}">{{$item->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Blog Image</label>
                    <input type="file" name="image" required="" accept="image/*" class="dropify">
                </div>


                <div class="my-4">
                    <label>Blog Details</label>
                    <textarea class="form-control" id="add_course_editor" row="10" name="desc"></textarea>
                </div>


                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

{{-- image upload --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
<script src="{{ asset('public/backend') }}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<!-- axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


<script type="text/javascript">
    //thumbline image upload 
        $('.dropify').dropify(); //dropify image
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

</script>

@endsection
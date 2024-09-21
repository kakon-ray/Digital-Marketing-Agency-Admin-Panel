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
            <form method="POST" action="{{ route('blog.update.submit') }}" id="submit_blog"
                enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{$blog->id}}">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="my-4">
                            <label>Blog Title</label>
                            <input required type="text" class="form-control" name="title" value="{{$blog->title}}" placeholder="Blog Title">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="my-4">
                            <div class="my-4">
                                <label class="form-label">Category</label>
                                <select class="form-control rounded-0" name="category" value="{{$blog->category}}">
                                    <option value="Web Development" selected>Web Development</option>
                                    <option value="Laravel">Laravel</option>
                                    <option value="Web Design">Web Design</option>
                                    <option value="Front End Development">Front End Development</option>
                                    <option value="Back End Development">Back End</option>
                                    <option value="Programming">Programming</option>
                                    <option value="Digital Marketing">Digital Marketing</option>
                                    <option value="Video Editing">Video Editing</option>
                                    <option value="Laravel Website">Laravel Website</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Blog Image</label>
                    <input type="file" name="image" accept="image/*" class="dropify">
                    <input name="old_image" value="{{ $blog->image }}" type="text"
                    class="form-control d-none">
                </div>


                <div class="my-4">
                    <label>Blog Details</label>
                    <textarea class="form-control" id="add_course_editor" row="10" name="desc">@php echo $blog->desc @endphp</textarea>
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
@extends('layouts.admin.master')
@section('title') {{'Dashboard | Laravel Auth '}} @endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 pb-4 d-flex justify-content-between">
            <h3 class="text-center ">Manage Main<span style="color:#4e73df;"> Blog Item</span></h3>
            <a href="{{ route('blog.add') }}" type="button" class="btn btn-primary pt-2"><i
                    class="fas fa-plus me-2"></i> Add New Blog</a>
        </div>


        <div class="col-lg-12 table-responsive">
            <table id="VisitorDt" class="table table-bordered dataTable" cellspacing="0" width="100%">
                <thead class="table-dark ">
                    <tr>
                        <th class="th-sm text-center">Image</th>
                        <th class="th-sm text-center">Blog Title</th>
                        <th class="th-sm text-center">Blog Description</th>
                        <th class="th-sm text-center">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($blogs as $item)
                    <tr class="text-center">
                        <td class="th-sm "><img src="{{ $item->image }}" style="height:50px" alt="Course Image">
                        </td>
                        <td class="th-sm ">{{ $item->title }}</td>
                        <td class="th-sm">{{ substr(strip_tags($item->desc), 0, 100) }}...</td>

                        <td class="th-sm" style="min-width: 200px;">
                            <a href="{{ route('blog.update', ['id' => $item->id]) }}" type="button"
                                class="btn btn-info btn-circle btn-sm"><i class="fas fa-edit"></i></a>
                            <a type="button" onclick="delete_blog({!! $item->id !!})"
                                class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    const delete_blog = (id) => {
        Swal.fire({
            customClass: 'swalstyle',
            title: 'Are you sure?',
            text: "Delete this Services Item",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .get("/blog/delete", {
                        params: {
                            id: id
                        }
                    })
                    .then(function(response) {

                        if (response.data.status == 200) {
                            Swal.fire({
                                customClass: 'swalstyle',
                                position: 'top-center',
                                icon: 'success',
                                title: response.data.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            setTimeout(function() {
                                location.reload();
                            }, 1500);

                        } else {
                            Swal.fire({
                                customClass: 'swalstyle',
                                position: 'top-center',
                                icon: 'error',
                                title: response.data.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }


                    })
                    .catch(function(error) {
                        Swal.fire({
                            customClass: 'swalstyle',
                            position: "top-center",
                            icon: "error",
                            title: "Your form submission is not complete",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    });
            }
        })



    }
</script>


@endsection
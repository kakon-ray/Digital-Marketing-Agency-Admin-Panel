@extends('layouts.admin.master')
@section('title') {{'Dashboard | Laravel Auth '}} @endsection
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 pb-4 d-flex justify-content-between">
            <h3 class="text-center ">Manage Main<span style="color:#4e73df;"> Blog Category</span></h3>
            <a href="{{ route('blog.category.add') }}" type="button" class="btn btn-primary pt-2"><i
                    class="fas fa-plus me-2"></i> Add New Category</a>
        </div>


        <div class="col-lg-12 table-responsive">
            <table id="VisitorDt" class="table table-bordered dataTable" cellspacing="0" width="100%">
                <thead class="table-dark ">
                    <tr>
                        <th class="th-sm text-center">Admin Name</th>
                        <th class="th-sm text-center">Admin Email</th>
                        <th class="th-sm text-center">Admin Status</th>
                        <th class="th-sm text-center">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($admin as $item)
                    <tr class="text-center">


                        <td class="th-sm ">{{ $item->name }}</td>
                        <td class="th-sm ">{{ $item->email }}</td>
                        <td class="th-sm ">{{ $item->role }}</td>


                        <td class="th-sm" style="min-width: 200px;">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" style="cursor:pointer" {{$item->role
                                == 'admin' || $item->role == 'superadmin' ? 'checked' : ""}} onclick="admin_role_status({!! $item->id !!})" role="switch" id="flexSwitchCheckDefault">
                            </div>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    const admin_role_status = (id) => {
        Swal.fire({
            customClass: 'swalstyle',
            title: 'Are you sure?',
            text: "Change Admin Status",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .get("/admin/manage/toggle", {
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>

@endsection
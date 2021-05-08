@extends('admin.layouts.app')


@section('title')
Permissions
@endsection

@push('css')
<link rel="stylesheet" href="{{asset('datatable')}}/jquery.dataTables.css">

@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Permission Table</h3>

        <div class="card-tools">
            <a href="{{ route('permissions.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i>
                Create new permission</a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <div class="container pt-2">
            <table class="table table-hover" id="datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Display Name</th>
                        <th>Name</th>
                        <th>Group Name</th>
                        <th>Date Posted</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($permissions as $permission)
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td>{{ $permission->display_name }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->group_name }}</td>
                        <td>{{ $permission->created_at }}</td>
                        <td>
                            <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>

                            <button class="btn btn-sm btn-danger" data-value="{{$permission->id}}" id='deleteItem'
                                onclick="deleteConfirmation({{$permission->id}})">
                                <i class='far fa-trash-alt'></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>No Result Found</tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
    <!-- /.card-body -->
</div>
@endsection


@push('js')
<script src="{{asset('datatable')}}/jquery.dataTables.js"></script>

<script>
    $(function () {

      $('#datatable').DataTable({
        "responsive": true,
      });
    });
</script>
<script type="text/javascript">
    function deleteConfirmation(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: 'DELETE',
                    url: "{{url('/permissions')}}/" + id,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                            swal.fire("Done!", results.message, "success");
                            // refresh page after 2 seconds
                            setTimeout(function(){
                                window.location.reload();
                            },500);
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    }
                });

            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                Swal.fire(
                    'Cancelled',
                    'Your data is safe :)',
                    'error'
                )
            }
          })
    }
</script>

@endpush

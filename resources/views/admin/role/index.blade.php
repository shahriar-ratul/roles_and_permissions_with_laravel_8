@extends('admin.layouts.app')

@section('title')
Roles
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Roles Table</h3>
        <div class="card-tools">
            <a href="{{ route('roles.create') }} " class="btn btn-primary"><i class="fas fa-shield-alt"></i> Add new Role</a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Role</th>
                    <th>Permission</th>
                    <th>Date Posted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role )
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @foreach ($role->permissions as $permission )
                        <button class="btn btn-warning" role="button"><i class="fas fa-shield-alt"></i> {{ $permission->name }}</button>
                        @endforeach
                    </td>
                    <td><span class="tag tag-success">{{ $role->created_at }}</span></td>
                    <td>
                        <a href="{{ route('roles.edit', $role->id ) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>

                        <button class="btn btn-danger" data-value="{{$role->id}}" id='deleteItem' onclick="deleteConfirmation({{$role->id}})" >
                            <i class='far fa-trash-alt'></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td><i class="fas fa-folder-open"></i> No Record found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('js')
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> --}}

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
                    url: "{{url('/roles')}}/" + id,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                            swal.fire("Done!", results.message, "success");
                            // refresh page after 2 seconds
                            setTimeout(function(){
                                location.reload();
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

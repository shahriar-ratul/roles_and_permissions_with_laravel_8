@extends('admin.layouts.app')

@section('css')

<link href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" rel="stylesheet" />
<style>

</style>

@endsection
@section('title')
User
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Users</h3>

        <div class="card-tools">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i>
                Create new User</a>
        </div>
    </div>
    <!-- /.card-body -->
</div>

{{$dataTable->table()}}
{{-- <user></user> --}}

@endsection

@push('js')
    {{$dataTable->scripts()}}
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
@endpush

@extends('admin.layouts.app')

@section('pageName')
Update Role
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add new Role</h3>
        <div class="card-tools">
            <a href="{{ route('roles.index') }}" class="btn btn-danger"><i class="fas fa-shield-alt"></i> See all Roles</a>
        </div>
    </div>
    <div class="card-body">
        <edit-role :item="{{ $item }}" :item-permissions="{{ $item->permissions }}"></edit-role>
    </div>
</div>

@endsection

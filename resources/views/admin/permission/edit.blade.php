@extends('admin.layouts.app')


@section('title')
upsate Permission -
@endsection
@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Permission</h3>
        <div class="card-tools">
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-danger"><i class="fas fa-shield-alt"></i> See all Permission</a>
        </div>
    </div>
    <form method="POST" action="{{ route('admin.permissions.update',['permission'=>$item->id]) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="name">Display Name</label>
                <input type="text" name="display_name" id="display_name" class="form-control @error('display_name') is-invalid @enderror" value="{{  $item->display_name }}"  placeholder="Permission Display Name" >
                @error('display_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Group Name</label>
                <input type="text" name="group_name" id="group_name" class="form-control @error('group_name') is-invalid @enderror" value="{{ $item->group_name }}" required placeholder="Permission Group Name">
                @error('group_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $item->name }}" placeholder="Permission Name" readonly>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Permission</button>
        </div>
    </form>
</div>
@endsection

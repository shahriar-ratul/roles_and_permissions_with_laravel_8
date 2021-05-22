@extends('admin.layouts.app')


@section('title')
User
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ isset($item->id) ? "Update user" : "Add New User" }}</h3>
        <div class="card-tools">
            <a href="{{ route('admin.users.index') }}" class="btn btn-danger"><i class="fas fa-shield-alt"></i> See all User</a>
        </div>
    </div>
    <form method="POST" action="{{ isset($item->id) ? route('admin.users.update',['user'=>$item->id]) : route('admin.users.store')}}">
        @csrf
        @if ($item->id)
            @method('PUT')
        @endif

        <div class="card-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{  $item->name }}"  placeholder="Name" >
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Email</label>
                <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{  $item->email }}"  placeholder="Email" >
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Confirm Password</label>
                <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control" name="password_confirmation" required autocomplete="new-password">

            </div>

            <div class="form-group">
                <label>Roles</label>
                <select name="role[]" class="select2" multiple="multiple" data-placeholder="Select a Role"  style="width: 100%;">
                    @foreach ($roles as $role)
                        <option value="{{$role->name}}" @if(in_array($role->name,$item->getRoleNames()->toArray())) selected @endif>{{$role->display_name}}</option>
                    @endforeach

                </select>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Permission</button>
        </div>
    </form>
</div>
@endsection

@push('js')

    <script>

        // Shorthand for $( document ).ready()
        $(function() {
            $('.select2').select2({

                theme: 'bootstrap4',
            })
        });

    </script>
@endpush



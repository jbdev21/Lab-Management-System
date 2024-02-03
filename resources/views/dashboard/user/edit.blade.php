@extends('dashboard.includes.layouts.app')

@section('page-title', 'Edit User')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">User Manager</li>
        <li class="breadcrumb-item" aria-current="page">
            <a href="{{ route('dashboard.user.index') }}">Users</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Edit User</li>
    </ol>
</nav>
<div class="row gx-5 gy-3">
    <div class="col-lg-6">
        <div class="app-card shadow-sm mb-4 border-left-decoration">
            <div class="inner">
                <div class="app-card-body p-4">
                    <form action="{{ route('dashboard.user.update', $user->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label for="">Name</label>
                            <input type="text" class="form-control mb-2" name="name" value="{{ $user->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="email" class="form-control mb-2" name="email" value="{{ $user->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Address</label>
                            <input type="text" class="form-control mb-2" name="address" value="{{ $user->address }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Contact</label>
                            <input type="text" class="form-control mb-2" name="contact_number" value="{{ $user->contact_number }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Department</label>
                            <select name="department_id" required class="form-select">
                                @foreach($departments as $department)
                                    <option @selected($department->id == $user->department_id) value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Position</label>
                            <input type="text" class="form-control mb-2" name="position" value="{{ $user->position }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Username</label>
                            <input type="text" class="form-control mb-2" name="username" value="{{ $user->username }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Password</label>
                            <input type="password" class="form-control mb-2" name="password" >
                        </div>
                        <div class="mb-3">
                            <label for="">Roles</label>
                            <select name="role" class="form-control">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Update Changes</button>
                        <a  class="btn btn-secondary text-white mt-3" href="{{ route("dashboard.user.index") }}"><i class="fa fa-ban"></i> Cancel</a>
                    </form>
                </div><!--//col-->
            </div><!--//row-->
        </div><!--//app-card-body-->
    </div><!--//inner-->
</div><!--//app-card-->
@endsection
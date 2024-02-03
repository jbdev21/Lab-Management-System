@extends('dashboard.includes.layouts.app')

@section('page-title', 'Roles')

@section('content')
<button type="button" class="btn btn-primary text-white pull-right mb" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <i class="fa fa-plus"></i> Add Role
</button>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
      <li class="breadcrumb-item">User Manager</li>
      <li class="breadcrumb-item active" aria-current="page">Roles</li>
    </ol>
</nav>

<div class="app-card shadow-sm mb-4 mt-2">
    <div class="inner">
        <div class="app-card-body p-4">     
            @foreach($roles as $role)
                <div class="app-card app-card-settings p-4">
                    <div class="app-card-body">
                        <h3 class="section-title">{{ ucfirst($role->name) }}</h3>
                        <div class="row">
                            @foreach(config("system.roles_permissions") as $group => $permissions)
                                <div class="col-3 pb-2">
                                    <div class="card h-100">
                                        <div class="card-header">
                                            {{ ucfirst($group) }}
                                        </div>
                                        <div class="card-body">
                                            @foreach($permissions as $permission)
                                                <div class="form-check form-switch mb-3" style="font-size:14px">
                                                    <input class="form-check-input role-permission-switch" data-role="{{ $role->id }}" data-permission="{{ $permission }}" @if(in_array($permission, $role->permissions->pluck('name')->toArray())) checked @endif  value="{{ $permission }}" type="checkbox" id="{{ $role->id }}->{{ $permission }}">
                                                    <label class="form-check-label" for="{{ $role->id }}->{{ $permission }}">{{ ucfirst($permission) }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach            
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
            <form action="{{ route("dashboard.role.store") }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="quantityInput" class="form-label">Role</label>
                        <input required type="text" name="role" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary text-white">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('dashboard.includes.layouts.app')

@section('page-title', 'Acounts')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">User Manager</li>
            <li class="breadcrumb-item active" aria-current="page">Agents</li>
        </ol>
    </nav>
    <div class="app-card shadow-sm mb-4 border-left-decoration">
        <div class="inner">
            <div class="app-card-body p-4">
                <div class="row gx-5 gy-3">
                    @can("manage agents")
                        <div class="col-lg-4">
                            <h4 class="text-success mb-3">Agents</h4>
                            <div class="app-card mb-4">
                                <div class="app-card-body p-3">
                                    <form action="{{ route('dashboard.agent.store') }}" method="POST">
                                    @csrf
                                        <div class="mb-3">
                                            <label for="">Name</label>
                                            <input type="text" class="form-control mb-2" name="name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Email</label>
                                            <input type="email" class="form-control mb-2" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Address</label>
                                            <input type="text" class="form-control mb-2" name="address" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Contact</label>
                                            <input type="text" class="form-control mb-2" name="contact_number" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Position</label>
                                            <input type="text" class="form-control mb-2" name="position" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Username</label>
                                            <input type="text" class="form-control mb-2" name="username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Password</label>
                                            <input type="password" class="form-control mb-2" name="password" required>
                                        </div>
                                            
                                        <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Save</button>
                                    </form>
                                </div>
                            </div>
                        </div><!--//col-->
                    @endcan
                    <div class=" @can("manage agents") col-lg-8 @else col-lg-12 @endif">
                        <div class="row">
                            <div class="col-lg-8">
                                <form>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search for Username, Name, Position...." name="q">
                                        <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-4">
                                <form>
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="status">
                                            <option value="">All Status</option>
                                            <option value="1" @if(Request::get('status') == '1') selected @endif>Active</option>
                                            <option value="0" @if(Request::get('status') == '0') selected @endif>Non-Active</option>
                                        </select>
                                        <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="20px;"></th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Updated</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>@if($user->active) 
                                            <span class="text-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                                <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                                                <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                                                </svg>
                                            </span>
                                            @else 
                                                <span class="text-danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-slash-circle" viewBox="0 0 16 16">
                                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                        <path d="M11.354 4.646a.5.5 0 0 0-.708 0l-6 6a.5.5 0 0 0 .708.708l6-6a.5.5 0 0 0 0-.708z"/>
                                                    </svg>
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $user->username }}
                                        </td>
                                        <td>
                                            <img src="{{ $user->thumbnail }}" class="mw-100 rounded-circle mr-3" alt="{{ $user->name }}'s thumbnail" style="width:32px">
                                            {{ $user->name }}
                                        </td>
                                        <td>{{ $user->position }}</td>
                                        <td>
                                            <span title="{{ $user->updated_at->format('M d, Y - h:i A') }}">
                                                {{ $user->updated_at->diffForHumans() }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            {{-- @can("update accounts") --}}
                                                <a href="{{ route('dashboard.agent.edit', $user->id) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-pencil"></i></a>
                                            {{-- @endcan --}}
                                            {{-- @can("delete accounts") --}}
                                                <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $user->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                                <form id="delete-{{ $user->id }}" action="{{ route('dashboard.agent.destroy', $user->id) }}" method="POST">@csrf @method('DELETE')</form>
                                            {{-- @endcan --}}
                                        </td>
                                    </tr>
                                    
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No Records</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div style="margin-left: 20px;">
                            {{ $users->appends([
                                'q' => Request::get('q'),
                                'status' => Request::get('status'),
                                ])
                                ->links()
                            }}
                        </div>
                    </div><!--//col-->
                </div><!--//row-->
            </div><!--//app-card-body-->
        </div><!--//inner-->
    </div><!--//app-card-->
@endsection
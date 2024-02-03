@extends('dashboard.includes.layouts.app')

@section('page-title', 'Profile')

@section('content')

    <div class="app-card shadow-sm mb-4 border-left-decoration">
        <div class="inner">
            <div class="app-card-body p-4">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
              </nav>
                
                <div class="row gx-5 gy-3">
                     <div class="col-lg-5 col-md-5 col-sm-5 col-12">
                        <div class="app-card mb-4">
                            <div class="app-card-body p-4">
                                @if(session()->has('success'))
                                    <div class="alert alert-success">
                                        {{ session()->get('success') }}
                                    </div>
                                @endif
                                <form action="{{ route('dashboard.profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                    <div class="mb-4">
                                        <label for="">Profile</label>
                                        <div class="text-center">
                                            <label for="thumbnail" class="d-block mb-2">
                                                <img src="{{ $user->thumbnail }}"  alt="user profile" class="rounded-circle mw-100" alt="">
                                            </label>
                                        </div>
                                        <input type="file" class="d-none" name="thumbnail" id="thumbnail">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Name</label>
                                        <input type="text" class="form-control mb-2" name="name" value="{{ $user->name }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Password</label> <sub class=" text-danger"> ** If Password provide must be consider password update.</sub>
                                        <input type="password" class="form-control mb-2" name="password">
                                    </div>
                                        
                                    <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Update</button>
                                </form>
                            </div>
                        </div>
                    </div><!--//col-->
                        <div class="col-lg-7 col-sm-7">
                            <div class="app-card mb-4">
                                <div class="app-card-body p-4">
                                   <label> <h4>Account Detail</h4></label>
                                        <div class="mb-3">
                                            <label for="">Position</label>
                                            <input type="text" class="form-control mb-2" value="{{ $user->position }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Address</label>
                                            <input type="text" class="form-control mb-2" value="{{ $user->address }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Contact</label>
                                            <input type="text" class="form-control mb-2" value="{{ $user->contact_number }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Email</label>
                                            <input type="email" class="form-control mb-2" value="{{ $user->email }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Username</label>
                                            <input type="text" class="form-control mb-2" value="{{ $user->username }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" @if(cache()->get('dark-mode-' . Auth::user()->id, 0)) checked @endif type="checkbox" id="toogleDarkMode">
                                                <label class="form-check-label" for="toogleDarkMode">Dark Mode</label>
                                              </div>
                                        </div>
                                </div>
                            </div>
                        </div><!--//col-->
                       
                </div><!--//row-->
            </div><!--//app-card-body-->
        </div><!--//inner-->
    </div><!--//app-card-->
@endsection
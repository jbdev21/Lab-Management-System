@extends('dashboard.includes.layouts.app')

@section('page-title', 'Categories')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Setting</li>
        <li class="breadcrumb-item active" aria-current="page">Categories</li>
    </ol>
</nav>
<div class="row gx-5 gy-3">
   <div class="col-lg-6">
        <div class="app-card shadow-sm mb-4 border-left-decoration">
            <div class="inner">
                <div class="app-card-body p-4">
                    <div class="app-card">
                        <div class="app-card-body p-4">
                            <form action="{{ route('dashboard.category.update', $category->id) }}" method="POST">
                                    @csrf @method('PUT')
                                <div class="mb-3">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control mb-2" name="name" value="{{ $category->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="">Type</label>
                                    <select name="type" class="form-control">
                                        @foreach($types as $type)
                                            <option @if(Str::lower($category->type) == $type) selected @endif value="{{ $type }}">{{  $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Save Changes</button>
                                <a href="{{ route('dashboard.category.index') }}" class="btn btn-secondary text-white mt-3"><i class="fa fa-ban"></i> Cancel</a>
                            </form>
                        </div>
                    </div>
                </div><!--//col-->
            </div><!--//row-->
        </div><!--//app-card-body-->
    </div><!--//inner-->
</div><!--//app-card-->
@endsection

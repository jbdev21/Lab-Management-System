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
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-4">
            <div class="row gx-5 gy-3">
                @can('create categories')
                    <div class="col-lg-4">
                        <div class="app-card mb-4">
                            <div class="app-card-body">
                                <form action="{{ route('dashboard.category.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="">Name</label>
                                        <input type="text" class="form-control mb-2" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Type</label>
                                        <select name="type" class="form-control">
                                            @foreach($types as $type)
                                                <option @if(Request::get('type') == $type) selected  @endif value="{{ $type }}">{{  $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Save</button>
                                </form>
                            </div>
                        </div>
                    </div><!--//col-->
                @endcan

                <div class="@can("create categories") col-lg-8 @else col-lg-12 @endif">
                    <form>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search for name" value="{{ Request::get("q") }}" name="q">
                                    <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <select data-filtering-select="true" name="type" class="form-control">
                                    <option value="">All</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}" @if(Request::get("type") == $type) selected @endif>{{  $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ ucfirst($category->type) }}</td>
                                    
                                    <td class="text-end">
                                        @can('update categories')
                                            <a href="{{ route('dashboard.category.edit', $category->id) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-pencil"></i></a>
                                        @endcan
                                        @can('delete categories')
                                            <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $category->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                            <form id="delete-{{ $category->id }}" action="{{ route('dashboard.category.destroy', $category->id) }}" method="POST">@csrf @method('DELETE')</form>
                                        @endcan
                                    </td>
                                </tr>
                                
                            @empty
                                <tr>
                                    <td colspan="3">No Records</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div style="margin-left: 20px;">
                        {{ $categories->appends([
                            'q' => Request::get('q'),
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
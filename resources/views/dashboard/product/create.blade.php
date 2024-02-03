@extends('dashboard.includes.layouts.app')

@section('page-title', 'Dashboard')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Inventory</li>
        <li class="breadcrumb-item" aria-current="page">
            <a href="{{ route('dashboard.product.index') }}">Product</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Create Product</li>
    </ol>
</nav>
  <div class="row gx-5 gy-3">
        <div class="col-lg-6">
            <div class="app-card shadow-sm mb-4 border-left-decoration">
                <div class="inner">
                    <div class="app-card-body p-4">
                        <form action="{{ route('dashboard.product.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="brand_name">Brand Name</label>
                                <input type="text" class="form-control mb-2" name="brand_name" value="{{ old('brand_name') }}">
                            </div>
                            <div class="mb-3">
                                <label for="abbreviation">Abbreviation</label>
                                <input type="text" class="form-control mb-2" name="abbreviation" value="{{ old('abbreviation') }}">
                            </div>
                            <div class="mb-3">
                                <label for="description">Description</label>
                                <textarea class="form-control mb-2" name="description">{{ old('description') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="unit">Unit</label>
                                <input type="text" class="form-control mb-2" name="unit" value="{{ old('unit') }}">
                            </div>
                            <div class="mb-3">
                                <label for="type">Type</label>
                                <input type="text" class="form-control mb-2" name="type" value="{{ old('type') }}">
                            </div>
                            <div class="mb-3">
                                <label for="retail_price">SRP</label>
                                <input type="number" step="0.01" class="form-control mb-2" name="retail_price" value="{{ old('retail_price') }}">
                            </div>
                            <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Create Product</button>
                            <a class="btn btn-secondary text-white mt-3" href="{{ route("dashboard.product.index") }}"><i class="fa fa-ban"></i> Cancel</a>
                        </form>
                    </div><!--//col-->
                </div><!--//row-->                               
            </div><!--//app-card-body-->
        </div><!--//inner-->
    </div><!--//app-card-->
@endsection
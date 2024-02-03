@extends('dashboard.includes.layouts.app')

@section('page-title', 'Stock')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Inventory</li>
        <li class="breadcrumb-item" aria-current="page">
            <a href="{{ route('dashboard.stock.index') }}">Stock</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Create stock</li>
    </ol>
</nav>
  <div class="row gx-5 gy-3">
        <div class="col-lg-6">
            <div class="app-card shadow-sm mb-4 border-left-decoration">
                <div class="inner">
                    <div class="app-card-body p-4">
                        <form action="{{ route('dashboard.stock.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="product_id">Product</label>
                                <select name="product_id" class="form-select select2 mb-2">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">
                                            [ {{ $product->abbreviation }} ] {{ $product->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="batch_code">Batch Code</label>
                                <input type="text" name="batch_code" class="form-control" value="{{ old('batch_code') }}">
                            </div>                            
                            <div class="mb-3">
                                <label for="manufacture_date">Manufacture Date</label>
                                <input type="date" name="manufacture_date" class="form-control" value="{{ old('manufacture_date') }}">
                            </div>                            
                            <div class="mb-3">
                                <label for="expiration_date">Expiration</label>
                                <input type="date" name="expiration_date" class="form-control" value="{{ old('expiration_date') }}">
                            </div>
                            <div class="mb-3">
                                <label for="quantity">Quantity</label>
                                <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}">
                            </div>
                            <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Save</button>
                            <a class="btn btn-secondary text-white mt-3" href="{{ route("dashboard.stock.index") }}"><i class="fa fa-ban"></i> Cancel</a>
                        </form>
                    </div><!--//col-->
                </div><!--//row-->                               
            </div><!--//app-card-body-->
        </div><!--//inner-->
    </div><!--//app-card-->
@endsection

@include("dashboard.includes.libraries.select2")

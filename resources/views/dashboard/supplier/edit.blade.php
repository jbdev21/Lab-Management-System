@extends('dashboard.includes.layouts.app')

@section('page-title', 'Edit Supplier')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Booking</li>
        <li class="breadcrumb-item" aria-current="page">
            <a href="{{ route('dashboard.supplier.index') }}">supplier</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Edit supplier</li>
    </ol>
</nav>
<div class="row gx-5 gy-3">
    <div class="col-lg-6">
        <div class="app-card shadow-sm mb-4 border-left-decoration">
            <div class="inner">
                <div class="app-card-body p-4">
                    <form action="{{ route('dashboard.supplier.update', $supplier) }}" method="POST">
                        @csrf @method('PUT')
                        
                        <div class="mb-3">
                            <label for="">Name <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control mb-2" name="name" value="{{ $supplier->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Address <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control mb-2" name="address" value="{{ $supplier->address }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Terms <span class="text-danger">*</span></label>
                            <input required type="number" step="1" min="0" class="form-control mb-2" name="terms" value="{{ $supplier->terms }}">
                        </div>
                        <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Save Changes</button>
                        <a  class="btn btn-secondary text-white mt-3" href="{{ route("dashboard.supplier.index") }}"><i class="fa fa-ban"></i> Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
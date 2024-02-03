@extends('dashboard.includes.layouts.app')

@section('page-title', 'Raw Material')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Inventory</li>
        <li class="breadcrumb-item" aria-current="page">
            <a href="{{ route('dashboard.raw-material.index') }}">Raw Material</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Edit Raw Material</li>
    </ol>
</nav>
  <div class="row gx-5 gy-3">
        <div class="col-lg-6">
            <div class="app-card shadow-sm mb-4 border-left-decoration">
                <div class="inner">
                    <div class="app-card-body p-4">
                        <form action="{{ route('dashboard.raw-material.update', $rawMaterial->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="code">Code</label>
                                <input type="text" class="form-control mb-2" name="code" value="{{ $rawMaterial->code }}">
                            </div>
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control mb-2" name="name" value="{{ $rawMaterial->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="quantity">Quantity <small>**read only.</small></label>
                                <input type="number" step="0.01" class="form-control mb-2" name="quantity" value="{{ $rawMaterial->quantity }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="unit">Unit</label>
                                <input type="text" class="form-control mb-2" name="unit" value="{{ $rawMaterial->unit }}">
                            </div>
                            <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Update Changes</button>
                            <a class="btn btn-secondary text-white mt-3" href="{{ route("dashboard.raw-material.index") }}"><i class="fa fa-ban"></i> Cancel</a>
                        </form>
                    </div><!--//col-->
                </div><!--//row-->                
            </div><!--//app-card-body-->
        </div><!--//inner-->
    </div><!--//app-card-->
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endpush
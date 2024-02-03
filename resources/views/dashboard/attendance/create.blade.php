@extends('dashboard.includes.layouts.app')

@section('page-title', 'deduction')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">HR Management</li>
        <li class="breadcrumb-item active" aria-current="page">Deduction</li>
    </ol>
</nav>
<div class="row gx-5 gy-3">
   <div class="col-lg-6">
        <div class="app-card shadow-sm mb-4 border-left-decoration">
            <div class="inner">
                <div class="app-card-body p-4">
                    <div class="app-card">
                        <div class="app-card-body">
                            <form action="{{ route('dashboard.attendance.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                            
                                <div class="mb-3">
                                    <label for="file">Upload</label>
                                    <input type="file" class="form-control mb-2" name="file" id="file" accept=".csv, .xlsx, .xls" required>
                                </div>
                            
                                <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Save</button>
                            </form>        
                        </div>
                    </div>
                </div><!--//col-->
            </div><!--//row-->
        </div><!--//app-card-body-->
    </div><!--//inner-->
</div><!--//app-card-->
@endsection

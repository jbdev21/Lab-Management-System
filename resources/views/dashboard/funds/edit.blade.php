@extends('dashboard.includes.layouts.app')

@section('page-title', 'Funds')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Setting</li>
        <li class="breadcrumb-item active" aria-current="page">Funds</li>
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
                                <form action="{{ route('dashboard.fund.update', $fund) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="mb-3">
                                        <label for="">Type *</label>
                                        <select name="type" class="form-select">
                                            @foreach($types  as $type)
                                                <option value="{{ $type }}" @selected( $fund->type == $type )>{{ ucfirst($type) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Name *</label>
                                        <input type="text" class="form-control mb-2" name="name" value="{{ $fund->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Acccount Name *</label>
                                        <input type="text" class="form-control mb-2" name="account_name" value="{{ $fund->account_name }}"  required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Reference</label>
                                        <input type="text" class="form-control mb-2" name="reference"  value="{{ $fund->reference }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Initial Amount *</label>
                                        <input type="number" step=".01" min="0" class="form-control mb-2" name="amount"  value="{{ $fund->amount }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Other Details</label>
                                        <textarea type="text" class="form-control mb-2" name="details">{{ $fund->details }}</textarea>
                                    </div>
                                
                                    <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Save Changes</button>
                                    <a href="{{ route("dashboard.fund.index") }}" class="btn btn-warning text-white mt-3"><i class="fa fa-ban"></i> Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div><!--//col-->
                @endcan

            </div><!--//row-->
        </div><!--//app-card-body-->
    </div><!--//inner-->
</div><!--//app-card-->
@endsection
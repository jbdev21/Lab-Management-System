@extends('dashboard.includes.layouts.app')

@section('page-title', 'Deliver')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item" aria-current="page">Purchase Order</li>
      <li class="breadcrumb-item active" aria-current="page">Deliver</li>
    </ol>
  </nav>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h4 class="text-success mb-3">Item Delivers</h4>
            <form>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search.." name="q">
                            <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    {{-- <div class="col-lg-8 text-end">
                        <button type="button" class="btn btn-primary text-white pull-right mb"  data-bs-toggle="modal" data-bs-target="#modalWithSelect2">
                            <i class="fa fa-plus"></i> Add Sales Order
                        </button>
                    </div> --}}
                </div>
            </form>
            <div>
                {{ $delivers->appends([
                        'q' => Request::get('q')
                    ])
                    ->links()
                }}
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <td>Deliver Date</td>
                        <th>Reference</th>
                        <th>PO Number</th>
                        <th>Received By</th>
                        <th>Percentage</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($delivers as $deliver)
                        <tr>
                            <td>{{ $deliver->created_at->format("M d, Y h:iA") }}</td>
                            <td>
                                <a href="{{ route('dashboard.deliver.show', $deliver) }}">
                                    {{ $deliver->reference }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('dashboard.purchase-order.show', $deliver->purchaseOrder?->id) }}">
                                    {{ $deliver->purchaseOrder?->po_number }}
                                </a>
                            </td>
                            <td>{{ $deliver->user?->name }}</td>
                            <td>{{ $deliver->percentage.'%' }}</td>
                            <td>{{ ucFirst($deliver->status )}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Records</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{ $delivers->appends([
                    'q' => Request::get('q')
                    ])
                    ->links()
                }}
            </div>
        </div>
    </div>
</div>

@endsection

@include("dashboard.includes.libraries.select2")


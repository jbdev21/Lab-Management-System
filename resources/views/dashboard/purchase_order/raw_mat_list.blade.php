@extends('dashboard.includes.layouts.app')

@section('page-title', 'Purchase Order')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Purchase Orders</li>
        <li class="breadcrumb-item" aria-current="page">
            Raw Material
        </li>
    </ol>
</nav>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h4 class="text-success mb-3">Purchase Orders</h4>
            <form>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search.." name="q">
                            <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-8 text-end">
                        <button type="button" class="btn btn-primary text-white pull-right mb"  data-bs-toggle="modal" data-bs-target="#modalWithSelect2">
                            <i class="fa fa-plus"></i> Add Purchase Order
                        </button>
                    </div>
                </div>
            </form>
            <div>
                {{ $purchaseOrders->appends([
                        'q' => Request::get('q')
                    ])
                    ->links()
                }}
            </div>
            <div class="p-1">
                Legend: 
                <span class="bg-secondary rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;</span> Draft &nbsp;&nbsp;
                <span class="bg-warning rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;</span> Subject for Approval/Received &nbsp;&nbsp;
                <span class="bg-danger rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;</span> Partial Received
                <span class="bg-success rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;</span> Full Received
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <td></td>
                        <th>PO Number</th>
                        <th>PO Date</th>
                        <th>Supplier Name</th>
                        <th>Terms</th>
                        <th>Total Amount</th>
                        <th>Type</th>
                        <th>Last Update</th>
                        <th style="width:120px"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($purchaseOrders as $purchaseOrder)
                        <tr>
                            <td>
                                <span class="bg-{{ $purchaseOrder->status_color }} rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            </td>
                            <td>
                                <a href="{{ route("dashboard.purchase-order.show", $purchaseOrder) }}">
                                {{ $purchaseOrder->po_number }}
                                </a>
                            </td>
                            <td>{{ $purchaseOrder->effectivity_date->format("Y-m-d") }}</td>
                            <td>    
                                <a href="{{ route("dashboard.supplier.show", $purchaseOrder->supplier) }}">
                                    {{ $purchaseOrder->supplier?->name }}
                                </a>
                            </td>
                            <td>{{ $purchaseOrder->term }}</td>
                            <td>{{ toPeso($purchaseOrder->total ?? "-") }}</td>
                            <td>{{ ucfirst($purchaseOrder->type) }}</td>
                            <td>
                                <span title="{{ $purchaseOrder->updated_at->format('M d, Y - h:i A') }}">
                                    {{ $purchaseOrder->updated_at->diffForHumans() }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('dashboard.purchase-order.show', $purchaseOrder) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-eye"></i></a>
                            
                                <a href="{{ route('dashboard.purchase-order.edit', $purchaseOrder) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-pencil"></i></a>
                            
                                <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $purchaseOrder->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                <form id="delete-{{ $purchaseOrder->id }}" action="{{ route('dashboard.customer.destroy', $purchaseOrder->id) }}" method="POST">@csrf @method('DELETE')</form>
                            
                            </td>
                        </tr>
                        
                    @empty
                        <tr>
                            <td colspan="13" class="text-center">No Records</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{ $purchaseOrders->appends([
                    'q' => Request::get('q')
                    ])
                    ->links()
                }}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalWithSelect2" tabindex="-1" aria-labelledby="modalWithSelect2Label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
            <form action="{{ route("dashboard.purchase-order.store") }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="{{ $rawMaterialType }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalWithSelect2Label">Purchase Order Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label">Supplier <span class="text-danger">*</span></label>
                        <select name="supplier_id" class="form-select select2-modal" required data-uri="/api/supplier/select2"></select>
                    </div>
                    <div class="mb-3">
                        <label for="effectivity_date" class="form-label">Effectivity Date <span class="text-danger">*</span></label>
                        <input type="date" value="{{ date("Y-m-d") }}" name="effectivity_date" required class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary text-white">
                        <i class="fa fa-arrow-right"></i>
                        Procceed</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@include("dashboard.includes.libraries.select2")


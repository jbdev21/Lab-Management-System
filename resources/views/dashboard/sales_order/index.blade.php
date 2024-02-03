@extends('dashboard.includes.layouts.app')

@section('page-title', 'Sales Order')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item" aria-current="page">Sales</li>
      <li class="breadcrumb-item active" aria-current="page">Sales Order</li>
    </ol>
  </nav>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h4 class="text-success mb-3">Sales Order</h4>
            <form>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search.." name="q">
                            <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <select name="status" class="form-select select-change-submit">
                            <option value=""> All Status</option>
                            @foreach($statusTypes as $statusType)
                                <option @if(Request::get("status") == $statusType) selected @endif value="{{ $statusType }}">
                                    {{ Str::title(str_replace("_", " ", $statusType->name)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 text-end">
                        <button type="button" class="btn btn-primary text-white pull-right mb"  data-bs-toggle="modal" data-bs-target="#modalWithSelect2">
                            <i class="fa fa-plus"></i> Add Sales Order
                        </button>
                    </div>
                </div>
            </form>
            <div>
                {{ $salesOrders->appends([
                        'q' => Request::get('q')
                    ])
                    ->links()
                }}
            </div>
            <div class="p-1 mb-2">
                Legend: 
                <span class="bg-secondary rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Draft &nbsp;&nbsp;&nbsp;&nbsp;
                <span class="bg-warning rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Subject for Approval &nbsp;&nbsp;&nbsp;&nbsp;
                <span class="bg-danger rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Partial Released &nbsp;&nbsp;&nbsp;&nbsp;
                <span class="bg-primary rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Full Released
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <td></td>
                        <th>SO Number</th>
                        <th>SO Date</th>
                        <th>Name</th>
                        <th>Terms</th>
                        <th>Total Amount</th>
                        <th>Discount</th>
                        <th>Freight</th>
                        <th>Net</th>
                        <th>Type</th>
                        <th>ASM</th>
                        <th>Last Update</th>
                        <th style="width:120px"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($salesOrders as $salesOrder)
                        <tr>
                            <td>
                                <span class="bg-{{ $salesOrder->status_color }} rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            </td>
                            <td>
                                <a href="{{ route("dashboard.sales-order.show", $salesOrder) }}">
                                {{ $salesOrder->so_number }}
                                </a>
                            </td>
                            <td>{{ $salesOrder->effectivity_date->format("Y-m-d") }}</td>
                            <td>    
                                <a href="{{ route("dashboard.customer.show", $salesOrder->customer) }}">
                                    {{ $salesOrder->customer->business_name }}
                                </a>
                            </td>
                            <td>{{ $salesOrder->term }}</td>
                            <td>{{ $salesOrder->amount ?? "-" }}</td>
                            <td>{{ $salesOrder->discount ?? "-" }}</td>
                            <td>{{ $salesOrder->freight ?? "-" }}</td>
                            <td>{{ $salesOrder->net ?? "-" }}</td>
                            <td>{{ ucfirst($salesOrder->type) }}</td>
                            <td>{{ $salesOrder->agent?->name }}</td>
                            <td>
                                <span title="{{ $salesOrder->updated_at->format('M d, Y - h:i A') }}">
                                    {{ $salesOrder->updated_at->diffForHumans() }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('dashboard.sales-order.show', $salesOrder) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-eye"></i></a>
                            
                                {{-- <a href="{{ route('dashboard.sales-order.edit', $salesOrder) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-pencil"></i></a> --}}
                            
                                <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $salesOrder->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                <form id="delete-{{ $salesOrder->id }}" action="{{ route('dashboard.customer.destroy', $salesOrder->id) }}" method="POST">@csrf @method('DELETE')</form>
                            
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
                {{ $salesOrders->appends([
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
            <form action="{{ route("dashboard.sales-order.store") }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalWithSelect2Label">Sales Order Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="quantityInput" class="form-label">Customer <span class="text-danger">*</span></label>
                        <select name="customer_id" class="form-select select2-modal" required data-uri="/api/customer/select2"></select>
                    </div>
                    <div class="mb-3">
                        <label for="quantityInput" class="form-label">Effectivity Date <span class="text-danger">*</span></label>
                        <input type="date" value="{{ date("Y-m-d") }}" name="effectivity_date" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="quantityInput" class="form-label">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-control">
                            @foreach($types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
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


@extends('dashboard.includes.layouts.app')

@section('page-title', 'Price Request')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item" aria-current="page">Booking</li>
      <li class="breadcrumb-item active" aria-current="page">Price Request</li>
    </ol>
  </nav>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h4 class="text-success mb-3">Price Request</h4>
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
                            <i class="fa fa-plus"></i> Add Price Request
                        </button>
                    </div>
                </div>
            </form>
            <div>
                {{ $priceRequests->appends([
                        'q' => Request::get('q')
                    ])
                    ->links()
                }}
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>PR Number</th>
                        <th>Customer</th>
                        <th>Created By</th>
                        <th>Number of Products</th>
                        <th>Updated</th>
                        <th style="width:120px"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($priceRequests as $priceRequest)
                        <tr>
                            <td>{{ $priceRequest->status }}</td>
                            <td>
                                <a href="{{ route('dashboard.price-request.show', $priceRequest) }}" >
                                    {{ $priceRequest->pr_number }}
                                </a>
                            </td>
                            <td>{{ $priceRequest->customer?->business_name }}</td>
                            <td>{{ $priceRequest->user?->name }}</td>
                            <td>{{ $priceRequest->products_count }}</td>
                            <td>{{ $priceRequest->updated_at->format("Y-m-d h:i A") }}</td>
                            <td class="text-end">
                                <a href="{{ route('dashboard.price-request.show', $priceRequest) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-eye"></i> View</a>
                            
                                {{-- <a href="{{ route('dashboard.delivery-receipt.edit', $priceRequests) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-pencil"></i></a>
                            
                                <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $deliveryReceipt->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                <form id="delete-{{ $deliveryReceipt->id }}" action="{{ route('dashboard.delivery-receipt.destroy', $deliveryReceipt->id) }}" method="POST">@csrf @method('DELETE')</form> --}}
                            
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Records</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{ $priceRequests->appends([
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
            <form action="{{ route("dashboard.price-request.store") }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalWithSelect2Label">Price Request Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="quantityInput" class="form-label">Customer <span class="text-danger">*</span></label>
                        <select name="customer_id" class="form-select select2-modal" required data-uri="/api/customer/select2"></select>
                    </div>
                    <div class="mb-3">
                        <label for="quantityInput" class="form-label">Note <span class="text-danger">*</span></label>
                        <textarea name="note" rows="5" class="form-control"></textarea>
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


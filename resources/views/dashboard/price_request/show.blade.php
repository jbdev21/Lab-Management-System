@extends('dashboard.includes.layouts.app')

@section('page-title', 'Sales Order')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Booking</li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('dashboard.price-request.index') }}">Price Request</a></li>
        <li class="breadcrumb-item active" aria-current="page">PR #{{ $priceRequest->pr_number }}</li>
    </ol>
</nav>
<div class="app-card shadow-sm mb-2 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h3>PR#{{ $priceRequest->pr_number }}</h3>
            <div class="row">
                <div class="col-sm-4">
                    <table>
                        <tr>
                            <td>Customer</td>
                            <td class="fw-bold">: {{ $priceRequest->customer?->business_name }}</td>
                        </tr>
                        <tr>
                            <td>Contact Number</td>
                            <td class="fw-bold">: {{ $priceRequest->customer?->contact_number }}</td>
                        </tr>
                        <tr>
                            <td>Classification</td>
                            <td class="fw-bold">: {{ $priceRequest->customer?->category?->name }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td class="fw-bold">: {{ $priceRequest->customer?->address }}</td>
                        </tr>
                        <tr>
                            <td>Agent</td>
                            <td class="fw-bold">: {{ $priceRequest->customer?->agent?->name }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-8">
                    @if($priceRequest->status == "draft")
                        @if($priceRequest->products_count > 0)
                            <div class="text-end">
                                <form action="{{ route("dashboard.price-request.update.status", $priceRequest) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="subject-for-approval">
                                    <button type="submit" class="btn btn-lg btn-success"><i class="fa fa-check"></i> Submit for Approval</button>
                                </form>
                            </div>    
                        @endif
                    @else
                        <div class="mb-2">
                            <h6>Approvals</h6>
                        </div>
                        <table class="table mt-1 mb-4">
                            <tr>
                                <td>Name</td>
                                <td>Department</td>
                                <td>Date/Time</td>
                                <td>Note</td>
                                <td></td>
                            </tr>
                            @forelse($priceRequest->approvals as $approval)
                                <tr>
                                    <td>{{ $approval->user?->name }}</td>
                                    <td>-</td>
                                    <td>{{ $approval->created_at->format("Y-m-d h:iA") }}</td>
                                    <td>{{ $approval->note }}</td>
                                    <td class="text-end">
                                        @can("manage approval")
                                            <a href="#" class="btn-sm btn-danger py-0 btn text-white px-2 delete-button" >Revoke</a>
                                            <form action="{{ route("dashboard.approval.destroy", $approval->id) }}">@csrf @method('DELETE')</form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center"> No approval</td>
                                </tr>
                            @endforelse
                        </table>
                    <div class="text-end">
                        @can("manage approval")
                            @if(!in_array(Auth::user()->id, $priceRequest->approvals()->pluck('user_id')->toArray()))
                                <button type="button" class="btn-success btn" data-bs-toggle="modal" data-bs-target="#approvalFormModal">
                                    <i class="fa fa-check"></i> Approve
                                </button>
                            @endif
                        @endcan
                        <button type="button" class="btn-success btn @if(!$priceRequest->approvals_count) disabled @endif">
                            <i class="fa fa-check"></i> Generate Sale Order
                        </button>
                    </div>
                    @endif    
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <div class="row"> 
                @if($priceRequest->status == "draft")
                    <div class="col-sm-4">
                        <form action="{{ route("dashboard.price-request.add.product", $priceRequest) }}" method="POST">
                            @csrf
                            <input type="hidden" name="sales_order_id" value="{{ $priceRequest->id }}">
                            <price-request-products-input customerid="{{ $priceRequest->customer_id }}"></price-request-products-input>
                        </form>
                    </div>
                @endif
                <div class="@if($priceRequest->status == "draft") col-sm-8 @else col-sm-12 @endif">
                    <table class="table">
                        <thead>
                            <th>Abbrev</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th class='text-end'>Unit Price</th>
                            <th class='text-end'>Discount</th>
                            <th class='text-end'>SubTotal</th>
                            @if($priceRequest->status == "draft")
                            <th></th>
                            @endif
                        </thead>
                        <tbody>
                            @forelse($priceRequest->products as $product)
                                <tr>
                                    <td>{{ $product->abbreviation }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->unit }}</td>
                                    <td>{{ $product->type }}</td>
                                    <td>{{ $product->pivot->quantity }}</td>
                                    <td class='text-end'>{{ toPeso($product->pivot->unit_price) }}</td>
                                    <td class="text-end">{{ toPeso($product->pivot->discount) }}</td>
                                    <td class="text-end">{{ toPeso($product->pivot->amount) }}</td>
                                    @if($priceRequest->status == "draft")
                                        <td class="text-end">
                                            <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $product->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                            <form id="delete-{{ $product->id }}" action="{{ route('dashboard.sales-order.remove.product') }}" method="POST">
                                                @csrf @method('DELETE')
                                                <input type="hidden" name="sales_order_id" value="{{ $priceRequest->id }}"> 
                                                <input type="hidden" name="product_id" value="{{ $product->id }}"> 
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No items</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="approvalFormModal" tabindex="-1" role="dialog" aria-labelledby="approvalFormModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-start">
            <form action="{{ route("dashboard.approval.store") }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Approval Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $priceRequest->id }}">
                    <input type="hidden" name="model" value="{{ PriceRequest::class }}">
                    <div class="mb-3">
                        <label>Price Request Number</label>
                        <input type="text" readonly class="form-control" value="{{ $priceRequest->pr_number }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Note</label>
                        <textarea name="note" style="height: 80px" class="form-control" placeholder="optional.."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success text-white">Approve Sale Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@extends('dashboard.includes.layouts.app')

@section('page-title', 'Sales Order')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Sales</li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('dashboard.sales-order.index') }}">Sales Order</a></li>
        <li class="breadcrumb-item active" aria-current="page">SO #{{ $salesOrder->so_number }}</li>
    </ol>
</nav>
<div class="app-card shadow-sm mb-2 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h3>SO #: {{ $salesOrder->so_number }}</h3>
            <div class="row">
                <div class="col-sm-4">
                    <table>
                        <tr>
                            <td>Customer</td>
                            <td class="fw-bold">: {{ $salesOrder->customer?->business_name }}</td>
                        </tr>
                        <tr>
                            <td>Contact Number</td>
                            <td class="fw-bold">: {{ $salesOrder->customer?->contact_number }}</td>
                        </tr>
                        <tr>
                            <td>Classification</td>
                            <td class="fw-bold">: {{ $salesOrder->customer?->category?->name }}</td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td class="fw-bold">: {{ $salesOrder->type }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td class="fw-bold">: {{ $salesOrder->customer?->address }}</td>
                        </tr>
                        <tr>
                            <td>Terms</td>
                            <td class="fw-bold">: {{ $salesOrder->term }}</td>
                        </tr>
                        <tr>
                            <td>SO Date</td>
                            <td class="fw-bold">: {{ $salesOrder->effectivity_date->format("Y-m-d") }}</td>
                        </tr>
                        <tr>
                            <td>Due Date</td>
                            <td class="fw-bold">: {{ $salesOrder->due_date->format("Y-m-d") }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-8">
                    @if($salesOrder->status == "draft")
                        @if($salesOrder->products_count > 0)
                            <div class="text-end">
                                <form class="overlayed-form" action="{{ route("dashboard.sales-order.update.status", $salesOrder) }}" method="POST">
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
                            @forelse($salesOrder->approvals as $approval)
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
                            @if(!in_array(Auth::user()->id, $salesOrder->approvals()->pluck('user_id')->toArray()))
                                <button type="button" class="btn-success btn" data-bs-toggle="modal" data-bs-target="#approvalFormModal">
                                    <i class="fa fa-check"></i> Approve
                                </button>
                            @endif
                        @endcan
                        {{-- @if(!$salesOrder->status == "released") --}}
                            <button type="button" class="btn-success btn @if(!$salesOrder->approvals_count || $salesOrder->status == "full-released") disabled @endif" data-bs-toggle="modal" data-bs-target="#releaseDeliveryRecieptModal">
                                <i class="fa fa-arrow-up"></i> Release
                            </button>
                        {{-- @endif --}}
                        @if($salesOrder->delivery_receipts_count)
                            <div class="text-start">
                                <h6>Delivery Receipt</h6>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>%</th>
                                            <th>DR #</th>
                                            <th>Released By</th>
                                            <th>Released At</th>
                                            <th>Note</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($salesOrder->deliveryReceipts as $deliveryReceipt)
                                            <tr>
                                                <td>{{ $deliveryReceipt->percentage }}%</td>
                                                <td>{{ $deliveryReceipt->dr_number }}</td>
                                                <td>{{ $deliveryReceipt->user?->name }}</td>
                                                <td>{{ $deliveryReceipt->created_at->format("Y-m-d H:iA") }}</td>
                                                <td>{{ $deliveryReceipt->note ?? '-' }}</td>
                                                <td class="text-end">
                                                    <a href="#" class="btn-sm btn-primary py-0 btn text-white px-2"><i class="fa fa-print"></i> Print</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
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
                @if($salesOrder->status == "draft")
                    <div class="col-sm-4">
                        <form class="overlayed-form" action="{{ route("dashboard.sales-order.add.product") }}" method="POST">
                            @csrf
                            <input type="hidden" name="sales_order_id" value="{{ $salesOrder->id }}">
                            <sales-order-products-input customerid="{{ $salesOrder->customer_id }}" soid="{{ $salesOrder->id }}"></sales-order-products-input>
                        </form>
                    </div>
                @endif
                <div class="@if($salesOrder->status == "draft") col-sm-8 @else col-sm-12 @endif">
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
                            @if($salesOrder->status == "draft")
                            <th></th>
                            @endif
                        </thead>
                        <tbody>
                            @forelse($salesOrder->products as $product)
                                <tr>
                                    <td>{{ $product->abbreviation }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->unit }}</td>
                                    <td>{{ $product->type }}</td>
                                    <td>{{ $product->pivot->quantity }}</td>
                                    <td class='text-end'>{{ toPeso($product->pivot->unit_price) }}</td>
                                    <td class="text-end">{{ toPeso($product->pivot->discount) }}</td>
                                    <td class="text-end">{{ toPeso($product->pivot->amount) }}</td>
                                    @if($salesOrder->status == "draft")
                                        <td class="text-end">
                                            <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $product->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                            <form id="delete-{{ $product->id }}" action="{{ route('dashboard.sales-order.remove.product') }}" method="POST">
                                                @csrf @method('DELETE')
                                                <input type="hidden" name="sales_order_id" value="{{ $salesOrder->id }}"> 
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
                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-end fw-bold"></td>
                                <td class="text-end fw-bold">{{ toPeso($salesOrder->discount) }}</td>
                                <td class="text-end fw-bold">{{ toPeso($salesOrder->amount) }}</td>
                                @if($salesOrder->status == "draft")
                                <td></td>
                                @endif
                            </tr>
                            <tr>
                                <td colspan="7" class=" fw-bold">Net</td>
                                <td class="text-end fw-bold">{{ toPeso($salesOrder->net) }}</td>
                                @if($salesOrder->status == "draft")
                                <td></td>
                                @endif
                            </tr>
                        </tfoot>
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
                    <input type="hidden" name="id" value="{{ $salesOrder->id }}">
                    <input type="hidden" name="model" value="{{ SalesOrder::class }}">
                    <div class="mb-3">
                        <label>Sales Order Number</label>
                        <input type="text" readonly class="form-control" value="{{ $salesOrder->so_number }}" required>
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


<div class="modal fade" id="releaseDeliveryRecieptModal" tabindex="-1" role="dialog" aria-labelledby="releaseDeliveryRecieptModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content text-start">
            <form action="{{ route("dashboard.delivery-receipt.store") }}" method="POST">
                @csrf
                <input type="hidden" name="sales_order_id" value="{{ $salesOrder->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delivery Receipt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="mb-3">
                                <label>Delivery Receipt Number <span class="text-danger">*</span></label>
                                <input type="text" name="dr_number" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="mb-3">
                                <label>Note</label>
                                <input name="note" class="form-control" placeholder="optional..">
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Abbrev</th>
                                <th>Description</th>
                                <th>Quanitity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($salesOrder->products as $product)
                                <tr>
                                    <td style="width:30px">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="products[]" value="{{ $product->id }}"
                                            @if(($product->pivot->quantity - $product->pivot->released_quantity) < 1)
                                                disabled
                                            @else
                                                checked
                                            @endif
                                            type="checkbox" id="dr-product-check-{{ $product->id }}">
                                            <label class="form-check-label" for="dr-product-check-{{ $product->id }}"></label>
                                        </div>
                                    </td>
                                    <td>{{ $product->abbreviation }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>
                                        @if(($product->pivot->quantity - $product->pivot->released_quantity) < 1)
                                            <i class="text-success">Released</i>
                                        @else
                                            <input type="number" style="width:75px" name="product-{{ $product->id }}" value="{{ $product->pivot->quantity - $product->pivot->released_quantity }}" min="1" max="{{ $product->pivot->quantity - $product->pivot->released_quantity }}">
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success text-white">Create Delivery Receipt</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@extends('dashboard.includes.layouts.app')

@section('page-title', 'Purchase Order')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('dashboard.purchase-order.index') }}">Purchase Order</a></li>
        <li class="breadcrumb-item active" aria-current="page">PO #{{ $purchaseOrder->po_number }}</li>
    </ol>
</nav>
<div class="app-card shadow-sm mb-2 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h3>{{ $purchaseOrder->po_number }}</h3>
            <div class="row">
                <div class="col-sm-4">
                    <table>
                        <tr>
                            <td>Supplier</td>
                            <td class="fw-bold">: {{ $purchaseOrder->supplier?->name }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td class="fw-bold">: {{ $purchaseOrder->supplier?->address }}</td>
                        </tr>
                        <tr>
                            <td>Terms</td>
                            <td class="fw-bold">: {{ $purchaseOrder->term }}</td>
                        </tr>
                        <tr>
                            <td>PO Date</td>
                            <td class="fw-bold">: {{ $purchaseOrder->effectivity_date->format("Y-m-d") }}</td>
                        </tr>
                        <tr>
                            <td>Due Date</td>
                            <td class="fw-bold">: {{ $purchaseOrder->due_date->format("Y-m-d") }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-8">
                    @if($purchaseOrder->status == "draft")
                        @if($purchaseOrder->purchase_order_items_count > 0)
                            <div class="text-end">
                                <form action="{{ route("dashboard.purchase-order.update.status", $purchaseOrder) }}" method="POST">
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
                            @forelse($purchaseOrder->approvals as $approval)
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
                            @if(!in_array(Auth::user()->id, $purchaseOrder->approvals()->pluck('user_id')->toArray()))
                                <button type="button" class="btn-success btn" data-bs-toggle="modal" data-bs-target="#approvalFormModal">
                                    <i class="fa fa-check"></i> Approve
                                </button>
                            @endif
                        @endcan
                        {{-- @if(!$purchaseOrder->status == "Received") --}}
                            <button type="button" class="btn-success btn @if(!$purchaseOrder->approvals_count || $purchaseOrder->status == "full-Received") disabled @endif" data-bs-toggle="modal" data-bs-target="#ReceivedeliveryRecieptModal">
                                <i class="fa fa-arrow-up"></i> Receive Items
                            </button>
                        {{-- @endif --}}
                        @if($purchaseOrder->delivery_receipts_count)
                            <div class="text-start">
                                <h6>Deliver Received Reference</h6>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>%</th>
                                            <th>DR #</th>
                                            <th>Received By</th>
                                            <th>Received At</th>
                                            <th>Note</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchaseOrder->deliveryReceipts as $deliveryReceipt)
                                            <tr>
                                                <td>{{ $deliveryReceipt->percentage }}%</td>
                                                <td>{{ $deliveryReceipt->reference }}</td>
                                                <td>{{ $deliveryReceipt->user?->name }}</td>
                                                <td>{{ $deliveryReceipt->created_at->format("Y-m-d H:iA") }}</td>
                                                <td>{{ $deliveryReceipt->note ?? '-' }}</td>
                                                <td class="text-end">
                                                    <a href="{{ route('dashboard.deliver.show', $deliveryReceipt->id) }}" class="btn-sm btn-primary py-0 btn text-white px-2"><i class="fa fa-print"></i> Print</a>
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
                @if($purchaseOrder->status == "draft")
                    @if($purchaseOrder->type == "Raw Material")
                        <div class="col-sm-4">
                            <form action="{{ route("dashboard.purchase.order.add.item") }}" method="POST">
                                @csrf
                                <input type="hidden" name="purchase_order_id" value="{{ $purchaseOrder->id }}">
                                <purchase-order-raw-material-input></purchase-order-raw-material-input>
                            </form>
                        </div>
                    @elseif($purchaseOrder->type == "Others")
                        <div class="col-sm-4">
                            <form action="{{ route("dashboard.purchase.order.add.item") }}" method="POST">
                                @csrf
                                <input type="hidden" name="purchase_order_id" value="{{ $purchaseOrder->id }}">
                                <purchase-order-general-input></purchase-order-general-input>
                            </form>
                        </div>
                    @endif
                @endif
                <div class="@if($purchaseOrder->status == "draft") col-sm-8 @else col-sm-12 @endif">
                    <table class="table">
                        <thead>
                            @if($purchaseOrder->type == "Raw Material")
                                <th>Code</th>
                                <th>Name</th>
                                <th>Unit</th>
                            @elseif($purchaseOrder->type == "Others")
                                <th>Particular</th>
                            @endif
                            <th>Quantity</th>
                            <th class='text-end'>Unit Price</th>
                            <th class='text-end'>SubTotal</th>
                            @if($purchaseOrder->status == "draft")
                            <th></th>
                            @endif
                        </thead>
                        <tbody>
                            @forelse($purchaseOrder->purchaseOrderItems as $item)
                                <tr>
                                    @if($purchaseOrder->type == "Raw Material")
                                        <td>{{ $item->purchasable?->code }}</td>
                                        <td>{{ $item->purchasable?->name }}</td>
                                        <td>{{ $item->purchasable?->unit }}</td>
                                    @elseif($purchaseOrder->type == "Others")
                                        <td>{{ $item->particular }}</td>
                                    @endif
                                    <td>{{ $item->quantity }}</td>
                                    <td class='text-end'>{{ toPeso($item->unit_price) }}</td>
                                    <td class="text-end">{{ toPeso($item->subtotal) }}</td>
                                    @if($purchaseOrder->status == "draft")
                                        <td class="text-end">
                                            <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $item->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                            <form id="delete-{{ $item->id }}" action="{{ route('dashboard.purchase-order.remove-item', ['purchase_order' => $purchaseOrder->id, 'item' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="purchase_order_id" value="{{ $purchaseOrder->id }}">
                                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $purchaseOrder->type == 'Raw Material' ? 6 : 5 }}" class="text-center">No items</td>
                                </tr>                            
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="{{ $purchaseOrder->type == 'Raw Material' ? 5 : 3 }}" class=" fw-bold">Total</td>
                                <td class="text-end fw-bold">{{ toPeso($purchaseOrder->total) }}</td>
                                @if($purchaseOrder->status == "draft")
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
                    <input type="hidden" name="id" value="{{ $purchaseOrder->id }}">
                    <input type="hidden" name="model" value="{{ purchaseOrder::class }}">
                    <div class="mb-3">
                        <label>Purchase Order Number</label>
                        <input type="text" readonly class="form-control" value="{{ $purchaseOrder->po_number }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Note</label>
                        <textarea name="note" style="height: 80px" class="form-control" placeholder="optional..">{{ $purchaseOrder->note }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success text-white">Approve Purchase Order</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="ReceivedeliveryRecieptModal" tabindex="-1" role="dialog" aria-labelledby="ReceivedeliveryRecieptModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content text-start">
            <form action="{{ route("dashboard.deliver.store") }}" method="POST">
                @csrf
                <input type="hidden" name="purchase_order_id" value="{{ $purchaseOrder->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delivery Receive Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="mb-3">
                                <label>Delivery Reference No. <span class="text-danger">*</span></label>
                                <input type="text" name="reference" class="form-control" required>
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
                                @if($purchaseOrder->type == "Raw Material")
                                    <th>Item Code</th>
                                    <th>Name</th>
                                @elseif($purchaseOrder->type == "Others")
                                    <th>Particular</th>
                                @endif
                                <th>Unit Price</th>
                                <th>Quanitity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchaseOrder->purchaseOrderItems as $item)
                                <tr>
                                    <td style="width:30px">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="items[]" value="{{ $item->id }}"
                                                    @if(($item->quantity - $item->received_quantity) < 1)
                                                        disabled
                                                    @else
                                                        checked
                                                    @endif
                                                     type="checkbox"
                                                      id="dr-item-check-{{ $item->id }}">
                                            <label class="form-check-label" for="dr-item-check-{{ $item->id }}"></label>
                                        </div>
                                    </td>
                                    @if($purchaseOrder->type == "Raw Material")
                                        <td>{{ $item->id }} {{ $item->purchasable?->code }}</td>
                                        <td>
                                            {{ $item->purchasable?->name }}
                                        </td>
                                    @elseif($purchaseOrder->type == "Others")
                                        <td>
                                            {{ $item->particular }}
                                        </td>
                                    @endif
                                    <td>
                                        @if(($item->quantity - $item->received_quantity) < 1)
                                            <i class="text-success">Received</i>
                                        @else
                                            <input type="number" class="form-control" name="price-{{ $item->id }}"  
                                                    value="{{ $item->unit_price }}" 
                                                    min="0" 
                                                    max="{{ $item->unit_price }}">
                                        @endif
                                    </td>
                                    <td>
                                        @if(($item->quantity - $item->received_quantity) < 1)
                                            <i class="text-success">Received</i>
                                        @else
                                            <input type="number" class="form-control" style="width:75px" name="quantity-{{ $item->id }}"  
                                                    value="{{ $item->quantity - $item->received_quantity }}" 
                                                    min="0" 
                                                    max="{{ $item->quantity - $item->received_quantity }}">
                                        @endif
                                    </td>
                                    <td>
                                        @if(($item->quantity - $item->received_quantity) < 1)
                                            <i class="text-success">Received</i>
                                        @else
                                            <input type="number" class="form-control" step="0.01" name="amount-{{ $item->id }}"  value="{{ $item->unit_price * ($item->quantity - $item->received_quantity) }}" min="0">
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <small class="text-danger">**Select the fund from which to deduct the payment amount**</small>
                    <div class="form-group mb-3 col-sm-4">
                        <label>Funds</label>             
                        <select class="form-select" name="fund_id" required>
                            <option value=""> - not applicable - </option>
                            @foreach($funds as $fund)
                                <option value="{{ $fund->id }}">{{ $fund->name }}</option>
                            @endforeach
                        </select>
                    </div>
                           
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    
                    <button type="submit" class="btn btn-success text-white" 
                            @if($purchaseOrder->status == 'full-received')
                                disabled 
                            @endif
                        >Create Delivery Receipt</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $('input[name^="quantity-"], input[name^="price-"]').on('input', function () {
            var quantity = parseFloat($('input[name="quantity-' + $(this).attr('name').split('-')[1] + '"]').val()) || 0;
            var price = parseFloat($('input[name="price-' + $(this).attr('name').split('-')[1] + '"]').val()) || 0;
            var amount = quantity * price;
            
            // Update the corresponding amount input field
            $('input[name="amount-' + $(this).attr('name').split('-')[1] + '"]').val(amount.toFixed(2));
        });
    });
</script>
@endpush


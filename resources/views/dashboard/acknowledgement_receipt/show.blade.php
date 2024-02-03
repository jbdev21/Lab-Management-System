@extends('dashboard.includes.layouts.app')

@section('page-title', 'Acknowledgement Receipt')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('dashboard.acknowledgement-receipt.index') }}">Acknowledgement Receipt</a></li>
        <li class="breadcrumb-item active" aria-current="page">AR #{{ $acknowledgementReceipt->ar_number }}</li>
    </ol>
</nav>
<div class="app-card shadow-sm mb-2 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h3>AR #: {{ $acknowledgementReceipt->ar_number }}</h3>
            <div class="row">
                <div class="col-sm-4">
                    <table>
                        <tr>
                            <td>Client/Customer</td>
                            <td class="fw-bold">: {{ $acknowledgementReceipt->customer?->business_name }}</td>
                        </tr>
                        <tr>
                            <td>Date Issued</td>
                            <td class="fw-bold">: {{ $acknowledgementReceipt->date_issued }}</td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td class="fw-bold">: {{ $acknowledgementReceipt->type }}</td>
                        </tr>
                        <tr>
                            <td>Mode</td>
                            <td class="fw-bold">: {{ $acknowledgementReceipt->mode_of_payment }}</td>
                        </tr>
                        <tr>
                            <td>Amount</td>
                            <td class="fw-bold">: {{ toPeso($acknowledgementReceipt->amount) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-8">
                    @if($acknowledgementReceipt->status == "draft")
                            <div class="text-end">
                                <form action="{{ route("dashboard.acknowledgement-receipt.update.status", $acknowledgementReceipt) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="subject-for-approval">
                                    <button type="submit" class="btn btn-lg btn-success"><i class="fa fa-check"></i> Submit for Approval</button>
                                </form>
                            </div>   
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
                            @forelse($acknowledgementReceipt->approvals as $approval)
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
                            @if(!in_array(Auth::user()->id, $acknowledgementReceipt->approvals()->pluck('user_id')->toArray()))
                                <button type="button" class="btn-success btn" data-bs-toggle="modal" data-bs-target="#approvalFormModal">
                                    <i class="fa fa-check"></i> Approve
                                </button>
                            @endif
                        @endcan
                        {{-- @if(!$purchaseOrder->status == "released") --}}
                        @can("Manage Acknowledgement Receipt")
                            <button type="button" class="btn-success btn @if(!$acknowledgementReceipt->approvals_count) disabled @endif" data-bs-toggle="modal" data-bs-target="#releaseDeliveryRecieptModal">
                                <i class="fa fa-arrow-up"></i> Release
                            </button>
                        @endcan
                        {{-- @endif --}}
                        @if($acknowledgementReceipt->delivery_receipts_count)
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
                                        @foreach($acknowledgementReceipt->deliveryReceipts as $deliveryReceipt)
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
                @if($acknowledgementReceipt->status == "draft")
                    <div class="col-sm-4">
                        <form action="{{ route("dashboard.acknowledgement.receipt.add.payment") }}" method="POST">
                            @csrf
                            <input type="hidden" name="acknowledgement_receipt_id" value="{{ $acknowledgementReceipt->id }}">
                            <div id="customer" data-customer-id="{{ $acknowledgementReceipt->customer?->id }}"></div>
                            <div id="mode_payment" data-mode-payment-id="{{ $acknowledgementReceipt->mode_of_payment }}"></div>
                            <delivery-receipt-input></delivery-receipt-input>
                        </form>
                    </div>
                @endif
                <div class="@if($acknowledgementReceipt->status == "draft") col-sm-8 @else col-sm-12 @endif">
                    <table class="table">
                        <thead>
                            <th>DR#</th>
                            <th>SO#</th>
                            @if($acknowledgementReceipt->mode_of_payment == "PDC")
                                <th>Bank</th>
                                <th>Check Number</th>
                                <th>Check Date</th>
                            @endif
                            <th>DR Amount</th>
                            <th>Amount</th>
                            {{-- <th class='text-end'>Outstanding Balance</th> --}}
                            @if($acknowledgementReceipt->status == "draft")
                                <th></th>
                            @endif
                        </thead>
                        <tbody>
                            @forelse($acknowledgementReceipt->payments as $payment)
                                    @if($acknowledgementReceipt->mode_of_payment == "PDC")
                                        @foreach($payment->bankChecks as $bankCheck)
                                            <tr>
                                                <td>
                                                    @if($loop->first)
                                                        {{ $payment->deliveryReceipt?->dr_number }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($loop->first)
                                                        @if($payment->deliveryReceipt?->salesOrder)
                                                            <a target="_blank" href="{{ route("dashboard.sales-order.show", $payment->deliveryReceipt?->salesOrder?->id) }}">{{ $payment->deliveryReceipt?->salesOrder?->so_number }}</a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $bankCheck->bank }}</td>
                                                <td>{{ $bankCheck->number }}</td>
                                                <td>{{ $bankCheck->check_date->format('M d, Y') }}</td>
                                                <td>
                                                    @if($loop->first)
                                                        {{ toPeso($payment->deliveryReceipt?->amount) }}
                                                    @else   
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ toPeso($bankCheck->amount) }}</td>
                                                {{-- <td class='text-end text-danger'>{{ toPeso($payment->salesOrder?->net - $acknowledgementReceipt->amount) }}</td> --}}
                                                @if($acknowledgementReceipt->status == "draft")
                                                    <td class="text-end"  style="width:50px;">
                                                        <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-payment-{{ $payment->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                                        <form id="delete-payment-{{ $payment->id }}" action="{{ route('dashboard.acknowledgement.receipt.delete.payment', ['acknowledgement-receipt-id' => $acknowledgementReceipt->id , 'item' => $payment->id]) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="acknowledgement-receipt-id" value="{{ $acknowledgementReceipt }}">
                                                            <input type="hidden" name="item" value="{{ $payment->id }}">
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                        <td>{{ $payment->deliveryReceipt?->dr_number }}</td>
                                        <td>
                                            @if($payment->deliveryReceipt?->salesOrder)
                                                <a target="_blank" href="{{ route("dashboard.sales-order.show", $payment->deliveryReceipt?->salesOrder?->id) }}">{{ $payment->deliveryReceipt?->salesOrder?->so_number }}</a>
                                            @endif
                                        </td>
                                        <td> {{ toPeso($payment->deliveryReceipt?->amount) }}</td>
                                        <td>{{ toPeso($payment->amount) }}</td>
                                        @if($acknowledgementReceipt->status == "draft")
                                            <td class="text-end" style="width:50px;">
                                                <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-payment-{{ $payment->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                                <form id="delete-payment-{{ $payment->id }}" action="{{ route('dashboard.acknowledgement.receipt.delete.payment', ['acknowledgement-receipt-id' => $acknowledgementReceipt->id , 'item' => $payment->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="acknowledgement-receipt-id" value="{{ $acknowledgementReceipt }}">
                                                    <input type="hidden" name="item" value="{{ $payment->id }}">
                                                </form>
                                            </td>
                                        @endif
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $acknowledgementReceipt->mode_of_payment == "PDC" ? 8 : 5 }}" class="text-center">No items</td>
                                </tr>                            
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="{{ $acknowledgementReceipt->mode_of_payment == "PDC" ? 6 : 3 }}" class=" fw-bold">Total Payment</td>
                                <td class="fw-bold">{{ toPeso($acknowledgementReceipt->amount) }}</td>
                                @if($acknowledgementReceipt->status == "draft")
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
                    <input type="hidden" name="id" value="{{ $acknowledgementReceipt->id }}">
                    <input type="hidden" name="model" value="{{ AcknowledgementReceipt::class }}">
                    <div class="mb-3">
                        <label>Acknowledgement Receipt Number</label>
                        <input type="text" readonly class="form-control" value="{{ $acknowledgementReceipt->ar_number }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Note</label>
                        <textarea name="note" style="height: 80px" class="form-control" placeholder="optional..">{{ $acknowledgementReceipt->note }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success text-white">Approve Acknowledgement Receipt</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


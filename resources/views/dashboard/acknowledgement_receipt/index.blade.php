@extends('dashboard.includes.layouts.app')

@section('page-title', 'Acknowledgement Receipt')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Collection</li>
        <li class="breadcrumb-item" aria-current="page">
            Acknowledgement Receipt
        </li>
    </ol>
</nav>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h4 class="text-success mb-3">Acknowledgement Receipts</h4>
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
                            <i class="fa fa-plus"></i> Add Acknowledgement Receipt
                        </button>
                    </div>
                </div>
            </form>
            <div>
                {{ $acknowledgementReceipts->appends([
                        'q' => Request::get('q')
                    ])
                    ->links()
                }}
            </div>
            <div class="p-1">
                Legend: 
                <span class="bg-secondary rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;</span> Draft &nbsp;&nbsp;
                <span class="bg-warning rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;</span> Subject for Approval &nbsp;&nbsp;
                <span class="bg-success rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;</span> Received
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <td></td>
                        <th>AR#</th>
                        <th>Client/Customer</th>
                        <th>Date Issued</th>
                        <th>DR#</th>
                        <th>SO#</th>
                        <th>Amount</th>
                        <th>Encoded By</th>
                        <th>Encoded Date</th>
                        <th style="width:120px"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($acknowledgementReceipts as $acknowledgementReceipt)
                        <tr>
                            <td>
                                <span class="bg-{{ $acknowledgementReceipt->status_color }} rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            </td>
                            <td>
                                <a href="{{ route("dashboard.acknowledgement-receipt.show", $acknowledgementReceipt) }}">
                                    {{ $acknowledgementReceipt->ar_number }}
                                </a>
                            </td>
                            <td>{{ $acknowledgementReceipt->customer?->business_name }}</td>
                            
                            <td>{{ $acknowledgementReceipt->date_issued->format('M d, Y') }}</td>
                            <td>
                                @foreach($acknowledgementReceipt->payments as $payment)
                                     <a href="#">{{ $payment->deliveryReceipt?->dr_number }}</a> 
                                     @if(!$loop->last) | @endif  
                                @endforeach
                            </td>
                            <td>
                                @foreach($acknowledgementReceipt->payments as $payment)
                                    @if($payment->deliveryReceipt?->salesOrder)
                                        <a href="{{  route("dashboard.sales-order.show", $payment->deliveryReceipt?->salesOrder) }}">{{ $payment->deliveryReceipt?->salesOrder?->so_number }}</a> 
                                        @if(!$loop->last) | @endif 
                                    @endif 
                                @endforeach
                            </td>
                            <td>{{ toPeso($acknowledgementReceipt->amount) }}</td>
                            <td>{{ $acknowledgementReceipt->user?->name }}</td>
                            <td>{{ $acknowledgementReceipt->created_at->format('M d, Y h:iA') }}</td>
                            <td class="text-end">
                                <a href="{{ route('dashboard.acknowledgement-receipt.show', $acknowledgementReceipt) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-eye"></i></a>
                            
                                <a href="{{ route('dashboard.acknowledgement-receipt.edit', $acknowledgementReceipt) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-pencil"></i></a>
                            
                                <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $acknowledgementReceipt->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                <form id="delete-{{ $acknowledgementReceipt->id }}" action="{{ route('dashboard.customer.destroy', $acknowledgementReceipt->id) }}" method="POST">@csrf @method('DELETE')</form>
                            
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
                {{ $acknowledgementReceipts->appends([
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
            <form action="{{ route("dashboard.acknowledgement-receipt.store") }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalWithSelect2Label">Acknowledgement Receipt Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                        <select name="customer_id" class="form-select select2-modal" required data-uri="/api/customer/select2"></select>
                    </div>
                    <div class="mb-3">
                        <label for="ar_number" class="form-label">AR Number</label>
                        <input type="text" name="ar_number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_issued" class="form-label">Date Issue</label>
                        <input type="date" name="date_issued" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="mode_of_payment" class="form-label">Mode of Payment</label>
                        <select name="mode_of_payment" class="form-select" required>
                            <option value="PDC">PDC (Post Dated Check)</option>
                            <option value="Cash">Cash</option>
                            <option value="Online">Online</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select name="type" class="form-select" required>
                            <option value="Acknowledgement Receipt">Acknowledgement Receipt</option>
                            <option value="Counter Receipt">Counter Receipt</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary text-white">
                        <i class="fa fa-arrow-right"></i> Proceed
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@include("dashboard.includes.libraries.select2")


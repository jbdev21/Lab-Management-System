@extends('dashboard.includes.layouts.app')

@section('page-title', 'Bank Check Detail: ' . $bankCheck->number)

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Collection</li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('dashboard.bank-check.index') }}">Bank Checks</a></li>
        <li class="breadcrumb-item active" aria-current="page">Check #{{ $bankCheck->number }}</li>
    </ol>
</nav>
<div class="app-card shadow-sm mb-2 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h4 class="pull-right">{{ ucfirst($bankCheck->status) }}</h4>
            <h3>Check #: {{ $bankCheck->number }}</h3>
                <table>
                    <tr>
                        <td>Bank</td>
                        <td class="fw-bold">: 
                            {{ $bankCheck->bank }}
                        </td>
                    </tr>
                    <tr>
                        <td>Customer</td>
                        <td class="fw-bold">: 
                            @if($bankCheck->bankCheckable?->deliveryReceipt?->salesOrder?->customer)
                                <a href="{{ route("dashboard.customer.show", $bankCheck->bankCheckable?->deliveryReceipt?->salesOrder?->customer_id) }}">{{ $bankCheck->bankCheckable?->deliveryReceipt?->salesOrder?->customer?->business_name }}</a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>AR Number</td>
                        <td class="fw-bold">: 
                            @if($bankCheck->bankCheckable?->acknowledgementReceipt)
                                <a target="_blank" href="{{ route("dashboard.acknowledgement-receipt.show", $bankCheck->bankCheckable?->acknowledgementReceipt?->id) }}">{{ $bankCheck->bankCheckable?->acknowledgementReceipt?->ar_number }}</a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>SO Number</td>
                        <td class="fw-bold">: 
                            @if($bankCheck->bankCheckable?->deliveryReceipt?->salesOrder)
                                <a target="_blank" href="{{ route("dashboard.sales-order.show", $bankCheck->bankCheckable?->deliveryReceipt?->salesOrder?->id) }}">{{ $bankCheck->bankCheckable?->deliveryReceipt?->salesOrder?->so_number }}</a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>DR Number</td>
                        <td class="fw-bold">: 
                            @if($bankCheck->bankCheckable?->deliveryReceipt)
                                <a target="_blank" href="{{ route("dashboard.delivery-receipt.show", $bankCheck->bankCheckable?->deliveryReceipt?->id) }}">{{ $bankCheck->bankCheckable?->deliveryReceipt?->dr_number }}</a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Check Date</td>
                        <td class="fw-bold">: {{ $bankCheck->check_date->format("Y-m-d") }}</td>
                    </tr>
                </table>
        </div>  
    </div>
</div>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <div class="row"> 
                <div class="col-sm-4">
                    <form class="overlayed-form" action="{{ route("dashboard.bank-check-history.store") }}" method="POST">
                        @csrf
                        <input type="hidden" name="bank_check_id" value="{{ $bankCheck->id }}">
                        <div class="form-group mb-3">
                            <label>Deposit Date</label>
                            <input type="date" max="{{ date("Y-m-d") }}" value="{{ date("Y-m-d") }}" required name="deposit_date" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label>Status</label>
                            <select class="form-select" name="status" required>
                                <option value="cleared">Cleared</option>
                                <option value="bounced">Bounced</option>
                                <option value="for-replacement">For Replacement</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Funds</label>
                            <select class="form-select" name="fund_id" required>
                                <option value=""> - not applicable - </option>
                                @foreach($funds as $fund)
                                    <option value="{{ $fund->id }}">{{ $fund->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Reason</label>
                            <textarea type="date" name="reason" class="form-control"></textarea>
                        </div>
                        <button class="btn btn-success @if($bankCheck->status == "cleared") disabled @endif"><i class="fa fa-save"></i> Save History</button>
                    </form>
                </div>
                <div class="col-sm-8">
                    <table class="table">
                        <thead>
                            <th>Status</th>
                            <th>Reason</th>
                            <th>Deposit Date</th>
                            <th>Funds</th>
                            <th>Encoded By</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @forelse($bankCheck->bankCheckHistories as $history)
                                <tr>
                                    <td>{{ ucfirst($history->status) }}</td>
                                    <td>{{ $history->reason }}</td>
                                    <td>{{ $history->deposit_date->format("Y-m-d") }}</td>
                                    <td>{{ $history->fund?->name }}</td>
                                    <td>{{ $history->user?->name }}</td>
                                    <td class="text-end">
                                        <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $history->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                        <form id="delete-{{ $history->id }}" action="{{ route('dashboard.bank-check-history.destroy', $history->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                        </form>
                                    </td>
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

@endsection


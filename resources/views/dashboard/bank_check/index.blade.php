@extends('dashboard.includes.layouts.app')

@section('page-title', 'Bank Check')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item" aria-current="page">Collection</li>
      <li class="breadcrumb-item active" aria-current="page">Bank Check</li>
    </ol>
  </nav>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h4 class="text-success mb-3">Bank Checks</h4>
            <form>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="input-group mb-3">
                            <input value="{{ Request::get("q") }}" type="text" class="form-control" placeholder="Search for Check Number or Bank" name="q">
                            <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-3">
                       <select name="status" id="" class="form-select select-change-submit">
                            <option value="">All Status</option>
                            <option value="pending" @if(Request::get("status") == "pending" ) selected @endif >Pending</option>
                            <option value="deposited" @if(Request::get("status") == "deposited" ) selected @endif >Deposited</option>
                            <option value="bounced"  @if(Request::get("status") == "bounced" ) selected @endif >Bounced</option>
                       </select>
                    </div>
                    <div class="col-lg-3 d-flex">
                        <div class="px-1">
                            <input type="date" name="date_from" class="form-control select-change-submit" value="{{ Request::get("date_from") }}">
                        </div>
                        <div class="px-1">
                            <input type="date" name="date_to" class="form-control select-change-submit" min="{{ Request::get("date_from") }}" value="{{ Request::get("date_to") }}">
                        </div>
                    </div>
                </div>
            </form>
            <div>
                {{ $bankChecks->appends([
                        'q' => Request::get('q')
                    ])
                    ->links()
                }}
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>AR Number</th>
                        <th>SO Number</th>
                        <th>DR Number</th>
                        <th>Customer</th>
                        <th>Check Number</th>
                        <th>Bank Name</th>
                        <th>Check Date</th>
                        <th>Last Deposite</th>
                        <th>Amount</th>
                        <th style="width:120px"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bankChecks as $bankCheck)
                        <tr>
                            <td>{{ ucfirst($bankCheck->status) }}</td>
                            <td>
                                @if($bankCheck->bankCheckable?->acknowledgementReceipt)
                                    <a target="_blank" href="{{ route("dashboard.acknowledgement-receipt.show", $bankCheck->bankCheckable?->acknowledgementReceipt?->id) }}">{{ $bankCheck->bankCheckable?->acknowledgementReceipt?->ar_number }}</a>
                                @endif
                            </td>
                            <td>
                                @if($bankCheck->bankCheckable?->deliveryReceipt?->salesOrder)
                                    <a target="_blank" href="{{ route("dashboard.sales-order.show", $bankCheck->bankCheckable?->deliveryReceipt?->salesOrder?->id) }}">{{ $bankCheck->bankCheckable?->deliveryReceipt?->salesOrder?->so_number }}</a>
                                @endif
                            </td>
                            <td>
                                @if($bankCheck->bankCheckable?->deliveryReceipt)
                                    <a target="_blank" href="{{ route("dashboard.delivery-receipt.show", $bankCheck->bankCheckable?->deliveryReceipt?->id) }}">{{ $bankCheck->bankCheckable?->deliveryReceipt?->dr_number }}</a>
                                @endif
                            </td>
                            <td>
                                @if($bankCheck->bankCheckable?->deliveryReceipt?->salesOrder?->customer)
                                    <a href="{{ route("dashboard.customer.show", $bankCheck->bankCheckable?->deliveryReceipt?->salesOrder?->customer_id) }}">{{ $bankCheck->bankCheckable?->deliveryReceipt?->salesOrder?->customer?->business_name }}</a>
                                @endif
                            </td>
                            <td>{{ $bankCheck->number }}</td>
                            <td>{{ $bankCheck->bank }}</td>
                            <td>{{ $bankCheck->check_date->format("Y-m-d") }}</td>
                            <td>{{ $bankCheck->lastestBankCheckHistory?->deposite_date?->format("Y-m-d") }}</td>
                            <td>{{ toPeso($bankCheck->amount) }}</td>
                            <td class="text-end">
                                <a href="{{ route('dashboard.bank-check.show', $bankCheck) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-eye"></i> Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No Records</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{ $bankChecks->appends([
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


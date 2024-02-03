@extends('dashboard.includes.layouts.app')

@section('page-title', 'Account Receivable')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item" aria-current="page">Collection</li>
      <li class="breadcrumb-item active" aria-current="page">Account Receivable</li>
    </ol>
  </nav>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h4 class="text-success mb-3">Account Receivable</h4>
            <form>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search.." name="q">
                            <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    {{-- <div class="col-lg-8 text-end">
                        <button type="button" class="btn btn-primary text-white pull-right mb"  data-bs-toggle="modal" data-bs-target="#modalWithSelect2">
                            <i class="fa fa-plus"></i> Add Sales Order
                        </button>
                    </div> --}}
                </div>
            </form>
            <div>
                {{ $deliveryReceipts->appends([
                        'q' => Request::get('q')
                    ])
                    ->links()
                }}
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>DR Number</th>
                        <th>Current AR</th>
                        <th>ASM</th>
                        <th>Term</th>
                        <th>DR Date</th>
                        <th>Due Date </th>
                        <th>Aging</th>
                        <th>Amount</th>
                        <th>Balance</th>
                        <th style="width:120px"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($deliveryReceipts as $deliveryReceipt)
                        <tr>
                            <td>
                                <a href="{{ route("dashboard.customer.show", $deliveryReceipt->salesOrder?->customer) }}">
                                    {{ $deliveryReceipt->salesOrder?->customer?->business_name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route("dashboard.delivery-receipt.show", $deliveryReceipt->dr_number) }}">{{ $deliveryReceipt->dr_number }}</a>
                            </td>
                            <td>
                                @foreach($deliveryReceipt->acknowledgementReceipts as $ar)
                                    <a target="_blank" href="{{ route("dashboard.acknowledgement-receipt.show", $ar->id) }}">{{ $ar->ar_number }}</a>
                                    @if(!$loop->last),  @endif
                                @endforeach
                            </td>
                            <td>{{ $deliveryReceipt->user?->name }}</td>
                            <td>{{ $deliveryReceipt->term }}</td>
                            <td>{{ $deliveryReceipt->created_at->format("Y-m-d") }}</td>
                            <td>{{ $deliveryReceipt->due_date?->format("Y-m-d") }}</td>
                            <td>{{ $deliveryReceipt->aging() }}</td>
                            <td>{{ toPeso($deliveryReceipt->amount) }}</td>
                            <td>{{ toPeso($deliveryReceipt->balance) }}</td>
                            <td class="text-end">
                                <a href="{{ route('dashboard.delivery-receipt.show', $deliveryReceipt) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-eye"></i> View</a>
                            
                                {{-- <a href="{{ route('dashboard.delivery-receipt.edit', $deliveryReceipt) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-pencil"></i></a>
                            
                                <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $deliveryReceipt->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                <form id="delete-{{ $deliveryReceipt->id }}" action="{{ route('dashboard.delivery-receipt.destroy', $deliveryReceipt->id) }}" method="POST">@csrf @method('DELETE')</form> --}}
                            
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
                {{ $deliveryReceipts->appends([
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


@extends('dashboard.includes.layouts.app')

@section('page-title', 'Delivery Receipt')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Booking</li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('dashboard.delivery-receipt.index') }}">Delivery Receipts</a></li>
        <li class="breadcrumb-item active" aria-current="page">DR #{{ $deliveryReceipt->dr_number }}</li>
    </ol>
</nav>
<div class="app-card shadow-sm mb-2 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h3>DR #: {{ $deliveryReceipt->dr_number }}</h3>
            <table>
                <tr>
                    <td>Customer</td>
                    <td class="fw-bold">: {{ $deliveryReceipt?->salesOrder?->customer?->business_name }}</td>
                </tr>
                <tr>
                    <td>Contact Number</td>
                    <td class="fw-bold">: {{ $deliveryReceipt?->salesOrder?->customer?->contact_number }}</td>
                </tr>
                <tr>
                    <td>Classification</td>
                    <td class="fw-bold">: {{ $deliveryReceipt?->salesOrder?->customer?->category?->name }}</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td class="fw-bold">: {{ $deliveryReceipt?->salesOrder?->customer?->address }}</td>
                </tr>
                <tr>
                    <td>Terms</td>
                    <td class="fw-bold">: {{ $deliveryReceipt->term }}</td>
                </tr>
                <tr>
                    <td>SO Date</td>
                    <td class="fw-bold">: {{ $deliveryReceipt->created_at->format("Y-m-d") }}</td>
                </tr>
                <tr>
                    <td>Due Date</td>
                    <td class="fw-bold">: {{ $deliveryReceipt->due_date->format("Y-m-d") }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h4 class="text-success mb-3">Products</h4>
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
                </thead>
                <tbody>
                    @forelse($deliveryReceipt->products as $product)
                        <tr>
                            <td>{{ $product->abbreviation }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ ucfirst($product->unit) }}</td>
                            <td>{{ $product->type }}</td>
                            <td>{{ $product->pivot->quantity }}</td>
                            <td class='text-end'>{{ toPeso($product->pivot->unit_price) }}</td>
                            <td class="text-end">{{ toPeso($product->pivot->discount) }}</td>
                            <td class="text-end">{{ toPeso($product->pivot->amount) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No items</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="text-end fw-bold"></td>
                        <td class="text-end fw-bold">{{ toPeso($deliveryReceipt->discount) }}</td>
                        <td class="text-end fw-bold">{{ toPeso($deliveryReceipt->amount) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>



@endsection


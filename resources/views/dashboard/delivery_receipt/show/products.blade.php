@extends('dashboard.includes.layouts.app')

@section('page-title', 'Delivery Receipt')

@section('content')
@include('dashboard.delivery_receipt.includes.head')

<div class="card">
    @include('dashboard.delivery_receipt.includes.tab')
    <div class="app-card-body p-4">
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
                @forelse($products as $product)
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
@endsection


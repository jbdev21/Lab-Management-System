@extends('agent.includes.layouts.app')

@section('page-title', 'Booking')

@section('content')
    <div class="row">
        <div class="col">
            <h5 class="text-success mb-3">Booking</h5>
        </div>
    </div>
    <div class="app-card">
        <div class="app-card-body p-3">
            <h4 class="fw-bold text-success mb-0">
                Booking: {{ $booking->booking_code }}
            </h4>
            <div class="row">
                <div class="col text-secondary">Customer: {{ $booking->customer?->business_name }}</div>
            </div>
        </div>
    </div>
    <div class="row my-3">
        <div class="col">
            <h5>Products</h5>
        </div>
        <div class="col text-end">
            <a class="" href="{{ route("agent.booking.add.product.form", $booking) }}" ><i class="fa fa-plus"></i> Add Product </a>
        </div>
    </div>
    @forelse($products as $product)
        <div class="shadow-1 bg-white py-2 px-2 mb-2 rounded">
            <!-- Default dropstart button -->
            <a class="pull-right text-danger delete-button" href="#" type="button" data-type="form" data-form="delete-form-{{ $product->id }}" ><i class="fa fa-trash"></i></a>
            <form action="{{ route("agent.booking.remove.product", $booking) }}" id="delete-form-{{ $product->id }}" method="POST">
                @csrf @method("DELETE") <input type="hidden" value="{{ $product->id }}">
            </form>
            <strong>{{ $product->description }}</strong>
            <small>
                <div class="row">
                    <div class="col">
                        Price: {{ toPeso($product->pivot->unit_price) }}
                    </div>
                    <div class="col">
                        Quantity: {{ $product->pivot->quantity }}
                    </div>
                    <div class="col">
                        Discount: {{ toPeso($product->pivot->quantity) }}
                    </div>
                </div>
            </small>
        </div>
    @empty
        <div class="py-3 text-center mb-3">
            <div class="text-center p-3">
                <img src="/images/empty.svg" style='width:200px' class="mw-100" alt="">
            </div>
            Please add product
        </div>
    @endforelse

    @if(count($products))
        <table class="mb-3 mt-5 fw-bold">
            <tr>
                <td>Term</td>
                <td>: {{ $booking->term }}</td>
            </tr>
            <tr>
                <td>Discount</td>
                <td>: {{ toPeso($booking->discount) }}</td>
            </tr>
            <tr>
                <td>Amount</td>
                <td>: {{ toPeso($booking->amount) }}</td>
            </tr>
        </table>
        <div class='d-grid mb-5'>
            <a href="#" class="btn btn-primary">Submit For Approval</a>
        </div>
    @endif
@endsection
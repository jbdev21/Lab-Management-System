@extends('agent.includes.layouts.app')

@section('page-title', 'Booking')

@section('content')
    <div class="row mb-3">
        <div class="col">
            <a href="{{ route("agent.booking.list.product", $booking) }}"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
    
    <div class="bg-white p-3">
        <form class="overlayed-form" action="{{ route("agent.booking.add.product", $booking) }}" method="POST">
            @csrf
            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
            <sales-order-products-input customerid="{{ $booking->customer_id }}" soid="{{ $booking->id }}"></sales-order-products-input>
        </form>
    </div>
@endsection
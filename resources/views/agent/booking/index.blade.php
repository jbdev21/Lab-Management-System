@extends('agent.includes.layouts.app')

@section('page-title', 'Booking')

@section('content')
    <div class="row">
        <div class="col">
            <h5 class="text-success mb-3">Booking</h5>
        </div>
        <div class="col text-end">
            <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#addBookingModal"><i class="fa fa-plus"></i> Add New </a>
        </div>
    </div>
    @forelse($bookings as $booking)
        <a href="{{ route("agent.booking.show", $booking) }}" class="mb-2 d-block">
            <div class="app-card">
                <div class="app-card-body p-3">
                    <small class="pull-right px-1 
                        @if($booking->status == "pending") 
                            bg-secondary text-white 
                        @else 
                            bg-primary text-white
                        @endif">
                        {{ Str::upper($booking->status) }}
                    </small>
                    <h4 class="fw-bold text-success mb-0">
                        Booking: {{ $booking->booking_code }}
                    </h4>
                    <div class="row">
                        <div class="col text-secondary">Customer: {{ $booking->customer?->business_name }}</div>
                        <div class="col text-secondary text-end">{{ $booking->created_at->format("m/d/Y") }}</div>
                    </div>
                </div>
            </div>
        </a>
    @empty  
        <div class="py-3 text-center mb-3">
            <div class="text-center p-3">
                <img src="/images/empty.svg" style='width:200px' class="mw-100" alt="">
            </div>
            No Booking Yet
        </div>
    @endforelse

    <!-- Modal -->
<div class="modal fade" id="addBookingModal" tabindex="-1" aria-labelledby="addBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookingModalLabel">Add Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route("agent.booking.store") }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for=""> Customer</label>
                        <select name="customer_id" class="form-select">
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->business_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
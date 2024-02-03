@extends('dashboard.includes.layouts.app')

@section('page-title', 'Booking')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item" aria-current="page">Booking</li>
      <li class="breadcrumb-item active" aria-current="page">List</li>
    </ol>
  </nav>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h4 class="text-success mb-3">Booking</h4>
            <form>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search.." name="q">
                            <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
            <div>
                {{ $bookings->appends([
                        'q' => Request::get('q')
                    ])
                    ->links()
                }}
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Booking Code</th>
                        <th>Customer</th>
                        <th>Book By</th>
                        <th>Number of Products</th>
                        <th>Updated</th>
                        <th style="width:120px"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td>{{ ucFirst($booking->status) }}</td>
                            <td>
                                <a href="{{ route('dashboard.booking.show', $booking) }}" >
                                    {{ $booking->booking_code }}
                                </a>
                            </td>
                            <td>{{ $booking->customer?->business_name }}</td>
                            <td>{{ ucFirst($booking->agent?->name) }}</td>
                            <td>{{ $booking->products_count }}</td>
                            <td>{{ $booking->updated_at->format("Y-m-d h:i A") }}</td>
                            <td class="text-end">
                                <a href="{{ route('dashboard.booking.show', $booking) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-eye"></i> View</a>
                            
                                {{-- <a href="{{ route('dashboard.delivery-receipt.edit', $bookings) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-pencil"></i></a>
                            
                                <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $deliveryReceipt->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                <form id="delete-{{ $deliveryReceipt->id }}" action="{{ route('dashboard.delivery-receipt.destroy', $deliveryReceipt->id) }}" method="POST">@csrf @method('DELETE')</form> --}}
                            
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Records</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{ $bookings->appends([
                    'q' => Request::get('q')
                    ])
                    ->links()
                }}
            </div>
        </div>
    </div>
</div>
@endsection


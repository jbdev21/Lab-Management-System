@extends('dashboard.includes.layouts.app')

@section('page-title', 'Booking')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Booking</li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('dashboard.booking.index') }}">List</a></li>
        <li class="breadcrumb-item active" aria-current="page">#{{ $booking->booking_code }}</li>
    </ol>
</nav>
<div class="app-card shadow-sm mb-2 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h3>#{{ $booking->booking_code }}</h3>
            <div class="row">
                <div class="col-sm-4">
                    <table>
                        <tr>
                            <td>Customer</td>
                            <td class="fw-bold">: {{ $booking->customer?->business_name }}</td>
                        </tr>
                        <tr>
                            <td>Contact Number</td>
                            <td class="fw-bold">: {{ $booking->customer?->contact_number }}</td>
                        </tr>
                        <tr>
                            <td>Classification</td>
                            <td class="fw-bold">: {{ $booking->customer?->category?->name }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td class="fw-bold">: {{ $booking->customer?->address }}</td>
                        </tr>
                        <tr>
                            <td>Agent</td>
                            <td class="fw-bold">: {{ $booking->customer?->agent?->name }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-8">
                    @if($booking->status == "draft")
                        @if($booking->products_count > 0)
                            <div class="text-end">
                                <form action="{{ route("dashboard.booking.update", $booking) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="subject-for-approval">
                                    <button type="submit" class="btn btn-lg btn-success"><i class="fa fa-check"></i> Submit for Approval</button>
                                </form>
                            </div>    
                        @endif
                    @else
                        <div class="mb-2">
                            <h6>Approvals</h6>
                        </div>
                        <table class="table mt-1 mb-4">
                            <tr>
                                <td>Name</td>
                                <td>Department</td>
                                <td>Date/Time</td>
                                <td>Note</td>
                                <td></td>
                            </tr>
                            @forelse($booking->approvals as $approval)
                                <tr>
                                    <td>{{ $approval->user?->name }}</td>
                                    <td>-</td>
                                    <td>{{ $approval->created_at->format("Y-m-d h:iA") }}</td>
                                    <td>{{ $approval->note }}</td>
                                    <td class="text-end">
                                        @can("manage approval")
                                            <a href="#" class="btn-sm btn-danger py-0 btn text-white px-2 delete-button" >Revoke</a>
                                            <form action="{{ route("dashboard.approval.destroy", $approval->id) }}">@csrf @method('DELETE')</form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center"> No approval</td>
                                </tr>
                            @endforelse
                        </table>
                        <div class="text-end">
                            @can("manage approval")
                                @if(!in_array(Auth::user()->id, $booking->approvals()->pluck('user_id')->toArray()))
                                    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approvalFormModal">
                                        <i class="fa fa-check"></i> Approve
                                    </button>
                                @endif
                            @endcan
                        
                            <form action="{{ route('dashboard.booking.update', $booking) }}" method="POST" class="d-inline-block" id="booking-generate-so-form">
                                @csrf
                                @method('PUT')
                                <button type="button" id="booking-generate-so" class="btn btn-success @if(!$booking->approvals_count) disabled @endif">Generate Sale Order</button>
                            </form>
                        </div>
                        
                    @endif    
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <div class="row">
                <div class="col-sm-12">
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
                            @forelse($booking->products as $product)
                                <tr>
                                    <td>{{ $product->abbreviation }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->unit }}</td>
                                    <td>{{ $product->type }}</td>
                                    <td>{{ $product->pivot->quantity }}</td>
                                    <td class='text-end'>{{ toPeso($product->pivot->unit_price) }}</td>
                                    <td class="text-end">{{ toPeso($product->pivot->discount) }}</td>
                                    <td class="text-end">{{ toPeso($product->pivot->amount) }}</td>
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

<div class="modal fade" id="approvalFormModal" tabindex="-1" role="dialog" aria-labelledby="approvalFormModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-start">
            <form action="{{ route("dashboard.approval.store") }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Approval Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $booking->id }}">
                    <input type="hidden" name="model" value="{{ booking::class }}">
                    <div class="mb-3">
                        <label>Booking Code</label>
                        <input type="text" readonly class="form-control" value="{{ $booking->booking_code }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Note</label>
                        <textarea name="note" style="height: 80px" class="form-control" placeholder="optional.."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success text-white">Approve Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


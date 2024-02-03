@extends('dashboard.includes.layouts.app')

@section('page-title', 'Edit Customer')

@section('content')
<h5 class="text-success mb-3">Edit Customers</h5>
<div class="row gx-5 gy-3">
    <div class="col-lg-6">
        <div class="app-card shadow-sm mb-4 border-left-decoration">
            <div class="inner">
                <div class="app-card-body p-4">
                    <form action="{{ route('agent.customer.update', $customer) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label for="">Customer Type</label>
                            <select name="category_id" class="form-select">
                                @foreach($classifications as $classification)
                                    <option value="{{ $classification->id }}" @if($customer->category_id == $classification->id) selected @endif >{{ $classification->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Business Name <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control mb-2" name="business_name" value="{{ $customer->business_name }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Owner <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control mb-2" name="owner" value="{{ $customer->owner }}">
                        </div>
                        <div class="mb-3">
                            <label for="">TIN Number <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control mb-2" name="tin_number" value="{{ $customer->tin_number }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Contact Number <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control mb-2" name="contact_number" value="{{ $customer->contact_number }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Email <span class="text-danger">*</span></label>
                            <input required type="email" class="form-control mb-2" name="email" value="{{ $customer->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Region <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control mb-2" name="area" value="{{ $customer->area }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Address <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control mb-2" name="address" value="{{ $customer->address }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Terms <span class="text-danger">*</span></label>
                            <input required type="number" step="1" min="0" class="form-control mb-2" name="terms" value="{{ $customer->terms }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Credit Limit <span class="text-danger">*</span></label>
                            <input required type="number" step=".1" min="0" class="form-control mb-2" name="credit_limit" value="{{ $customer->credit_limit }}">
                        </div>
                        <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Save Changes</button>
                        <a  class="btn btn-secondary text-white mt-3" href="{{ route("agent.customer.index") }}"><i class="fa fa-ban"></i> Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include("agent.includes.libraries.select2")
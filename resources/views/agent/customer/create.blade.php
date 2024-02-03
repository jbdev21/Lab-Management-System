@extends('agent.includes.layouts.app')

@section('page-title', 'Add Customer')

@section('content')
<h5 class="text-success mb-3">Add Customers</h5>
<div class="row gx-5 gy-3">
    <div class="col-lg-6">
        <div class="app-card shadow-sm mb-4 border-left-decoration">
            <div class="inner">
                <div class="app-card-body p-4">
                    <form action="{{ route('agent.customer.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="">Class Classification</label>
                            <select name="category_id" class="form-select">
                                @foreach($classifications as $classification)
                                    <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Business Name <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control mb-2" name="business_name" value="{{ old("business_name") }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Owner <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control mb-2" name="owner" value="{{ old("owner") }}">
                        </div>
                        <div class="mb-3">
                            <label for="">TIN Number <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control mb-2" name="tin_number" value="{{ old("tin_number") }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Contact Number <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control mb-2" name="contact_number" value="{{ old("contact_number") }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Email <span class="text-danger">*</span></label>
                            <input required type="email" class="form-control mb-2" name="email" value="{{ old("email") }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Area <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control mb-2" name="area" value="{{ old("area") }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Address <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control mb-2" name="address" value="{{ old("address") }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Terms <span class="text-danger">*</span></label>
                            <input required type="number" step="1" min="0" class="form-control mb-2" name="terms" value="{{ old("terms") }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Credit Limit <span class="text-danger">*</span></label>
                            <input required type="number" step=".1" min="0" class="form-control mb-2" name="credit_limit" value="{{ old("credit_limit") }}">
                        </div>
                        {{-- <div class="mb-3">
                            <label for="">Requirements <span class="text-danger">*</span></label>
                        </div>
                     --}}
                        <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Save</button>
                        <a  class="btn btn-secondary text-white mt-3" href="{{ route("agent.customer.index") }}"><i class="fa fa-ban"></i> Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include("agent.includes.libraries.select2")
@extends('agent.includes.layouts.app')

@section('page-title', 'Customer')

@section('content')
    <div class="row">
        <div class="col">
            <h5 class="text-success mb-3">Customers</h5>
        </div>
        <div class="col text-end">
            <a href="{{ route("agent.customer.create") }}"><i class="fa fa-plus"></i> Add New </a>
        </div>
    </div>
    @foreach($customers as $customer)
        <a href="{{ route("agent.customer.show", $customer) }}" class="mb-2 d-block">
            <div class="app-card">
                <div class="app-card-body p-3">
                    <h4 class="fw-bold text-success mb-0">
                        {{ $customer->business_name }}
                        @if(!$customer->verified) 
                            <div><small class="text-danger" style="font-size:12px">(Not Verified)</small></div> 
                        @endif 
                    </h4>
                    <div class="text-secondary">Owner: {{ $customer->owner }}</div>
                    <div class="text-secondary">{{ $customer->address }}</div>
                </div>
            </div>
        </a>
    @endforeach
@endsection
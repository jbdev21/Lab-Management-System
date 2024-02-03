@extends('agent.includes.layouts.app')

@section('page-title', $customer->business_name)

@section('content')
@include('agent.customer.includes.head')

<div class="card">
    @include('agent.customer.includes.tab')
    <div class="app-card-body p-4">
        <table class="table">
            <thead>
                <tr>
                    <th>DR Number</th>
                    <th>ASM</th>
                    <th>Term</th>
                    <th>DR Date</th>
                    <th>Due Date </th>
                    <th>Aging</th>
                    <th>Amount</th>
                    <th>Balance</th>
                    <th style="width:120px"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($deliveryReceipts as $deliveryReceipt)
                    <tr>
                        <td>
                            <a href="{{ route("agent.delivery-receipt.show", $deliveryReceipt->dr_number) }}">{{ $deliveryReceipt->dr_number }}</a>
                        </td>
                        <td>{{ $deliveryReceipt->user?->name }}</td>
                        <td>{{ $deliveryReceipt->term }}</td>
                        <td>{{ $deliveryReceipt->created_at->format("Y-m-d") }}</td>
                        <td>{{ $deliveryReceipt->due_date?->format("Y-m-d") }}</td>
                        <td>{{ $deliveryReceipt->aging() }}</td>
                        <td>{{ toPeso($deliveryReceipt->amount) }}</td>
                        <td>{{ toPeso($deliveryReceipt->balance) }}</td>
                        <td class="text-end">
                            <a href="{{ route('agent.delivery-receipt.show', $deliveryReceipt) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-eye"></i> View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No Records</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $deliveryReceipts->appends([
                'q' => Request::get('q')
                ])
                ->links()
            }}
        </div>
    </div>
</div>
@endsection

@push("scripts")
    <script>
        
        function printDiv(divName, redirect = null){
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            
            if(redirect){
                window.open(redirect, '_self')
            }

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush

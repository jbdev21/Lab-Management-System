@extends('dashboard.includes.layouts.app')

@section('page-title', "Delivert Receipt")

@section('content')
@include('dashboard.delivery_receipt.includes.head')

<div class="card">
    @include('dashboard.delivery_receipt.includes.tab')
    <div class="app-card-body p-4">
        <table class="table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Date Issued</th>
                    <th>DR#</th>
                    <th>SO#</th>
                    <th>Amount</th>
                    <th>Encoded By</th>
                    <th>Encoded Date</th>
                    <th style="width:120px"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($acknowledgementReceipts as $acknowledgementReceipt)
                    <tr>
                        <td>{{ $acknowledgementReceipt->customer?->business_name }}</td>
                        
                        <td>{{ $acknowledgementReceipt->date_issued->format('M d, Y') }}</td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>{{ toPeso($acknowledgementReceipt->amount) }}</td>
                        <td>{{ $acknowledgementReceipt->user?->name }}</td>
                        <td>{{ $acknowledgementReceipt->created_at->format('M d, Y h:iA') }}</td>
                        <td class="text-end">
                            <a href="{{ route('dashboard.acknowledgement-receipt.show', $acknowledgementReceipt) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-eye"></i> Show</a>
                        </td>
                    </tr>
                    
                @empty
                    <tr>
                        <td colspan="13" class="text-center">No Records</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $acknowledgementReceipts->appends([
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

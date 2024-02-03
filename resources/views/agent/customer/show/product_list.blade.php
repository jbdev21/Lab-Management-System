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
                    <th>Product</th>
                    <th>Lastest Price</th>
                    {{-- <th>Lastest DR</th> --}}
                    <th>DR Created<th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>
                            {{ $product->product_description }}
                        </td>
                        <td>{{ toPeso($product->unit_price) }}</td>
                        {{-- <td>
                            {{ $product->delivery_receipt_number }}
                        </td> --}}
                        <td>{{ Carbon\Carbon::parse($product->created_at)->format('M d, Y') }}</td>
                    </tr>
                    
                @empty
                    <tr>
                        <td colspan="13" class="text-center">No Records</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $products->appends([
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

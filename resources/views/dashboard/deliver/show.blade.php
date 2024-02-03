@extends('dashboard.includes.layouts.app')

@section('page-title', 'Deliver Receipt')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item" aria-current="page">Purchase Order</li>
      <li class="breadcrumb-item active" aria-current="page">Deliver</li>
    </ol>
  </nav>
  <div class="row gx-5 gy-3">
        <div class="col-lg-12">
                <a class="btn btn-success text-end text-white mb-4" onclick="printDiv('printableArea', '{{ Request::get("redirect") }}')" target="_blank"><i class="fa fa-print"></i> Print</a>
            <div>
                <div  id="printableArea"  class="app-card shadow-sm mb-4 border-left-decoration col-lg-7">
                    <div class="inner">
                        <div class="app-card-body p-4">
                          
                            <table class="table table-border table-sm">
                                <tbody>
                                    <tr>
                                        <td  colspan="2">
                                            <img class="logo-icon" src="/images/logo.png" alt="logo" style="width:200px; height:50px;">
                                        </td>
                                        <td colspan="3" class="text-end">
                                            <h4 class="mt-3">DELIVER RECEIPT</h4>
                                            <h5>NO. <b class="text-danger">{{ $deliver->reference }}</b></h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <b class="mt-3">PAYEE:</b>
                                            <u>Johnwealth Laboratories Corp.</u>
                                        </td>
                                        <td colspan="2" class="text-end"> 
                                            <span>Date: {{ $deliver->created_at->format('M d, Y') }}</span>
                                        </td>
                                    </tr>
                                    <tr class="text-center thead-light">
                                        <td colspan="2">
                                            <b>PARTICULARS</b>
                                        </td>
                                        <td>
                                            <b>Quantity</b>
                                        </td>
                                        <td>
                                            <b>Amount</b>
                                        </td>
                                        <td>
                                            <b>SUB-AMOUNT</b>
                                        </td>
                                    </tr>
                                    @foreach( $deliver->purchaseOrderItems as $item)
                                        <tr>
                                            @if($item->purchasable)
                                                    <td colspan="2" class="text-center">
                                                        <p>[{{ $item->purchasable->code }}] {{ $item->purchasable->name }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <b>{{ $item->pivot?->quantity }}</b>
                                                    </td>
                                                    <td class="text-center">
                                                        <b>{{ toPeso($item->unit_price) }}</b>
                                                    </td>
                                                    <td class="text-center">
                                                        <b>{{ toPeso($item->pivot?->amount) }}</b>
                                                    </td>
                                            @else
                                                <td colspan="2" class="text-center">
                                                    <p>{{ $item->particular}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <b>{{ $item->pivot?->quantity }}</b>
                                                </td>
                                                <td class="text-center">
                                                    <b>{{ toPeso($item->unit_price) }}</b>
                                                </td>
                                                <td class="text-center">
                                                    <b>{{ toPeso($item->pivot?->amount) }}</b>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                <tr>
                                    <td colspan="4" class="text-end">
                                        <b>TOTAL:</b>
                                    </td>
                                    <td  class="text-center">
                                        <b>{{ toPeso($deliver->purchaseOrderItems->sum(function ($item) {
                                            return $item->pivot->amount ?? 0;
                                        })) }}</b>
                                    </td>
                                </tr>
                                <tr class="pt-4">
                                    <td>
                                        <p>Approved By:</p>
                                    </td>
                                    <td colspan="2">
                                    </td>
                                    <td>
                                        <p class="text-start">Received By:</p>
                                    </td>
                                    <td>
                                        <p>{{ $deliver->user?->name }}</p>
                                    </td>
                                </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <small>Doc. Ref: SAMPLE-ACC 01</small>
                                            <small style="margin-left:20%">Revision No. 000</small>
                                            <small style="margin-left:20%">Effetive Date:{{ now()->format('Y/m/d')}}</small>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div><!--//col-->
                    </div><!--//row-->
                </div><!--//app-card-body-->
            </div><!--//app-card-->
        </div><!--//inner-->
    </div><!--//app-card-->
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

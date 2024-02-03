<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeliveryReceipt;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeliveryReceiptController extends Controller
{
    function deliveryReceiptSearch(Request $request){
        $keyword = $request->keyword;

        return DeliveryReceipt::search($keyword)->get()
        ->map(function($deliveryReceipt){
            return [
                'id' => $deliveryReceipt->id,
                'dr_number' => $deliveryReceipt->dr_number,
                'status' => $deliveryReceipt->status
            ];
        });
    }

    public function deliveryReceiptDetailSearch(Request $request)
    {
        $keyword = $request->keyword;
        $customerId = $request->customer_id;

        $deliveryReceipts = DeliveryReceipt::when($customerId, function (Builder $query) use ($customerId) {
            $query->whereHas('salesOrder', function ($subQuery) use ($customerId) {
                $subQuery->where('customer_id', $customerId);
            });
        })
        ->with(['salesOrder' => function ($query) {
            $query->select('sales_orders.id', 'effectivity_date', 'due_date', 'so_number', 'discount', 'amount', 'net');
        }])
        ->where(function ($query) use ($keyword) {
            if ($keyword) {
                $query->where('dr_number', 'like', '%' . $keyword . '%');
            }
        })
        ->get();

        $formattedResults = $deliveryReceipts->map(function ($deliveryReceipt) {
            return [
                'id' => $deliveryReceipt->id,
                'dr_id' => $deliveryReceipt->id,
                'dr_number' => $deliveryReceipt->dr_number,
                'amount' => $deliveryReceipt->amount,
                'balance' => $deliveryReceipt->balance,
                'salesOrder' => [
                    'id' => $deliveryReceipt->salesOrder->id,
                    'effectivity_date' => $deliveryReceipt->salesOrder->effectivity_date->format('M d, Y'),
                    'due_date' => $deliveryReceipt->salesOrder->due_date->format('M d, Y'),
                    'so_number' => $deliveryReceipt->salesOrder->so_number,
                    'discount' => '₱' . number_format($deliveryReceipt->salesOrder->discount ?? 0, 2),
                    'amount' => '₱' . number_format($deliveryReceipt->products()->sum('amount'), 2),
                    'net' => $deliveryReceipt->salesOrder->net,
                ],
            ];
        });            
        
        return response()->json($formattedResults);
    }    

}

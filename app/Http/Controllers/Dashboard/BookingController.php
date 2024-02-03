<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::query()    
                    ->with(['customer', 'agent'])
                    ->withCount(['products'])
                    ->latest()
                    ->paginate(12);

        return view("dashboard.booking.index", [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load(['approvals', 'products'])->loadCount(['products', 'approvals']);
        return view('dashboard.booking.show', [
            'booking' => $booking
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $products = $booking->products;

        $booking->status = 'Generated SO';
        $booking->save();

        $salesOrder = new SalesOrder();
        $salesOrder->customer_id = $booking->customer_id;
        $salesOrder->agent_id = $booking->agent_id;
        $salesOrder->added_by = $request->user()->id;
        $salesOrder->effectivity_date = $booking->created_at;
        $salesOrder->term = $booking->term;
        $salesOrder->amount = $booking->amount;
        $salesOrder->discount = $booking->discount;
        $salesOrder->net = $booking->net;
        $salesOrder->type = 'Booking';
        // $salesOrder->status = 'subject-for-approval';
        $salesOrder->save();

        foreach ($products as $product) {
            $pivotData = [
                'unit_price' => $product->pivot?->unit_price, 
                'quantity' => $product->pivot?->quantity,
                'discount' => $product->pivot?->discount,
                'amount' => $product->pivot?->amount,
            ];

            $salesOrder->products()->attach($product->id, $pivotData);
        }

        flash()->success('Sales Order generated successfully!');
        return redirect()->route('dashboard.sales-order.show', $salesOrder);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }
}

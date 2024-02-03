<?php

namespace App\Http\Controllers\Agent;

use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $customers = Customer::where("agent_id", $request->user()->id)
                        ->whereNotNull("verified_at")
                        ->get();
        $bookings = Booking::query()    
                        ->where("agent_id", $request->user()->id)
                        ->with(['customer'])
                        ->withCount(['products'])
                        ->latest()
                        ->paginate(12);

        return view("agent.booking.index", [
            'bookings' => $bookings,
            'customers' => $customers
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
        $this->validate($request, [
            'customer_id' => ['required', "exists:customers,id"]
        ]);

        $customer = Customer::find($request->customer_id);

        $booking = Booking::create([
            'customer_id'   => $request->customer_id,
            'term'          => $customer->terms, 
            'note'          => $request->note, 
            'agent_id'      => $request->user()->id
        ]);

        return redirect()->route("agent.booking.show", $booking);
    }

    function addProductForm(Request $request, Booking $booking){
        return view("agent.booking.add-product", [
            'booking' => $booking,
        ]);
    }
    
    function addProduct(Request $request, Booking $booking){
        $product = Product::findOrFail($request->product_id);
        $booking->products()->detach($request->product_id);
        $booking->products()->attach([$product->id => [
            'unit_price' => $request->unit_price,
            'quantity' => $request->quantity,
            'discount' => $request->discount,
            'amount' => $request->amount,
        ]]);

        flash()->success('Product Added');
        return redirect()->route("agent.booking.show", $booking);
    }


    function removeProduct(Request $request, Booking $booking) {
        $booking->products()->detach($request->product_id);
        flash()->success('Product removed!');
        return back();
    }


    function updateStatus(Request $request, Booking $booking){
        $booking->update(['status' => $request->status]);
        flash()->success('Booking is now subject for approval!');
        return back();
    }
    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $products = $booking->products;
        return view("agent.booking.show", [
            'products' => $products,
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }
}

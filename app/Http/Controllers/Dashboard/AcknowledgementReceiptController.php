<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AcknowledgementReceipt;
use App\Models\BankCheck;
use App\Models\DeliveryReceipt;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AcknowledgementReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $acknowledgementReceipts = AcknowledgementReceipt::with(['customer', 'user', 'payments', 'payments.deliveryReceipt', 'payments.deliveryReceipt.salesOrder'])
                                    ->latest()         
                                    ->paginate(30);

        return view('dashboard.acknowledgement_receipt.index', [
                'acknowledgementReceipts' => $acknowledgementReceipts
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'ar_number' => ['required', 'string', 'unique:acknowledgement_receipts,ar_number'],
            'date_issued' => ['required', 'date'],
            'mode_of_payment' => ['required', 'in:PDC,Cash,Online'],
            'type' => ['required', 'in:Acknowledgement Receipt,Counter Receipt']
        ]);
        
        $user_id = Auth::id();

        $acknowledgementReceipt = AcknowledgementReceipt::create([
            'user_id' => $user_id,
            'customer_id' => $validatedData['customer_id'],
            'ar_number' => $validatedData['ar_number'],
            'date_issued' => $validatedData['date_issued'],
            'mode_of_payment' => $validatedData['mode_of_payment'],
            'type' => $validatedData['type'],
            'status' => $validatedData['mode_of_payment']  == "PDC" ? AcknowledgementReceipt::DRAFT : AcknowledgementReceipt::COLLECTED
        ]);

        flash()->success('Acknowledgement Receipt Created!');
        return redirect()->route('dashboard.acknowledgement-receipt.show', $acknowledgementReceipt);
    }

    /**
     * Display the specified resource.
     */
    public function show(AcknowledgementReceipt $acknowledgementReceipt)
    {
        $acknowledgementReceipt->load(['approvals', 'payments', 'payments.bankChecks', 'payments.deliveryReceipt.bankChecks', 'payments.deliveryReceipt.salesOrder'])
                                 ->loadCount(['approvals', 'payments']);
        
        return view("dashboard.acknowledgement_receipt.show", [
            "acknowledgementReceipt"=> $acknowledgementReceipt
        ]);
    }

    public function addPayment(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $acknowledgementReceipt = AcknowledgementReceipt::find($request->input('acknowledgement_receipt_id'));
            $deliveryReceiptId = $request->input('delivery_receipt_id');
            $amount = $request->amount; // if in PDC - this is been a sum of PDCs amount in the front-end
            
            $deliveryReceipt = DeliveryReceipt::findOrFail($deliveryReceiptId);

            $payment = Payment::create([
                'acknowledgement_receipt_id' => $acknowledgementReceipt->id,
                'delivery_receipt_id' => $deliveryReceiptId,
                'amount' => $request->amount,
            ]);

            if($request->check_number){ // For PDC 
                foreach($request->check_number as $index => $value){
                    $bankCheck = new BankCheck([
                        'bank' => $request->bank[$index],
                        'number' => $request->check_number[$index],
                        'check_date' => $request->check_date[$index],
                        'amount' => $request->check_amount[$index],
                    ]);

                    $payment->bankChecks()->save($bankCheck);
                }
            }

            if($acknowledgementReceipt->mode_of_payment == "PDC") {
                // no update in amount since it is collected in the future
            }else{
                $deliveryReceipt->decrement('balance', $amount);
            }

            $acknowledgementReceipt->amount += $amount;
            $acknowledgementReceipt->save();
            
            DB::commit();
    
            flash()->success('Acknowledgement Receipt Payment Created!');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
    
            flash()->warning('Failed to create Acknowledgement Receipt Payment: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function deletePayment(AcknowledgementReceipt $acknowledgementReceipt, $item)
    {
        try {
            $pivotItem = $acknowledgementReceipt->deliveryReceipts()->wherePivot('delivery_receipt_id', $item)->first();

            if (!$pivotItem) {
                throw new \Exception('Payment not found');
            }

            DB::beginTransaction();

            $acknowledgementReceipt->amount -= $pivotItem->amount;
            $acknowledgementReceipt->save();

            $acknowledgementReceipt->deliveryReceipts()->detach($item);

            DB::commit();

            flash()->success('Acknowledgement Receipt payment deleted successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();

            flash()->error('Failed to delete Acknowledgement Receipt payment: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcknowledgementReceipt $acknowledgementReceipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcknowledgementReceipt $acknowledgementReceipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcknowledgementReceipt $acknowledgementReceipt)
    {
        //
    }
}

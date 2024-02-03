<?php

namespace App\Http\Controllers\Agent;

use App\Enums\CategoryEnum;
use App\Http\Controllers\Controller;
use App\Models\AcknowledgementReceipt;
use App\Models\Category;
use App\Models\Customer;
use App\Models\DeliveryReceipt;
use App\Traits\Controller\HasAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    use HasAttachment;

    
    public $model = Customer::class;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $customers = Customer::where('agent_id', Auth::user()->id)
                    ->paginate(10);

        $classifications = Category::where("type", CategoryEnum::CUSTOMER_CLASSIFICATION)->orderBy("name","ASC")->get();

        return view("agent.customer.index", [
            'customers' => $customers,
            'classifications' => $classifications,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classifications = Category::where("type", CategoryEnum::CUSTOMER_CLASSIFICATION)->orderBy("name","ASC")->get();

        return view("agent.customer.create", [
            'classifications' => $classifications,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => ['required', 'exists:categories,id'],
            'business_name' => ['required', 'string'],
            'owner' => ['required', 'string'],
            'tin_number' => ['required'],
            'contact_number' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:customers'],
            'area' => ['required', 'string'],
            'address' => ['required', 'string'],
            'credit_limit' => ['required'],
        ]);

        $customer = new Customer;
        $customer->added_by = $request->user()->id;
        $customer->agent_id = $request->user()->id;
        $customer->category_id = $request->category_id;
        $customer->business_name = $request->business_name;
        $customer->owner = $request->owner;
        $customer->tin_number = $request->tin_number;
        $customer->contact_number = $request->contact_number;
        $customer->email = $request->email;
        $customer->area = $request->area;
        $customer->address = $request->address;
        $customer->credit_limit = $request->credit_limit;
        $customer->terms = $request->terms;
        $customer->save();

        flash()->success('Customer added succesfully!');
        return redirect()->route("agent.customer.show", $customer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer, Request $request)
    {
        $customer->load(['agent', 'category', 'addedBy']);
        return match ($request->tab) {
            default => $this->requirementsTab($customer),
            'delivery-receipts' => $this->deliveryReceiptTab($customer, $request),
            'acknowledgement-receipt' => $this->acknowledgementReceipts($customer, $request),
            'product-list' => $this->productList($customer, $request)
        };
    }

    function deliveryReceiptTab(Customer $customer, Request $request){
        $deliveryReceipts = DeliveryReceipt::orderBy("created_at","desc")
                    ->with(['salesOrder', 'salesOrder.customer', 'user'])
                    ->whereRelation('salesOrder', 'customer_id', $customer->id)
                    ->when($request->q, function($q) use ($request) {
                        $q->where("dr_number", $request->q);
                    })
                    ->latest()
                    ->paginate(20);
                
        return view('agent.customer.show.delivery_receipt', [
            'customer' => $customer,
            'deliveryReceipts' => $deliveryReceipts
        ]);
    }

    function acknowledgementReceipts(Customer $customer, Request $request){

        $acknowledgementReceipts = AcknowledgementReceipt::with(['customer', 'user'])
                                    ->latest()
                                    ->where("customer_id", $customer->id)         
                                    ->paginate(30);

        return view('agent.customer.show.acknowledgement_receipt', [
            'customer' => $customer,
            'acknowledgementReceipts' => $acknowledgementReceipts
        ]);
    }

    function productList(Customer $customer, Request $request) {
        $products =  DB::table("products")
                ->join("delivery_receipt_product", "products.id", "=", "delivery_receipt_product.product_id")
                ->join("delivery_receipts", "delivery_receipt_product.delivery_receipt_id", "=", "delivery_receipts.id")
                ->join("sales_orders", "delivery_receipts.sales_order_id", "=", "sales_orders.id")
                ->selectRaw(DB::raw('products.description as product_description, products.id as product_id, delivery_receipt_product.unit_price as unit_price, delivery_receipts.id as delivery_receipt_id, delivery_receipts.dr_number as delivery_receipt_number, delivery_receipts.created_at as created_at'))
                ->where("sales_orders.customer_id", $customer->id)
                // ->groupBy("delivery_receipt_product.product_id")
                ->paginate(20);

        return view('agent.customer.show.product_list', [
            'customer' => $customer,
            'products' => $products
        ]);
    }

    function requirementsTab(Customer $customer){
        $customer->load("attachments");
        $types = Category::where("type", CategoryEnum::CUSTOMER_REQUIREMENT)->get();
        return view('agent.customer.show.requirement', [
            'customer' => $customer,
            'attachments' => $customer->attachments()->with(['category', 'user'])->paginate(),
            'types' => $types
        ]);
    }

  /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $classifications = Category::where("type", CategoryEnum::CUSTOMER_CLASSIFICATION)->orderBy("name","ASC")->get();
        return view('agent.customer.edit', [
            'customer' => $customer,
            'classifications' => $classifications,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $this->validate($request, [
            'category_id' => ['required', 'exists:categories,id'],
            'business_name' => ['required', 'string'],
            'owner' => ['required', 'string'],
            'tin_number' => ['required'],
            'contact_number' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:customers,email,'. $customer->id],
            'area' => ['required', 'string'],
            'address' => ['required', 'string'],
            'credit_limit' => ['required'],
        ]);

        $customer->agent_id = $request->agent_id;
        $customer->category_id = $request->category_id;
        $customer->business_name = $request->business_name;
        $customer->owner = $request->owner;
        $customer->tin_number = $request->tin_number;
        $customer->contact_number = $request->contact_number;
        $customer->email = $request->email;
        $customer->area = $request->area;
        $customer->address = $request->address;
        $customer->credit_limit = $request->credit_limit;
        $customer->terms = $request->terms;
        $customer->save();

        flash()->success('Customer details updated!');
        return redirect()->route("agent.customer.show", $customer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\CategoryEnum;
use App\Http\Controllers\Controller;
use App\Models\AcknowledgementReceipt;
use App\Models\Category;
use App\Models\Customer;
use App\Models\DeliveryReceipt;
use App\Models\DeliveryReceiptProductPivot;
use App\Models\ProductList;
use App\Models\SalesOrder;
use App\Models\User;
use App\Traits\Controller\HasAttachment;
use Illuminate\Http\Request;
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
        $query = Customer::query();

        if( $request->has("type") ){
            $query = $query->where("category_id", $request->type);
        }

        $customers = $query
                    ->with(['category', 'agent'])
                    ->paginate();

        $classifications = Category::where("type", CategoryEnum::CUSTOMER_CLASSIFICATION)->orderBy("name","ASC")->get();

        return view("dashboard.customer.index", [
            "customers" => $customers,
            "classifications" => $classifications
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agents = User::where("is_agent", 1)->orderBy("name","ASC")->get();
        $classifications = Category::where("type", CategoryEnum::CUSTOMER_CLASSIFICATION)->orderBy("name","ASC")->get();

        return view("dashboard.customer.create", [
            'agents' => $agents,
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
        $customer->agent_id = $request->agent_id;
        $customer->added_by = $request->user()->id;
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
        $customer->verified_at = now();
        $customer->verified_by = $request->user()->id;
        $customer->save();

        flash()->success('Customer added succesfully!');
        return redirect()->route("dashboard.customer.show", $customer);
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

        return view('dashboard.customer.show.delivery_receipt', [
            'customer' => $customer,
            'deliveryReceipts' => $deliveryReceipts
        ]);
    }

    function acknowledgementReceipts(Customer $customer, Request $request){

        $acknowledgementReceipts = AcknowledgementReceipt::with(['customer', 'user'])
                                    ->latest()
                                    ->where("customer_id", $customer->id)
                                    ->paginate(30);

        return view('dashboard.customer.show.acknowledgement_receipt', [
            'customer' => $customer,
            'acknowledgementReceipts' => $acknowledgementReceipts
        ]);
    }

    function productList(Customer $customer, Request $request) {

        $products = ProductList::where("customer_id", $customer->id)
                            ->has("product")
                            ->with(['product', 'deliveryReceipt'])
                            ->latest()
                            ->paginate(20);

        return view('dashboard.customer.show.product_list', [
            'customer' => $customer,
            'products' => $products
        ]);
    }

    function requirementsTab(Customer $customer){
        $customer->load("attachments");
        $types = Category::where("type", CategoryEnum::CUSTOMER_REQUIREMENT)->get();
        return view('dashboard.customer.show.requirement', [
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
        $agents = User::where("is_agent", 1)->orderBy("name","ASC")->get();
        $classifications = Category::where("type", CategoryEnum::CUSTOMER_CLASSIFICATION)->orderBy("name","ASC")->get();
        return view('dashboard.customer.edit', [
            'customer' => $customer,
            'agents' => $agents,
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
        return redirect()->route("dashboard.customer.show", $customer);
    }

    function verify(Request $request, Customer $customer){
        $customer->verified_at = now();
        $customer->verified_by = $request->user()->id;
        $customer->save();

        flash()->success('Customer verification success!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        flash()->success('Record Deleted!');
        return back()->with('delete', ' Record Deleted!');
    }
}

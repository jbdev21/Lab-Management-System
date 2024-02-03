@extends('dashboard.includes.layouts.app')

@section('page-title', $customer->business_name)

@section('content')
@include('dashboard.customer.includes.head')

<div class="card">
    @include('dashboard.customer.includes.tab')
    <div class="app-card-body p-4">
        <div class="text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalWithSelect2">
               <i class="fa fa-plus"></i> Add New
            </button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Lastest DR</th>
                    <th>Created</th>
                    <th>Last Updated</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $productList)
                    <tr>
                        <td>
                            <a href="{{ route("dashboard.product.show", $productList->product_id) }}">
                                {{ $productList->product->brand_name }} - {{ $productList->product->description }}
                            </a>
                        </td>
                        <td>{{ toPeso($productList->price) }}</td>
                        <td>
                            @if($productList->deliveryReceipt)
                                <a href="{{ route("dashboard.delivery-receipt.show", $productList->lastest_dr) }}">
                                    {{ $productList->deliveryReceipt->delivery_receipt_number }}
                                </a>
                            @endif
                        </td>
                        <td>{{ Carbon\Carbon::parse($productList->created_at)->format('M d, Y') }}</td>
                        <td>{{ Carbon\Carbon::parse($productList->updated_at)->format('M d, Y') }}</td>
                        <td class="text-end">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#productList-{{ $productList->id }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-pencil"></i></a>
                            
                            <!-- Modal -->
                            <div class="modal fade text-start" id="productList-{{ $productList->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route("dashboard.product-list.update", $productList) }}" method="POST">
                                            @csrf @method("PUT")
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Product Price</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Product</label>
                                                    <input type="text" readonly value="{{ $productList->product->brand_name }} - {{ $productList->product->description }}" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Price</label>
                                                    <input type="number" name="price"  value="{{ $productList->price }}" required step="0.5" min="1" class="form-control">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $productList->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                            <form id="delete-{{ $productList->id }}" action="{{ route('dashboard.product-list.destroy', $productList->id) }}" method="POST">@csrf @method('DELETE')</form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No Records</td>
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

        <!-- Modal -->
        <div class="modal fade" id="modalWithSelect2" tabindex="-1" aria-labelledby="modalWithSelect2Label" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route("dashboard.product-list.store") }}" method="POST">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalWithSelect2Label">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Product</label>
                            <select name="product_id" data-uri="/api/product/select2" required class="form-select select2-modal"></select>
                        </div>
                        <div class="mb-3">
                            <label>Price</label>
                            <input type="number" name="price" required step="0.5" min="1" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include("dashboard.includes.libraries.select2")

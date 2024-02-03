@extends('dashboard.includes.layouts.app')

@section('page-title', $product->description)

@section('content')
@include('dashboard.product.includes.head')

<div class="card">
    @include('dashboard.product.includes.tab')
    <div class="app-card-body p-4">
        <table class="table">
            <thead>
                <tr>
                    <th>Batch Code</th>
                    <th>Quantity</th>
                    <th>Manufactured</th>
                    <th>Expiration</th>
                    <th>Encoded By</th>
                    <th>Encoded Date</th>
                    <th>Status</th>
                    <th style="width:150px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stockHistory as $stock)
                    <tr>
                        <td>{{ $stock->batch_code }}</td>
                        <td>{{ $stock->quantity }}</td>
                        <td>{{  $stock->manufacture_date->format("Y-m-d") }}</td>
                        <td>{{  $stock->expiration_date->format("Y-m-d") }}</td>
                        <td>{{ $stock->user?->name }}</td>
                        <td>{{ $stock->created_at->diffForHumans() }}</td>
                        <td>
                            @if ($stock->status === 'expired_disposed')
                                <span class="btn-sm btn-danger py-0 btn text-white px-2">Expired/Disposed</span>
                            @elseif ($stock->status === 'near_expire')
                                <span class="btn-sm btn-warning py-0 btn text-white px-2">Near Expired</span>
                            @elseif ($stock->status === 'good_condition')
                                <span class="btn-sm btn-success py-0 btn text-white px-2">Good Condition</span>
                            @endif
                        </td>  
                        <td class="text-end">
                                <button type="button" class="btn-sm btn-primary py-0 btn text-white px-2" data-bs-toggle="modal" data-bs-target="#addQuantityModal{{ $stock->id }}">
                                    <i class="fa fa-plus"></i>
                                </button>

                                <!-- Add Quantity Modal -->
                                <div class="modal fade" id="addQuantityModal{{ $stock->id }}" tabindex="-1" role="dialog" aria-labelledby="addQuantityModalLabel{{ $stock->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content text-start">
                                            <!-- Add Quantity form -->
                                            <form action="{{ route('dashboard.stock.update', $stock->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add Stock Quantity</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Quantity input -->
                                                    <div class="form-group">
                                                        <label for="add-quantity">Quantity to Add:</label>
                                                        <input type="number" class="form-control" name="add_quantity" id="add-quantity" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary text-white">Add</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn-sm btn-danger py-0 btn text-white px-2" data-bs-toggle="modal" data-bs-target="#deductQuantityModal{{ $stock->id }}">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <!-- Deduct Quantity Modal -->
                                <div class="modal fade" id="deductQuantityModal{{ $stock->id }}" tabindex="-1" role="dialog" aria-labelledby="deductQuantityModalLabel{{ $stock->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content text-start">
                                            <!-- Deduct Quantity form -->
                                            <form action="{{ route('dashboard.stock.update', $stock->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Deduct Stock Quantity</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Quantity input -->
                                                    <div class="form-group">
                                                        <label>Quantity to Deduct:</label>
                                                        <input type="number" class="form-control" name="deduct_quantity" id="deduct-quantity" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger text-white">Deduct</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn-sm btn-info py-0 btn text-white px-2" data-bs-toggle="modal" data-bs-target="#updateStockModal{{ $stock->id }}">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <!-- Update Stock information Modal -->
                                <div class="modal fade" id="updateStockModal{{ $stock->id }}" tabindex="-1" role="dialog" aria-labelledby="updateStockModalLabel{{ $stock->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content text-start">
                                            <form action="{{ route('dashboard.stock.update', $stock->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Stock Information</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">                    
                                                    <div class="mb-3">
                                                        <label>Manufacture Date</label>
                                                        <input type="date" name="manufacture_date" class="form-control" value="{{ $stock->manufacture_date->format("Y-m-d") }}">
                                                    </div>                            
                                                    <div class="mb-3">
                                                        <label>Expiration</label>
                                                        <input type="date" name="expiration_date" class="form-control" value="{{ $stock->expiration_date->format("Y-m-d") }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Quantity</label>
                                                        <input type="number" name="quantity" class="form-control" value="{{ $stock->quantity }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success text-white">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $stock->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                <form id="delete-{{ $stock->id }}" action="{{ route('dashboard.stock.destroy', $stock->id) }}" method="POST">@csrf @method('DELETE')</form>
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="6">No Records Found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $stockHistory->appends([
                'q' => Request::get('q')
                ])
                ->links()
            }}
        </div>
    </div>
</div>
@endsection


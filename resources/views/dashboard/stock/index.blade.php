@extends('dashboard.includes.layouts.app')

@section('page-title', 'Stock')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Inventory</li>
        <li class="breadcrumb-item" aria-current="page">
            Stock
        </li>
    </ol>
</nav>
<div class="row gx-5 gy-3">
    <div class="col-lg-12">
        <div class="app-card shadow-sm mb-4 border-left-decoration">
            <div class="inner">
                <div class="app-card-body p-4">
                    <h4 class="text-success">Stock List</h4>
                    <div class="row">
                        <div class="col-lg-8">
                            <form>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Filter by Product, Batch, Quantity, Date...." name="q" value="{{ request('q') }}">
                                    <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                                    <a href="{{ route('dashboard.stock.index') }}" data-toggle="tooltip" title="Clear Filter" class="btn btn-secondary text-white" type="submit">
                                        <i class="fa fa-ban"></i>
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4 text-end">
                            <a href="{{ route('dashboard.stock.create') }}" class="btn btn-primary text-white">
                                Register Stock
                            </a>
                        </div>
                    </div>
                    {{ $stocks->appends([
                        'q' => Request::get('q'),
                        'perPage' => Request::get('perPage'),
                        ])
                        ->links()
                    }}
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Product Unit</th>
                                <th style="width: 200px;">Latest Batch</th>
                                <th style="width: 150px;"></th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stocks as $stock)
                                <tr>
                                    <td>
                                        <a href="{{ route('dashboard.product.show', $stock->product_id) }}">
                                            {{ $stock->brand_name }}
                                        </a>
                                    </td>
                                    <td>{{ $stock->unit }}</td>       
                                    <td>{{ $stock->latest_batch_code }}</td>            
                                    <td>{{ $stock->latest_created_at }}</td>            
                                    <td>{{ $stock->total_quantity }}</td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="7">No Records Found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $stocks->appends([
                        'q' => Request::get('q'),
                        'perPage' => Request::get('perPage'),
                        ])
                        ->links()
                    }}
                </div>
            </div>                            
        </div>
    </div>
</div>

@endsection

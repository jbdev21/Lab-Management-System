@extends('dashboard.includes.layouts.app')

@section('page-title', 'Acounts')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Inventory</li>
        <li class="breadcrumb-item active" aria-current="page">Product List</li>
        </ol>
    </nav>
    <div class="app-card shadow-sm mb-4 border-left-decoration">
        <div class="inner">
            <div class="app-card-body p-4">
                <div class="row gx-5 gy-3">
                    <div>
                        <div class="row">
                            <div class="col-lg-8">
                                <form>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search for Brand Name, Abbreviation, Type, Price...." name="q" value="{{ request('q') }}">
                                        <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                                        <a href="{{ route('dashboard.product.index') }}" data-toggle="tooltip" title="Clear Filter" class="btn btn-secondary text-white" type="submit">
                                            <i class="fa fa-ban"></i>
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-4 text-end">
                                <a href="{{ route('dashboard.product.create') }}" class="btn btn-primary text-white">
                                    Add New Product
                                </a>
                            </div>


                            {{ $products->appends([
                                'q' => Request::get('q'),
                                'perPage' => Request::get('perPage'),
                                ])
                                ->links()
                            }}
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Brand Name</th>
                                    <th>Abbreviation</th>
                                    <th>Description</th>
                                    <th>Unit</th>
                                    <th>Type</th>
                                    <th>SRP</th>
                                    <th>Latest Batch</th>
                                    <th></th>
                                    <th width="90px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td>
                                            <a href="{{ route('dashboard.product.show', $product->id) }}">
                                                {{ $product->brand_name }}
                                            </a>
                                        </td>
                                        <td>{{ $product->abbreviation }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>{{ $product->unit }}</td>
                                        <td>{{ $product->type }}</td>
                                        <td>{{ $product->formatted_retail_price }}</td>
                                        <td>{{ $product->stocks->first()?->batch_code }}</td>
                                        <td>{{ $product->created_at->format('M d, Y h:iA') }}</td>
                                        <td class="text-end">
                                            {{-- @can("update accounts") --}}
                                                <a href="{{ route('dashboard.product.edit', $product->id) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-pencil"></i></a>
                                            {{-- @endcan --}}
                                            {{-- @can("delete accounts") --}}
                                                <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $product->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                                <form id="delete-{{ $product->id }}" action="{{ route('dashboard.product.destroy', $product->id) }}" method="POST">@csrf @method('DELETE')</form>
                                            {{-- @endcan --}}
                                        </td>
                                    </tr>
                                    
                                @empty
                                    <tr class="text-center">
                                        <td colspan="11">No Records Found!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div style="margin-left: 20px;">
                            {{ $products->appends([
                                'q' => Request::get('q'),
                                'perPage' => Request::get('perPage'),
                                ])
                                ->links()
                            }}
                        </div>
                    </div><!--//col-->
                </div><!--//row-->
            </div><!--//app-card-body-->
        </div><!--//inner-->
    </div><!--//app-card-->
@endsection
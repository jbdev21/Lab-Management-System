@extends('dashboard.includes.layouts.app')

@section('page-title', 'Raw Material')

@section('content')
    <div class="row gx-5 gy-3">
        <div class="col-lg-6">
            <div class="app-card shadow-sm mb-4 border-left-decoration">
                <div class="inner">
                    <div class="app-card-body p-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                <li class="breadcrumb-item" aria-current="page">Inventory</li>
                                <li class="breadcrumb-item" aria-current="page">
                                    <a href="{{ route('dashboard.product.index') }}">Product</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Show Product</li>
                            </ol>
                        </nav>
            
                        <h2 class="text-success">Product Details</h2>
            
                        <div>
                            <h3>{{ $product->brand_name }}</h3>
                            <b>Description:</b> {{ $product->description }}<br>
                            <b>Unit:</b> {{ $product->unit }}<br>
                            <b>Type:</b> {{ $product->type }}<br>
                            <b>Factory Price:</b> {{ $product->formatted_factory_price }}<br>
                            <b>Dealer Price:</b> {{ $product->formatted_dealer_price }}<br>
                            <b>Farm Price:</b> {{ $product->formatted_farm_price }}
                        </div>
                    </div>
                </div>                            
            </div>
        </div>

        {{-- Customer History and latest Price Purchase --}}
        <div class="col-lg-6">
            <div class="app-card shadow-sm mb-4 border-left-decoration">
                <div class="inner">
                    <div class="app-card-body p-4">
                        <h2 class="text-success">Latest History of Customers Purchase</h2>
            
                        <div style="max-height: 600px; overflow-y: auto;">
                            <ul>
                                @php
                                    $faker = Faker\Factory::create();
                                @endphp

                                @for ($i = 1; $i <= 10; $i++)
                                    <li class="mt-2">
                                        <strong>{{ $faker->name }}</strong>
                                        <br>
                                        <span>Address: {{ $faker->address }}</span>
                                        <br>
                                        <span>Latest Purchase Price: $₱{{ rand(100, 999) }}</span>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>                            
            </div><!--//app-card-body-->
        </div><!--//inner-->
    </div><!--//app-card-->
@endsection
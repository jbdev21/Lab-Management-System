<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Inventory</li>
        <li class="breadcrumb-item" aria-current="page">
            <a href="{{ route('dashboard.product.index') }}">Product</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{ $product->brand_name }}</li>
    </ol>
</nav>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-4">
            <div>
                <h3>{{ $product->brand_name }}</h3>
                <b>Description:</b> {{ $product->description }}<br>
                <b>Unit:</b> {{ $product->unit }}<br>
                <b>Type:</b> {{ $product->type }}<br>
                <b>SRP:</b> {{ toPeso($product->retail_price) }}<br>
            </div>
        </div>
    </div>                            
</div>
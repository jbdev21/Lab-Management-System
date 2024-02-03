<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs" >
        <li class="nav-item">
            <a href="{{ route("dashboard.product.show", [$product, 'tab' => '']) }}" class="nav-link {{ Request::get('tab') == '' ? 'active' : '' }}">Stock History</a>
        </li>
        <li class="nav-item">
            <a href="{{ route("dashboard.product.show", [$product, 'tab' => 'delivery-receipts']) }}" class="nav-link {{ Request::get('tab') == 'delivery-receipts' ? 'active' : '' }}">Delivery Receipts</a>
        </li>
    </ul>
</div>
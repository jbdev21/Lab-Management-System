<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs" >
        {{-- @can('access project statistics') --}}
            <li class="nav-item">
                <a href="{{ route("dashboard.delivery-receipt.show", [$deliveryReceipt, 'tab' => '']) }}" class="nav-link {{ Request::get('tab') == '' ? 'active' : '' }}">Product</a>
            </li>
            <li class="nav-item">
                <a href="{{ route("dashboard.delivery-receipt.show", [$deliveryReceipt, 'tab' => 'acknowledgement-receipt']) }}" class="nav-link {{ Request::get('tab') == 'acknowledgement-receipt' ? 'active' : '' }}">Acknowledgement Receipts</a>
            </li>
        {{-- @endcan --}}
        
    </ul>
</div>
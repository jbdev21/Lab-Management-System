<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs" >
        {{-- @can('access project statistics') --}}
            <li class="nav-item">
                <a href="{{ route("dashboard.customer.show", [$customer, 'tab' => '']) }}" class="nav-link {{ Request::get('tab') == '' ? 'active' : '' }}">Documents</a>
            </li>
            <li class="nav-item">
                <a href="{{ route("dashboard.customer.show", [$customer, 'tab' => 'delivery-receipts']) }}" class="nav-link {{ Request::get('tab') == 'delivery-receipts' ? 'active' : '' }}">Delivery Receipts</a>
            </li>
            <li class="nav-item">
                <a href="{{ route("dashboard.customer.show", [$customer, 'tab' => 'acknowledgement-receipt']) }}" class="nav-link {{ Request::get('tab') == 'acknowledgement-receipt' ? 'active' : '' }}"> Acknowledgement Receipt</a>
            </li>
            <li class="nav-item">
                <a href="{{ route("dashboard.customer.show", [$customer, 'tab' => 'product-list']) }}" class="nav-link {{ Request::get('tab') == 'product-list' ? 'active' : '' }}"> Product List</a>
            </li>
        {{-- @endcan --}}
        
    </ul>
</div>
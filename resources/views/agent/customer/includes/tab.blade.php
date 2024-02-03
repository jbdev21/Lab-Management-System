<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs" >
        {{-- @can('access project statistics') --}}
            <li class="nav-item">
                <a href="{{ route("agent.customer.show", [$customer, 'tab' => '']) }}" class="nav-link {{ Request::get('tab') == '' ? 'active' : '' }}">Documents</a>
            </li>
            {{-- <li class="nav-item">
                <a href="{{ route("agent.customer.show", [$customer, 'tab' => 'delivery-receipts']) }}" class="nav-link {{ Request::get('tab') == 'delivery-receipts' ? 'active' : '' }}">DR</a>
            </li>
            <li class="nav-item">
                <a href="{{ route("agent.customer.show", [$customer, 'tab' => 'acknowledgement-receipt']) }}" class="nav-link {{ Request::get('tab') == 'acknowledgement-receipt' ? 'active' : '' }}"> AR</a>
            </li> --}}
            <li class="nav-item">
                <a href="{{ route("agent.customer.show", [$customer, 'tab' => 'product-list']) }}" class="nav-link {{ Request::get('tab') == 'product-list' ? 'active' : '' }}"> Products</a>
            </li>
        {{-- @endcan --}}
        
    </ul>
</div>
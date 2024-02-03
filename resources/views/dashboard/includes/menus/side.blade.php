<div id="app-sidepanel" class="app-sidepanel"> 
    <div id="sidepanel-drop" class="sidepanel-drop"></div>
    <div class="sidepanel-inner d-flex flex-column">
        <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
        <div class="app-branding">
            <a class="app-logo" href="index.html">
                <img  style="width:90%" src="/images/logo.png" alt="logo">
                {{-- <span class="logo-text text-success">Johnwealth Lab.</span> --}}
            </a>
        </div>
        <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
            <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.index') }}">
                        <span class="nav-icon">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-house-door" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5H9.5a.5.5 0 0 1-.5-.5v-4H7v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6zM2.5 7.707V14H6v-4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4h3.5V7.707L8 2.207l-5.5 5.5z"/>
                            <path fill-rule="evenodd" d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                        </svg>
                         </span>
                         <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>
                @can("manage booking")
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard.booking.index') }}">
                            <span class="nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-bookmark-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6 1h6v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z"/>
                                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                                  </svg>
                            </span>
                            <span class="nav-link-text">Booking</span>
                        </a>
                    </li>
                @endcan
                
                @can("manage sales order")
                    <li class="nav-item has-submenu">
                        <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#booking-menu" aria-expanded="false" aria-controls="booking-menu">
                            <span class="nav-icon">
                                <svg  width="1em" height="1em" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                                </svg>
                            </span>
                            <span class="nav-link-text">Sales</span>
                            <span class="submenu-arrow">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </a>
                        <div id="booking-menu" class="collapse submenu booking-menu {{ activeMenu(['customer', 'sales-order', 'delivery-receipt', 'price-request']) }}" data-bs-parent="#menu-accordion">
                            <ul class="submenu-list list-unstyled">
                                @can("manage sales order")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['sales-order'], true,  2, 'active') }}" href="{{ route("dashboard.sales-order.index") }}">Sales Order</a></li>
                                @endcan
                                @can("manage delivery receipt")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['delivery-receipt'], true,  2, 'active') }}" href="{{ route("dashboard.delivery-receipt.index") }}">Delivery Receipt</a></li>
                                @endcan
                                @can("manage price request")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['price-request'], true,  2, 'active') }}" href="{{ route("dashboard.price-request.index") }}">Price Request</a></li>
                                @endcan
                                @can("manage customer")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['customer'], true,  2, 'active') }}" href="{{ route("dashboard.customer.index") }}">Customer</a></li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
                
                @can("manage collection")
                    <li class="nav-item has-submenu">
                        <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-collection" aria-expanded="false" aria-controls="submenu-collection">
                            <span class="nav-icon">
                                <svg width="1em" height="1em" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                                </svg>
                            </span>
                            <span class="nav-link-text">Collection</span>
                            <span class="submenu-arrow">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </a>
                        <div id="submenu-collection" class="collapse submenu submenu-collection {{ activeMenu(['acknowledgement-receipt', 'bank-check', 'account-receivable']) }}" data-bs-parent="#menu-accordion">
                            <ul class="submenu-list list-unstyled">
                                @can("manage acknowledgement receipt")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['acknowledgement-receipt'], true,  2, 'active') }}" href="{{ route("dashboard.acknowledgement-receipt.index") }}">Acknowledgement Receipt</a></li>
                                @endcan
                                @can('manage account receivables')
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['account-receivable'], true,  2, 'active') }}" href="{{ route("dashboard.account-receivable.index") }}">Account Receivables</a></li>
                                @endcan
                                @can('manage bank check')
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['bank-check'], true,  2, 'active') }}" href="{{ route("dashboard.bank-check.index") }}">Bank Check</a></li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can("manage finance")
                    <li class="nav-item has-submenu">
                        <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-finance" aria-expanded="false" aria-controls="submenu-finance">
                            <span class="nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wallet" viewBox="0 0 16 16">
                                    <path d="M0 3a2 2 0 0 1 2-2h13.5a.5.5 0 0 1 0 1H15v2a1 1 0 0 1 1 1v8.5a1.5 1.5 0 0 1-1.5 1.5h-12A2.5 2.5 0 0 1 0 12.5zm1 1.732V12.5A1.5 1.5 0 0 0 2.5 14h12a.5.5 0 0 0 .5-.5V5H2a1.99 1.99 0 0 1-1-.268M1 3a1 1 0 0 0 1 1h12V2H2a1 1 0 0 0-1 1"/>
                                </svg>
                            </span>
                            <span class="nav-link-text">Finance</span>
                            <span class="submenu-arrow">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </a>
                        <div id="submenu-finance" class="collapse submenu submenu-collection {{ activeMenu(['ledger']) }}" data-bs-parent="#menu-accordion">
                            <ul class="submenu-list list-unstyled">
                                @can("manage ledger")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['ledger'], true,  2, 'active') }}" href="{{ route("dashboard.ledger.index") }}">Ledger</a></li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
                {{-- <li class="nav-item has-submenu">
                    <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-collection" aria-expanded="false" aria-controls="submenu-collection">
                        <span class="nav-icon">
                            <svg width="1em" height="1em" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journals" viewBox="0 0 16 16">
                                <path d="M5 0h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2 2 2 0 0 1-2 2H3a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1H1a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v9a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1H3a2 2 0 0 1 2-2z"/>
                                <path d="M1 6v-.5a.5.5 0 0 1 1 0V6h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V9h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 2.5v.5H.5a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1H2v-.5a.5.5 0 0 0-1 0z"/>
                            </svg>
                         </span>
                         <span class="nav-link-text">Finance</span>
                         <span class="submenu-arrow">
                             <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                            </svg>
                         </span>
                    </a>
                    <div id="submenu-collection" class="collapse submenu submenu-collection {{ activeMenu(['acknowledgement-receipt', 'bank-check', 'account-receivable']) }}" data-bs-parent="#menu-accordion">
                        <ul class="submenu-list list-unstyled">
                            <li class="submenu-item"><a class="submenu-link {{ activeMenu(['acknowledgement-receipt'], true,  2, 'active') }}" href="{{ route("dashboard.acknowledgement-receipt.index") }}">Acknowledgement Receipt</a></li>
                            <li class="submenu-item"><a class="submenu-link {{ activeMenu(['account-receivable'], true,  2, 'active') }}" href="{{ route("dashboard.account-receivable.index") }}">Account Receivables</a></li>
                            <li class="submenu-item"><a class="submenu-link {{ activeMenu(['bank-check'], true,  2, 'active') }}" href="{{ route("dashboard.bank-check.index") }}">Bank Check</a></li>
                            <li class="submenu-item"><a class="submenu-link {{ activeMenu(['ledger'], true,  2, 'active') }}" href="#">Ledger</a></li>
                      
                        </ul>
                    </div>
                </li> --}}
                @can('manage inventory')
                    <li class="nav-item has-submenu">
                        <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-2" aria-expanded="false" aria-controls="submenu-2">
                            <span class="nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                    <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                                </svg>
                            </span>
                            <span class="nav-link-text">Inventory</span>
                            <span class="submenu-arrow">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </a>
                        <div id="submenu-2" class="collapse submenu submenu-2 {{ activeMenu(['product','stock']) }}" data-bs-parent="#menu-accordion">
                            <ul class="submenu-list list-unstyled">
                                @can("manage stock")
                                    <li class="submenu-item"><a class="submenu-link  {{ activeMenu(['stock'], true,  2, 'active') }}" href="{{ route("dashboard.stock.index") }}">Stocks</a></li>
                                @endcan
                                @can("manage product list")
                                    <li class="submenu-item"><a class="submenu-link  {{ activeMenu(['product'], true,  2, 'active') }}" href="{{ route("dashboard.product.index") }}">Product List</a></li>
                                @endcan
                                {{-- @can('view stocks')
                                    <li class="submenu-item"><a class="submenu-link" href="{{ route("stock-history.index") }}">Stock History</a></li>
                                @endcan --}}
                            </ul>
                        </div>
                    </li>
                @endcan
                
                @can('manage purchase order')
                    <li class="nav-item has-submenu">
                        <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-purchaseOrder" aria-expanded="false" aria-controls="submenu-purchaseOrder">
                            <span class="nav-icon">
                                <svg width="1em" height="1em" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-check" viewBox="0 0 16 16">
                                    <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                            </span>
                            <span class="nav-link-text">Purchase Order</span>
                            <span class="submenu-arrow">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </a>
                        <div id="submenu-purchaseOrder" class="collapse submenu submenu-purchaseOrder {{ activeMenu(['purchase-order', 'deliver']) }}" data-bs-parent="#menu-accordion">
                            <ul class="submenu-list list-unstyled">
                                @can("manage purchase order")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['purchase-order'], true,  2, 'active') }}" href="{{ route("dashboard.purchase-order.index", ['type' => 'Others']) }}">List</a></li>
                                @endcan
                                @can("manage delivery")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['deliver'], true,  2, 'active') }}" href="{{ route("dashboard.deliver.index",) }}">Deliver List</a></li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('manage Purchase Order')
                    <li class="nav-item has-submenu">
                        <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-3" aria-expanded="false" aria-controls="submenu-3">
                            <span class="nav-icon">
                                <svg width="1em" height="1em" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                    <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                            </span>
                            <span class="nav-link-text">Raw Materials</span>
                            <span class="submenu-arrow">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </a>
                        <div id="submenu-3" class="collapse submenu submenu-3 {{ activeMenu(['raw-material', 'usage', 'purchase-order-raw-material']) }}" data-bs-parent="#menu-accordion">
                            <ul class="submenu-list list-unstyled">
                                @can("manage raw materials")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['raw-material'], true,  2, 'active') }}" href="{{ route("dashboard.raw-material.index") }}">List</a></li>
                                @endcan
                                @can('manage usage')
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['usage'], true,  2, 'active') }}" href="{{ route("dashboard.usage.index") }}">Usage</a></li>
                                @endcan
                                @can("manage purchase order")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['purchase-order-raw-material'], true,  2, 'active') }}" href="{{ route('dashboard.purchase.order.raw.material') }}">Purchased</a></li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('manage HR')
                    <li class="nav-item has-submenu">
                        <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#hr-menu" aria-expanded="false" aria-controls="hr-menu">
                            <span class="nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
                                </svg>
                            </span>
                            <span class="nav-link-text">HR management</span>
                            <span class="submenu-arrow">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </a>
                        <div id="hr-menu" class="collapse submenu submenu-3 {{ activeMenu(['employee', 'deduction', 'attendance','payslip', 'leave', 'deduction_employee']) }}" data-bs-parent="#menu-accordion">
                            <ul class="submenu-list list-unstyled">
                                @can("manage employee")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['employee'], true,  2, 'active') }}" href="{{ route("dashboard.employee.index") }}">Employee</a></li>
                                @endcan
                                @can("manage attendance")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['attendance'], true,  2, 'active') }}" href="{{ route('dashboard.attendance.index') }}">Attendance</a></li>
                                @endcan
                                @can("manage payslip")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['payslip'], true,  2, 'active') }}" href="{{ route('dashboard.payslip.index') }}">Payslip</a></li>
                                @endcan
                                @can("manage leaves")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['leave'], true,  2, 'active') }}" href="{{ route('dashboard.leave.index') }}">Leaves</a></li>
                                @endcan
                                @can("manage deductions")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['deduction'], true,  2, 'active') }}" href="{{ route("dashboard.deduction.index") }}">Deductions</a></li>
                                @endcan
                                @can("manage employee deductions")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['deduction_employee'], true,  2, 'active') }}" href="{{ route("dashboard.deduction_employee.index") }}">Deduction Employee</a></li>
                                @endcan
                                {{-- @can('view stocks')
                                    <li class="submenu-item"><a class="submenu-link" href="{{ route("stock-history.index") }}">Stock History</a></li>
                                @endcan --}}
                            </ul>
                        </div>
                    </li>
                @endcan
                
                @can("manage users")
                    <li class="nav-item has-submenu">
                        <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-6" aria-expanded="false" aria-controls="submenu-2">
                            <span class="nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                </svg>
                            </span>
                            <span class="nav-link-text">User manager</span>
                            <span class="submenu-arrow">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </a>
                        <div id="submenu-6" class="collapse submenu submenu-6 {{ activeMenu(['user', 'role', 'agent']) }}" data-bs-parent="#menu-accordion">
                            <ul class="submenu-list list-unstyled">
                                @can("manage agents")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['agent'], true,  2, 'active') }}" href="{{ route("dashboard.agent.index") }}">Agents</a></li>
                                @endcan
                                @can("manage users")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['user'], true,  2, 'active') }}" href="{{ route("dashboard.user.index") }}">Users</a></li>
                                @endcan
                                @can("manage roles")
                                    <li class="submenu-item"><a class="submenu-link {{ activeMenu(['role'], true,  2, 'active') }}" href="{{ route("dashboard.role.index") }}">Roles</a></li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
            </ul>
        </nav>
        
        @can("manage settings")
            <div class="app-sidepanel-footer mb-2">
                <nav class="app-nav app-nav-footer">
                    <ul class="app-menu footer-menu list-unstyled">
                        <li class="nav-item has-submenu">
                            <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-7" aria-expanded="false" aria-controls="submenu-2">
                                <span class="nav-icon">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-gear" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"/>
                                    <path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z"/>
                                </svg>
                                </span>
                                <span class="nav-link-text">Settings</span>
                                <span class="submenu-arrow">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                </span>
                            </a>
                            <div id="submenu-7" class="collapse submenu submenu-7 {{ activeMenu(['supplier', 'category', 'log', 'fund', 'department']) }}" data-bs-parent="#menu-accordion">
                                <ul class="submenu-list list-unstyled">
                                    @can('view categories')
                                        <li class="submenu-item"><a class="submenu-link {{ activeMenu(['category'], true,  2, 'active') }}" href="{{ route('dashboard.category.index') }}">Categories</a></li>
                                    @endcan
                                    @can("manage departments")
                                        <li class="submenu-item"><a class="submenu-link {{ activeMenu(['department'], true,  2, 'active') }}" href="{{ route('dashboard.department.index') }}">Department</a></li>
                                    @endcan
                                    @can("manage funds")
                                        <li class="submenu-item"><a class="submenu-link {{ activeMenu(['fund'], true,  2, 'active') }}" href="{{ route('dashboard.fund.index') }}">Funds</a></li>
                                    @endcan
                                    @can("manage suppliers")
                                        <li class="submenu-item"><a class="submenu-link {{ activeMenu(['supplier'], true,  2, 'active') }}" href="{{ route('dashboard.supplier.index') }}">Supplier</a></li>
                                    @endcan
                                    {{-- @can('view logs')
                                        <li class="submenu-item"><a class="submenu-link {{ activeMenu(['log'], true,  2, 'active') }}" href="{{ route('log.index') }}">Logs</a></li>
                                    @endcan --}}
                                </ul>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        @endcan
    </div>
</div>
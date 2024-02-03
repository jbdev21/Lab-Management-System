<div class="app-header-inner">  
    <div class="container-fluid py-2">
        <div class="app-header-content"> 
            <div class="row justify-content-between align-items-center">
            
            <div class="col-auto">
                <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img"><title>Menu</title><path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path></svg>
                </a>
            </div><!--//col-->
         
            
            <div class="app-utilities col-auto">
                <notification-component user="{{ Auth::user()->id }}" unread="{{ Auth::user()->unreadNotifications()->count() ?? 0 }}"></notification-component>			        
                {{-- <notification-component user="{{ Auth::user()->id }}" unread="100"></notification-component>	 --}}
                {{-- <top-notification-component></top-notification-component> --}}
                <div class="app-utility-item app-user-dropdown dropdown">
                    <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><img @if(Auth::user()->thumbnail) src="{{ Auth::user()->thumbnail }}" @endif alt="user profile" class="img-responsive rounded-circle"></a>
                    <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                        <li><a class="dropdown-item" href="{{ route("dashboard.profile.index") }}">Account</a></li>
                        {{-- <li><a class="dropdown-item" href="settings.html">Settings</a></li> --}}
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            {{-- <a class="dropdown-item" href="login.html">Log Out</a> --}}
                             <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div><!--//app-user-dropdown--> 
            </div><!--//app-utilities-->
        </div><!--//row-->
        </div><!--//app-header-content-->
    </div><!--//container-fluid-->
</div><!--//app-header-inner-->
   
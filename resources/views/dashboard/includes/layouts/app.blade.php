<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('dashboard.includes.sections.header')
    <body class="app @if(cache()->get('dark-mode-' . Auth::user()->id, 0)) dark @endif">
        <div id="overlay-box" class="d-flex aligns-items-center justify-content-center overlay text-center" style="padding-top:20%; border:1px solid red">
            <div class="spinner-border"  role="status">
              <span class="visually-hidden">Loading please wait...</span>
            </div>
            <h3 class="text-white ml-3">
                &nbsp;&nbsp;Processing...
            </h3>
        </div>
        <div id="app">
            <header class="app-header fixed-top">	
                @include('dashboard.includes.menus.top')
                @include('dashboard.includes.menus.side')
            </header>

            <div class="app-wrapper">
                <div class="app-content pt-3 p-md-3 p-lg-4">
                    <div class="container-fluid">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (flash()->message)
                            <div class="alert {{ flash()->class }} alert-dismissible fade show" role="alert">
                                {{ flash()->message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif 
                        @yield('content')
                    </div>
                </div>
                @include('dashboard.includes.sections.footer')
            </div>
        </div>
        @stack('scripts')
    </body>
</html>

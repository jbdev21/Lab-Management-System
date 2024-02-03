<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs" >
        {{-- @can('access project statistics') --}}
            <li class="nav-item">
                <a href="{{ route("dashboard.employee.show", [$employee, 'tab' => '']) }}" class="nav-link {{ Request::get('tab') == '' ? 'active' : '' }}">Attendances</a>
            </li>
            <li class="nav-item">
                <a href="{{ route("dashboard.employee.show", [$employee, 'tab' => 'payslip']) }}" class="nav-link {{ Request::get('tab') == 'payslip' ? 'active' : '' }}">Payslip Record</a>
            </li>
        {{-- @endcan --}}
        
    </ul>
</div>
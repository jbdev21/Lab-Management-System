<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">HR Management</li>
        <li class="breadcrumb-item active" aria-current="page">Employee Attendance</li>
    </ol>
</nav>
<div class="row gx-5 gy-3">
    <div class="col-lg-12">
         <div class="app-card shadow-sm mb-4 border-left-decoration">
             <div class="inner">
                 <div class="app-card-body p-4">
                     <div class="app-card">
                        <div class="row gx-1">
                            <div class="col-2">
                                <img @if(Auth::user()->thumbnail) src="{{ Auth::user()->thumbnail }}" @endif alt="user profile" class="img-responsive rounded-circle">
                            </div>
                            <div class="col-4">
                                <h3 class="user-name mb-1">{{ $employee->full_name }}</h3>
                                <h6 class="text-muted">{{ $employee->department?->name }}</h6>
                                <small class="text-muted">{{ $employee->department?->name }} Department</small>
                                <div class="mt-3">Employee ID | CODE : {{ $employee->code }}</div>
                                <div class="small text-muted">Date of Join : {{ $employee->created_at }}</div>
                                <a class="btn btn-sm btn-primary mt-3" href="{{ route('dashboard.employee.edit', $employee->id) }}">Update Profile</a>
                            </div>
                            <div class="col-4">
                                <ul>
                                    <li>
                                        <div class="text-info">Phone:</div>
                                        <div class="text"><a href="">9876543210</a></div>
                                    </li>
                                    <li>
                                        <div class="text-info">Email:</div>
                                        <div class="text"><a href="">{{ $employee->email }}</a></div>
                                    </li>
                                    <li>
                                        <div class="text-info">Birthday:</div>
                                        <div class="text">24th July</div>
                                    </li>
                                    <li>
                                        <div class="text-info">Rate Type:</div>
                                        <div class="text">{{ ucFirst($employee->rate_type) }}</div>
                                    </li>
                                    <li>
                                        <div class="text-info">Rate :</div>
                                        <div class="text">{{ toPeso($employee->rate) }}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                     </div>
                 </div>
             </div>
         </div>
    </div>
</div>
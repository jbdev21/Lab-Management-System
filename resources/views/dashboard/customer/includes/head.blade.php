<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Sales</li>
        <li class="breadcrumb-item" aria-current="page">
            <a href="{{ route('dashboard.customer.index') }}">Customers</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{ $customer->business_name }}</li>
    </ol>
</nav>
<div class="app-card alert alert-dismissible shadow-sm border-left-decoration">
    <div class="inner">
        <div class="app-card-body">
            <a class="btn app-btn-primary pull-right" href="{{ route("dashboard.customer.edit", $customer) }}" >
                <i class="fa fa-pencil"></i> Edit
            </a>
            @if(!$customer->verified)
                <form action="{{ route("dashboard.customer.verify", $customer) }}" method="POST" class="overlayed-form">
                    @csrf
                    <button type="button" class="btn btn-danger pull-right" onclick="if(confirm('Please make sure you verify all needed items. You want to proceed?')) { this.form.submit() }" >
                        <i class="fa fa-check-circle"></i> Verified
                    </button>
                </form>
            @endif
            <h3>{{ $customer->business_name }}</h3>
            <div class="row">
                <div class="col">
                    <table>
                        <tr>
                            <td>ASM</td>
                            <td class="fw-bold">: {{ $customer->agent?->name }}</td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td class="fw-bold">: {{ $customer->category?->name }}</td>
                        </tr>
                        <tr>
                            <td>Owner</td>
                            <td class="fw-bold">: {{ $customer->owner }}</td>
                        </tr>
                        <tr>
                            <td>Area</td>
                            <td class="fw-bold">: {{ $customer->area }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td class="fw-bold">: {{ $customer->address }}</td>
                        </tr>
                        <tr>
                            <td>TIN</td>
                            <td class="fw-bold">: {{ $customer->tin_number }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col">
                    <table>
                        <tr>
                            <td>Email</td>
                            <td class="fw-bold">: {{ $customer->email }}</td>
                        </tr>
                        <tr>
                            <td>Contact Number</td>
                            <td class="fw-bold">: {{ $customer->contact_number }}</td>
                        </tr>
                        
                        <tr>
                            <td>Terms</td>
                            <td class="fw-bold">: {{ $customer->terms }}</td>
                        </tr>
                        <tr>
                            <td>Credit Limit</td>
                            <td class="fw-bold">: {{ $customer->credit_limit }}</td>
                        </tr>
                        <tr>
                            <td>Added By</td>
                            <td class="fw-bold">: {{ $customer->addedBy?->name }}</td>
                        </tr>
                        <tr>
                            <td>Added/Updated</td>
                            <td class="fw-bold">: {{ $customer->created_at->format("Y-m-d h:iA") }} / {{ $customer->updated_at->format("Y-m-d h:iA") }} </td>
                        </tr>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
@extends('dashboard.includes.layouts.app')

@section('page-title', 'Customer')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item" aria-current="page">Booking</li>
      <li class="breadcrumb-item active" aria-current="page">Customers</li>
    </ol>
  </nav>
    <div class="app-card shadow-sm mb-4 border-left-decoration">
        <div class="inner">
            <div class="app-card-body p-4">
                <form>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search for Username, Name, Position...." name="q">
                                <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            {{-- <select class="form-select" name="status">
                                <option value=""">All Status</option>
                                <option value="1" @if(Request::get('status') == '1') selected @endif>Active</option>
                                <option value="0" @if(Request::get('status') == '0') selected @endif>Non-Active</option>
                            </select> --}}
                        </div>
                        <div class="col-lg-4 text-end">
                            <a class="btn btn-success text-white" href="{{ route("dashboard.customer.create") }}"><i class="fa fa-plus"></i> Add Customer</a>
                        </div>
                    </div>
                </form>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Business Name</th>
                            <th>Owner</th>
                            <th>Area</th>
                            <th>Contact Number</th>
                            <th>TIN</th>
                            <th>Updated</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr>
                                <td>
                                    <a href="{{ route("dashboard.customer.show", $customer) }}">
                                        {{ $customer->business_name }}
                                    </a>
                                </td>
                                <td>{{ $customer->owner }}</td>
                                <td>{{ $customer->area }}</td>
                                <td>{{ $customer->contact_number }}</td>
                                <td>{{ $customer->tin_number }}</td>
                                <td>
                                    <span title="{{ $customer->updated_at->format('M d, Y - h:i A') }}">
                                        {{ $customer->updated_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    @can("update accounts")
                                        <a href="{{ route('dashboard.customer.show', $customer) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-eye"></i></a>
                                    @endcan
                                    @can("delete accounts")
                                        <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $customer->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                        <form id="delete-{{ $customer->id }}" action="{{ route('dashboard.customer.destroy', $customer->id) }}" method="POST">@csrf @method('DELETE')</form>
                                    @endcan
                                </td>
                            </tr>
                            
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No Records</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="margin-left: 20px;">
                    {{ $customers->appends([
                        'q' => Request::get('q')
                        ])
                        ->links()
                    }}
                </div>
                
            
            </div>
        </div>
    </div>
@endsection
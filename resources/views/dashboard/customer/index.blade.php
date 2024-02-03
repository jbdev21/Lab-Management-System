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
            <div class="app-card-body p-3">
                <h4 class="text-success mb-3">Customer</h4>
                <form>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search for Username, Name, Position...." name="q">
                                <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <select class="form-select mb-3" name="type">
                                <option value="">All Type</option>
                                @foreach($classifications as $classification)
                                    <option value="{{ $classification->id }}" @if(Request::get('type') == $classification->id) selected @endif>{{ $classification->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 text-end">
                            <a class="btn btn-success text-white" href="{{ route("dashboard.customer.create") }}"><i class="fa fa-plus"></i> Add Customer</a>
                        </div>
                    </div>
                </form>
                <div>
                    {{ $customers->appends([
                        'q' => Request::get('q')
                        ])
                        ->links()
                    }}
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:20px"></th>
                            <th>Business Name</th>
                            <th>Owner</th>
                            <th>Classification</th>
                            <th>Area</th>
                            {{-- <th>Email</th>
                            <th>Contact Number</th>
                            <th>TIN</th> --}}
                            <th>Terms</th>
                            <th>ASM</th>
                            <th>Updated</th>
                            <th style="width:120px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr>
                                <td>
                                    @if($customer->verified)
                                        <i class="fa fa-check-circle text-primary"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route("dashboard.customer.show", $customer) }}">
                                        {{ $customer->business_name }}
                                    </a>
                                </td>
                                <td>{{ $customer->owner }}</td>
                                <td>{{ $customer->category?->name }}</td>
                                <td>{{ $customer->area }}</td>
                                {{-- <td>{{ $customer->email }}</td>
                                <td>{{ $customer->contact_number }}</td>
                                <td>{{ $customer->tin_number }}</td> --}}
                                <td>{{ $customer->terms }}</td>
                                <td>{{ $customer->agent?->name }}</td>
                                <td>
                                    <span title="{{ $customer->updated_at->format('M d, Y - h:i A') }}">
                                        {{ $customer->updated_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('dashboard.customer.show', $customer) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-eye"></i></a>
                                
                                    <a href="{{ route('dashboard.customer.edit', $customer) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-pencil"></i></a>
                                
                                    <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $customer->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                    <form id="delete-{{ $customer->id }}" action="{{ route('dashboard.customer.destroy', $customer->id) }}" method="POST">@csrf @method('DELETE')</form>
                                
                                </td>
                            </tr>
                            
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No Records</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
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
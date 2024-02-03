@extends('dashboard.includes.layouts.app')

@section('page-title', 'Funds')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Setting</li>
        <li class="breadcrumb-item active" aria-current="page">Funds</li>
    </ol>
</nav>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-4">
            <div class="row gx-5 gy-3">
                @can('create categories')
                    <div class="col-lg-4">
                        <div class="app-card mb-4">
                            <div class="app-card-body">
                                <form action="{{ route('dashboard.fund.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="">Type *</label>
                                        <select name="type" class="form-select">
                                            @foreach($types  as $type)
                                                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Name *</label>
                                        <input type="text" class="form-control mb-2" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Acccount Name *</label>
                                        <input type="text" class="form-control mb-2" name="account_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Reference/Number</label>
                                        <input type="text" class="form-control mb-2" name="reference">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Initial Amount *</label>
                                        <input type="number" step=".01" min="0" value="0" class="form-control mb-2" name="amount" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Other Details</label>
                                        <textarea type="text" class="form-control mb-2" name="details"></textarea>
                                    </div>
                                
                                    <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Save</button>
                                </form>
                            </div>
                        </div>
                    </div><!--//col-->
                @endcan

                <div class="col-lg-8">
                    <form>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <select data-filtering-select="true" name="type" class="form-select">
                                    <option value="">All</option>
                                    @foreach($types  as $type)
                                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Account Name</th>
                                <th>Reference</th>
                                <th>Current Amount</th>
                                <th>Other Details</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($funds as $fund)
                                <tr>
                                    <td>{{ ucfirst($fund->type) }}</td>
                                    <td>{{ $fund->name }}</td>
                                    <td>{{ $fund->account_name }}</td>
                                    <td>{{ $fund->reference }}</td>
                                    <td>{{ toPeso($fund->amount) }}</td>
                                    <td>{{ $fund->details }}</td>
                                    <td class="text-end">
                                            <a href="{{ route('dashboard.fund.show', $fund->id) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-eye"></i></a>
                                            <a href="{{ route('dashboard.fund.edit', $fund->id) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-pencil"></i></a>
                                        
                                            <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $fund->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                            <form id="delete-{{ $fund->id }}" action="{{ route('dashboard.fund.destroy', $fund->id) }}" method="POST">@csrf @method('DELETE')</form>
                                    
                                    </td>
                                </tr>
                                
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Records</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div style="margin-left: 20px;">
                        {{ $funds->appends([
                            'q' => Request::get('q'),
                            ])
                            ->links()
                        }}
                    </div>
                </div><!--//col-->
            </div><!--//row-->
        </div><!--//app-card-body-->
    </div><!--//inner-->
</div><!--//app-card-->
@endsection
@extends('dashboard.includes.layouts.app')

@section('page-title', 'Raw Material')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page"> Raw Material</li>
        <li class="breadcrumb-item" aria-current="page">
            List
        </li>
    </ol>
</nav>
<div class="row gx-5 gy-3">
    <div class="col-lg-12">
        <div class="app-card shadow-sm mb-4 border-left-decoration">
            <div class="inner">
                <div class="app-card-body p-4">
                    <h4 class="text-success">Raw Materials List</h4>
                    <div class="row">
                        <div class="col-lg-8">
                            <form>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search for Code, Name, Quantity, Unit...." name="q" value="{{ request('q') }}">
                                    <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                                    <a href="{{ route('dashboard.raw-material.index') }}" data-toggle="tooltip" title="Clear Filter" class="btn btn-secondary text-white" type="submit">
                                        <i class="fa fa-ban"></i>
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4 text-end">
                            <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#addNewRawMaterial">
                                <i class="fa fa-plus"></i> Add New Raw Material
                             </button>
                        </div>
                    </div>
                    {{ $rawMaterials->appends([
                        'q' => Request::get('q'),
                        'perPage' => Request::get('perPage'),
                        ])
                        ->links()
                    }}
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rawMaterials as $rawMaterial)
                                <tr>
                                    <td>{{ $rawMaterial->code }}</td>
                                    <td>{{ $rawMaterial->name }}</td>
                                    <td>{{ $rawMaterial->quantity }}</td>
                                    <td>{{ $rawMaterial->unit }}</td>
                                    <td class="text-end">
                                        {{-- @can("update accounts") --}}
                                        <a href="{{ route('dashboard.raw-material.edit', $rawMaterial->id) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-pencil"></i></a>
                                        {{-- @endcan --}}
                                        {{-- @can("delete accounts") --}}
                                            <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $rawMaterial->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                            <form id="delete-{{ $rawMaterial->id }}" action="{{ route('dashboard.raw-material.destroy', $rawMaterial->id) }}" method="POST">@csrf @method('DELETE')</form>
                                        {{-- @endcan --}}
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="5">No Records Found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $rawMaterials->appends([
                        'q' => Request::get('q'),
                        'perPage' => Request::get('perPage'),
                        ])
                        ->links()
                    }}
                </div>
            </div>                            
        </div><!--//app-card-body-->
    </div><!--//inner-->
</div><!--//app-card-->

<div class="modal fade" id="addNewRawMaterial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dashboard.raw-material.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Raw Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="code">Code</label>
                        <input type="text" class="form-control mb-2" name="code" value="{{ old('code') }}">
                    </div>
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control mb-2" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="quantity">Quantity <small>**can have decimal value.</small></label>
                        <input type="number" step="0.01" class="form-control mb-2" name="quantity" value="{{ old('quantity') }}">
                    </div>
                    <div class="mb-3">
                        <label for="unit">Unit</label>
                        <input type="text" class="form-control mb-2" name="unit" value="{{ old('unit') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                    <button type="submit" class="btn btn-primary text-white"><i class="fa fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

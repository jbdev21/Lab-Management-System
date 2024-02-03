@extends('dashboard.includes.layouts.app')

@section('page-title', 'Deductions')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">HR Management</li>
        <li class="breadcrumb-item active" aria-current="page">Deductions</li>
    </ol>
</nav>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-4">
            <div class="row gx-5 gy-3">
                    <div class="col-lg-4">
                        <div class="app-card mb-4">
                            <div class="app-card-body">
                                <form action="{{ route('dashboard.deduction.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="">Name</label>
                                        <input type="text" class="form-control mb-2" name="name" required>
                                    </div>
                                
                                    <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Save</button>
                                </form>
                            </div>
                        </div>
                    </div><!--//col-->

                <div class="col-lg-8">
                    <form>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search for name" value="{{ Request::get("q") }}" name="q">
                                    <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deductions as $deduction)
                                <tr>
                                    <td>{{ $deduction->name }}</td>
                                    
                                    <td class="text-end">
                                            <a href="{{ route('dashboard.deduction.edit', $deduction->id) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-pencil"></i></a>
                                  
                                            <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $deduction->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                            <form id="delete-{{ $deduction->id }}" action="{{ route('dashboard.deduction.destroy', $deduction->id) }}" method="POST">@csrf @method('DELETE')</form>
                                   
                                    </td>
                                </tr>
                                
                            @empty
                                <tr>
                                    <td colspan="3">No Records</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div style="margin-left: 20px;">
                        {{ $deductions->appends([
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
@extends('dashboard.includes.layouts.app')

@section('page-title', 'Sales Order')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item" aria-current="page">Raw Material</li>
      <li class="breadcrumb-item active" aria-current="page">Usage</li>
    </ol>
  </nav>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h4 class="text-success mb-3">Raw Material Usage</h4>
            <form>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search.." name="q">
                            <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-8 text-end">
                        <button type="button" class="btn btn-primary text-white pull-right mb"  data-bs-toggle="modal" data-bs-target="#addRawMats">
                            <i class="fa fa-plus"></i> Add Raw Mats. Used
                        </button>
                    </div>
                </div>
            </form>
            <div>
                {{ $usages->appends([
                        'q' => Request::get('q')
                    ])
                    ->links()
                }}
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Usage Date</th>
                        <th>Note</th>
                        <th>Created By</th>
                        <th>Created at</th>
                        <th style="width:150px"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usages as $usage)
                        <tr>
                            <td>
                                <a href="{{ route("dashboard.usage.show", $usage) }}">
                                {{ $usage->date->format("M d, Y - l") }}
                                </a>
                            </td>
                            <td>{{ $usage->note }}</td>
                            <td>{{ $usage->user?->name }}</td>
                            <td>
                                <span title="{{ $usage->updated_at->format('M d, Y - h:i A') }}">
                                    {{ $usage->updated_at->diffForHumans() }}
                                </span>
                            </td>
                            <td>
                                <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $usage->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2 pull-right"><i class="fa fa-trash"></i></a>
                                <form id="delete-{{ $usage->id }}" action="{{ route('dashboard.usage.destroy', $usage->id) }}" method="POST">@csrf @method('DELETE')</form>

                                <a data-bs-toggle="modal" data-bs-target="#updateRawMats-{{ $usage->id }}" class="btn-sm btn-primary py-0 btn text-white px-2 pull-right"> <i class="fa fa-pencil"></i></a>
                                 <!-- Modal update Usage-->
                                <div class="modal fade" id="updateRawMats-{{ $usage->id }}" tabindex="-1" aria-labelledby="updateRawMatsLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                            <form action="{{ route("dashboard.usage.update", $usage->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateRawMatsLabel">Update Raw Masterial Usage</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="quantityInput" class="form-label">Effectivity Date/ Daily Date<span class="text-danger">*</span></label>
                                                        <input type="date" value="{{ $usage->date?->format("Y-m-d") }}" name="date" required class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="quantityInput" class="form-label">Note</label>
                                                        <textarea class="form-control" rows="5" name="note">{{ $usage->note }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary text-white">
                                                        <i class="fa fa-arrow-right"></i>
                                                        Procceed</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No Records</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{ $usages->appends([
                    'q' => Request::get('q')
                    ])
                    ->links()
                }}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addRawMats" tabindex="-1" aria-labelledby="addRawMatsLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
            <form action="{{ route("dashboard.usage.store") }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addRawMatsLabel">Raw Masterial Usage</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="quantityInput" class="form-label">Effectivity Date/ Daily Date<span class="text-danger">*</span></label>
                        <input type="date" value="{{ date("Y-m-d") }}" max="{{ date("Y-m-d") }}" name="date" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="quantityInput" class="form-label">Note</label>
                        <textarea class="form-control" rows="5" name="note"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary text-white">
                        <i class="fa fa-arrow-right"></i>
                        Procceed</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@include("dashboard.includes.libraries.select2")


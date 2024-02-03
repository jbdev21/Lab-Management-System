@extends('dashboard.includes.layouts.app')

@section('page-title', 'Raw Material')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">Raw Material</li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('dashboard.usage.index') }}">Usage</a></li>
        <li class="breadcrumb-item active" aria-current="page">Usage Date: {{ $usage->date->format('M d, Y') }}</li>
    </ol>
</nav>
<div class="app-card shadow-sm mb-2 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h3>{{ $usage->date?->format('M d, Y - l') }}</h3>
            <table>
                <tr>
                    <td>Created By:</td>
                    <td class="fw-bold">: {{ $usage->user?->name }}</td>
                </tr>
                <tr>
                    <td>Note</td>
                    <td class="fw-bold">: {{ $usage->note }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <div class="row"> 
                @if($usage->is_submitted == false)
                <div class="col-sm-4">
                    <form action="{{ route("dashboard.usage.add.item") }}" method="POST">
                        @csrf
                        <input type="hidden" name="usage_id" value="{{ $usage->id }}">
                        <usage-raw-material-input></usage-raw-material-input>
                    </form>
                </div>
                @endif
                <div class="@if($usage->is_submitted == false) col-sm-8 @else col-sm-12 @endif">
                        <table class="table">
                            <thead>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th style="width:150px">Quantity</th>
                                @if($usage->is_submitted == false)
                                    <th style="width:100px">Action</th>
                                @endif
                            </thead>
                            <tbody>
                                @forelse ($usage->rawMaterials as $rawMaterialUsage)
                                    <tr data-usage-id="{{ $usage->id }}" data-raw-material-id="{{ $rawMaterialUsage->id }}">
                                        <td>
                                            {{ $rawMaterialUsage->code }}
                                            <input type="hidden" name="raw_material_id[{{ $rawMaterialUsage->id }}]" value="{{ $rawMaterialUsage->id }}">
                                        </td>
                                        <td>{{ $rawMaterialUsage->name }}</td>
                                        <td>{{ $rawMaterialUsage->unit }}</td>
                                        <td>
                                            @if($usage->is_submitted == false)
                                            <input type="number" class="form-control quantity-input"
                                                                step="0.1"
                                                                min="1"
                                                                data-usage-id="{{ $usage->id }}" 
                                                                data-raw-material-id="{{ $rawMaterialUsage->id }}" 
                                                                value="{{ $rawMaterialUsage->pivot->quantity }}"
                                                                @if($usage->is_submitted == true) disabled @endif>
                                            @else
                                                {{ $rawMaterialUsage->pivot->quantity }}
                                            @endif
                                        </td>
                                        @if($usage->is_submitted == false)
                                            <td>
                                                <button class="btn-sm btn-danger py-0 btn text-white px-2 delete-item"
                                                    data-usage-id="{{ $usage->id }}" 
                                                    data-raw-material-id="{{ $rawMaterialUsage->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No items</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="text-end">
                            @if($usage->is_submitted == false)
                                <a href="{{ route('dashboard.usage.deduct.quantity.rawMaterial', $usage->id) }}" 
                                    class="btn btn-primary text-white mt-3" 
                                    onclick="return confirm('Are you sure you want to submit?')">
                                    <i class="fa fa-save"></i> Submit
                                </a>
                            @else
                                <i class="text-danger">*Raw materials quantity has already been submitted**</i>
                            @endif
                        </div>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('.quantity-input').on('change', function() {
            var newValue = $(this).val();
            var rawMaterialId = $(this).data('raw-material-id');
            var usageId = $(this).data('usage-id');

            var data = {
                raw_material_id: rawMaterialId,
                new_value: newValue,
                usage_id: usageId
            };

            $.ajax({
                url: '{{ route('api.raw-material.update') }}',
                method: 'POST',
                data: data,
                success: function(response) {
                    toastr.info('Raw Material Quantity update successfully!');
                },
                error: function(response) {
                    toastr.danger('Failed to update!');
                }
            });
        });

        $('.delete-item').on('click', function() {
            var usageId = $(this).data('usage-id');
            var rawMaterialId = $(this).data('raw-material-id');

            var confirmed = window.confirm('Are you sure you want to delete this item?');

            if (confirmed) {
                $.ajax({
                    url: '{{ route('api.raw-material.delete') }}',
                    method: 'DELETE',
                    data: {
                        usage_id: usageId,
                        raw_material_id: rawMaterialId
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            toastr.error('Delete failed');
                        }
                    },
                    error: function(response) {
                        toastr.error('Delete failed');
                    }
                });
            }
        });
    });
</script>
@endpush


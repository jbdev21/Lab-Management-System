@extends('dashboard.includes.layouts.app')

@section('page-title', 'Employee Leave')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('dashboard.leave.index') }}">Leave List</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $leave->employee?->full_name }}</li>
    </ol>
</nav>
<div class="app-card shadow-sm mb-2 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h3>Employee Leave Information</h3>
            <div class="row">
                <div class="col-sm-4">
                    <table>
                        <tr>
                            <td>Employee</td>
                            <td class="fw-bold">: {{ $leave->employee?->full_name }}</td>
                        </tr>
                        <tr>
                            <td>Leave Type</td>
                            <td class="fw-bold">: {{ $leave->category?->name }}</td>
                        </tr>
                        <tr>
                            <td>Date From</td>
                            <td class="fw-bold">: {{ $leave->date_from?->format('F d, Y') }}</td>
                        </tr>
                        <tr>
                            <td>Date To</td>
                            <td class="fw-bold">: {{ $leave->date_to->format("F d, Y") }}</td>
                        </tr>
                        <tr>
                            <td>No. of Days</td>
                            <td class="fw-bold">: {{ $leave->no_days }}</td>
                        </tr>
                        <tr>
                            <td>Remain Paid Leaves</td>
                            <td class="fw-bold">: {{ $leave->employee?->paid_leave }}</td>
                        </tr>
                        <tr>
                            <td>Is Paid:</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_paid" disabled {{ $leave->is_paid ? 'checked' : '' }}>
                                    <label class="form-check-label text-black" for="is_paid">{{ $leave->is_paid ? 'Yes' : 'No' }}</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Details</td>
                            <td class="fw-bold">: {{ $leave->details }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-8">
                    <div class="mb-2">
                        <h6>Approvals</h6>
                    </div>
                    <table class="table mt-1 mb-4">
                        <tr>
                            <td>Name</td>
                            <td>Department</td>
                            <td>Date/Time</td>
                            <td>Note</td>
                            <td></td>
                        </tr>
                        @forelse($leave->approvals as $approval)
                            <tr>
                                <td>{{ $approval->user?->name }}</td>
                                <td>-</td>
                                <td>{{ $approval->created_at->format("Y-m-d h:iA") }}</td>
                                <td>{{ $approval->note }}</td>
                                <td class="text-end">
                                    @can("manage approval")
                                        <a href="#" class="btn-sm btn-danger py-0 btn text-white px-2 delete-button" >Revoke</a>
                                        <form action="{{ route("dashboard.approval.destroy", $approval->id) }}">@csrf @method('DELETE')</form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center"> No approval</td>
                            </tr>
                        @endforelse
                    </table>
                    <div class="text-end">
                        @can("manage approval")
                            @if(!in_array(Auth::user()->id, $leave->approvals()->pluck('user_id')->toArray()))
                                <button type="button" class="btn-success btn" data-bs-toggle="modal" data-bs-target="#approvalFormModal">
                                    <i class="fa fa-check"></i> Approve
                                </button>
                            @endif
                        @endcan
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="approvalFormModal" tabindex="-1" role="dialog" aria-labelledby="approvalFormModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-start">
            <form action="{{ route("dashboard.approval.store") }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Approval Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $leave->id }}">
                    <input type="hidden" name="model" value="{{ Leave::class }}">
                    <div class="mb-3">
                        <label>Employee Leave</label>
                        <input type="text" readonly class="form-control" value="{{ $leave->employee?->full_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Leave Type</label>
                        <input type="text" readonly class="form-control" value="{{ $leave->category?->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Note</label>
                        <textarea name="note" style="height: 80px" class="form-control" placeholder="optional..">{{ $leave->note }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success text-white">Approve Employee Leave</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection


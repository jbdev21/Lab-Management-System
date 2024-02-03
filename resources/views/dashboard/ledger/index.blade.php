@extends('dashboard.includes.layouts.app')

@section('page-title', 'Ledger')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item" aria-current="page">Finance</li>
      <li class="breadcrumb-item active" aria-current="page">Ledger</li>
    </ol>
  </nav>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3">
            <h4 class="text-success mb-3">Ledger</h4>
            <form>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search particulars" name="q">
                            <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <select name="fund" class="form-select select-change-submit">
                            <option value=""> All Funds</option>
                            @foreach($funds as $fund)
                                <option @selected(Request::get("fund") == $fund->id) value="{{ $fund->id }}">
                                    {{ $fund->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <select name="department" class="form-select select-change-submit">
                            <option value=""> All Departments</option>
                            @foreach($departments as $department)
                                <option @selected(Request::get("department") == $department->id) value="{{ $department->id }}">
                                    {{ Str::title(str_replace("_", " ", $department->name)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
            <div>
                {{ $ledgers->appends([
                        'q' => Request::get('q')
                    ])
                    ->links()
                }}
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Funds</th>
                        <th style="width: 40%">Particulars</th>
                        <th>User</th>
                        <th>Department</th>
                        <th>Date/Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ledgers as $ledger)
                        <tr>
                            <td>{{ str()->upper($ledger->type) }}</td>
                            <td>{{ toPeso($ledger->amount) }}</td>
                            <td>{{ $ledger->fund?->name }}</td>
                            <td>{!! $ledger->particulars !!}</td>
                            <td>{{ $ledger->user?->name }}</td>
                            <td>{{ $ledger->department?->name }}</td>
                            <td>{{ $ledger->created_at->format("Y-m-d h:i A") }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Records</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{ $ledgers->appends([
                    'q' => Request::get('q')
                    ])
                    ->links()
                }}
            </div>
        </div>
    </div>
</div>
@endsection


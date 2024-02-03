@extends('includes.layouts.app')

@section('page-title', 'Logs')

@section('content')

<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  <li class="breadcrumb-item ">Logs</li>
                  <li class="breadcrumb-item active" aria-current="page">List</li>
                </ol>
              </nav>
            <hr>
            <form action="" method="">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Search for User, type, data....." name="q">
                            <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-flex  mb-4">
                            <input type="date" max="{{ date('Y-m-d') }}" name="date_from" data-filtering-select="true" value="{{  Request::get("date_from") }}" class="form-control">
                            <input type="date" max="{{ date('Y-m-d') }}" @if(Request::get("date_from")) min="{{ Request::get("date_from") }}" @endif name="date_to" data-filtering-select="true" value="{{ Request::get("date_to") }}" class="form-control">
                        </div>
                    </div>
                </div>
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Audit Type</th>
                        <th>Event</th>
                        <th>Old Data</th>
                        <th>New Data</th>
                        <th>URL</th>
                        {{-- <th>User Agent</th> --}}
                        <th>Date Modified</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($audits as $audit)
                        <tr>
                            <td>{{ ucfirst($audit->user->name) }}</td>
                            <td>{{ substr($audit->auditable_type, 11) }}</td>
                            <td>{{ ucfirst($audit->event) }}</td>
                            <td> 
                                @foreach($audit->old_values as $index => $value)
                                    <div>{{ ucfirst($index) }}: {{ $value }}</div>
                                @endforeach
                            </td>
                            <td>
                                @foreach($audit->new_values as $index => $value)
                                    <div>{{ ucfirst($index) }}: {{ $value }}</div>
                                @endforeach
                            </td>
                            <td>{{ $audit->url }}</td>
                            {{-- <td>{{ $audit->user_agent }}</td> --}}
                            <td>{{ $audit->created_at->format('h:iA M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center">No Records</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $audits
                ->appends(['date_from' => Request::get("date_from")])
                ->appends(['date_to' => Request::get("date_to")])
                ->appends(['q' => Request::get("q")])
                ->links() }}
        </div>
    </div>
</div>
@endsection
@extends('includes.layouts.app')

@section('page-title', 'Dashboard')

@section('content')

<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="#">User Manager</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                </ol>
              </nav>
            <a href="" class="btn btn-primary text-white"><i class="fa fa-plus"></i> Add Permission</a>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>HtmlLorem</td>
                        <td>Engineering</td>
                        <td class="text-end">
                            <a href="" class="btn-sm text-white bg-primary"> <i class="fa fa-pencil"></i> Edit</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Administrator</td>
                        <td>Engineering</td>
                        <td class="text-end">
                            <a href="" class="btn-sm text-white bg-primary"> <i class="fa fa-pencil"></i> Edit</a>
                        </td>
                    </tr>
                    <tr>
                        <td>User</td>
                        <td>Engineering</td>
                        <td class="text-end">
                            <a href="" class="btn-sm text-white bg-primary"> <i class="fa fa-pencil"></i> Edit</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div><!--//app-card-body-->
    </div><!--//inner-->
</div><!--//app-card-->
@endsection
@extends('dashboard.includes.layouts.app')

@section('page-title', $customer->business_name)

@section('content')
@include('dashboard.customer.includes.head')

<div class="card">
    @include('dashboard.customer.includes.tab')
    <div class="app-card-body p-4">
        
        <div class="row">
            <div class="col-sm-4">
                <div class="shadow-sm p-2">
                    <form action="{{ route("dashboard.customer.add.attachment", $customer) }}" method="POST" enctype="multipart/form-data" class="overlayed-form">
                        @csrf
                        <div class="mb-3">
                            <label for="">Requirement Type<span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control">
                                @foreach($types as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="">File <span class="text-danger">*</span></label>
                            <input type="file" name="attachment" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary text-white"><i class="fa fa-upload"></i> Upload</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th>File</th>
                            <th>Type</th>
                            <th>Uploader</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attachments as $attachment)
                            <tr>
                                <td>{{ $attachment->file_name }}</td>
                                <td>{{ $attachment->category?->name }}</td>
                                <td>{{ $attachment->user?->name }}</td>
                                <td class="text-end">
                                    <a href="{{ route("dashboard.attachment.download", $attachment) }}" class="btn-sm btn-primary py-0 btn text-white px-2">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $attachment->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                    <form id="delete-{{ $attachment->id }}" action="{{ route('dashboard.attachment.destroy', $attachment->id) }}" method="POST">@csrf @method('DELETE')</form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No requirement</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div style="margin-left: 20px;">
            {{ $attachments->appends([
                'q' => Request::get('q'),
                ])->links() }}
        </div>
    </div>
</div>
@endsection

@push("scripts")
    <script>
        
        function printDiv(divName, redirect = null){
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            
            if(redirect){
                window.open(redirect, '_self')
            }

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush

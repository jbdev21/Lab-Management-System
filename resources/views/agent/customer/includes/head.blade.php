<div class="mb-2">
    <a href="{{ route('agent.customer.index') }}" ><i class="fa fa-arrow-left"></i> Back to List</a>
</div>
<div class="app-card alert alert-dismissible shadow-sm ">
    <div class="inner">
        <div class="app-card-body">
            <a type="button" data-bs-toggle="modal" class="text-primary float-end" data-bs-target="#moreDetailsModal">
                More Details
            </a>
            <h3>{{ $customer->business_name }}</h3>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="moreDetailsModal" tabindex="-1" aria-labelledby="moreDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="moreDetailsModalLabel">{{ $customer->business_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <table>
                            <tr>
                                <td>Type</td>
                                <td class="fw-bold">: {{ $customer->category?->name }}</td>
                            </tr>
                            <tr>
                                <td>Owner</td>
                                <td class="fw-bold">: {{ $customer->owner }}</td>
                            </tr>
                            <tr>
                                <td>Area</td>
                                <td class="fw-bold">: {{ $customer->area }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td class="fw-bold">: {{ $customer->address }}</td>
                            </tr>
                            <tr>
                                <td>TIN</td>
                                <td class="fw-bold">: {{ $customer->tin_number }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td class="fw-bold">: {{ $customer->email }}</td>
                            </tr>
                            <tr>
                                <td>Contact Number</td>
                                <td class="fw-bold">: {{ $customer->contact_number }}</td>
                            </tr>
    
                            <tr>
                                <td>Terms</td>
                                <td class="fw-bold">: {{ $customer->terms }}</td>
                            </tr>
                            <tr>
                                <td>Credit Limit</td>
                                <td class="fw-bold">: {{ $customer->credit_limit }}</td>
                            </tr>
                            <tr>
                                <td>Added By</td>
                                <td class="fw-bold">: 
                                    @if($customer->added_by == Auth::user()->id)
                                        {{ $customer->addedBy?->name }}
                                    @else
                                        Office
                                    @endif
                                        
                                </td>
                            </tr>
                            <tr>
                                <td>Added/Updated</td>
                                <td class="fw-bold">: {{ $customer->created_at->format('Y-m-d h:iA') }} /
                                    {{ $customer->updated_at->format('Y-m-d h:iA') }} </td>
                            </tr>
                        </table>
                    </div>
                    {{-- <div class="text-center mt-3">
                        <a href="{{ route("agent.customer.edit", $customer) }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit Customer</a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

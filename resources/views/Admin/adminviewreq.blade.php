@extends('layouts.user_type.auth')

@section('content')
@if(auth()->user()->isAdmin())
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6 class="mb-3">Stock Requests</h6>
                        <!-- Tabs -->
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#approved" role="tab">
                                        Approved 
                                        <span class="badge rounded-pill bg-success ms-1">{{ $requests->where('status', 'approved')->count() }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#pending" role="tab">
                                        Pending 
                                        <span class="badge rounded-pill bg-warning ms-1">{{ $requests->where('status', 'pending')->count() }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#rejected" role="tab">
                                        Rejected 
                                        <span class="badge rounded-pill bg-danger ms-1">{{ $requests->where('status', 'rejected')->count() }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="tab-content" id="myTabContent">
                            <!-- Approved Requests Tab -->
                            <div class="tab-pane fade show active" id="approved" role="tabpanel">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Request ID</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Name</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Branch</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Type</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Requested By</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($requests->where('status', 'approved') as $request)
                                            <tr>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->request_id }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->product_name }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->department }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->branch }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->quantity }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">₱{{ number_format($request->price, 2) }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->category }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->user->name }}</p></td>
                                                <td class="ps-4"><span class="badge badge-sm bg-success">Approved</span></td>
                                                <td class="ps-4">
                                                    <button class="btn btn-secondary btn-sm" disabled>Processed</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Pending Requests Tab -->
                            <div class="tab-pane fade" id="pending" role="tabpanel">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Request ID</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Name</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Branch</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Type</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Requested By</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($requests->where('status', 'pending') as $request)
                                            <tr>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->request_id }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->product_name }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->department }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->branch }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->quantity }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">₱{{ number_format($request->price, 2) }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->category }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->user->name }}</p></td>
                                                <td class="ps-4"><span class="badge badge-sm bg-warning">Pending</span></td>
                                                <td class="ps-4">
                                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveModal{{ $request->id }}">
                                                        Approve
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                                        Reject
                                                    </button>
                                                </td>
                                            </tr>
                                            @include('Admin.partials.approve-modal', ['request' => $request])
                                            @include('Admin.partials.reject-modal', ['request' => $request])
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Rejected Requests Tab -->
                            <div class="tab-pane fade" id="rejected" role="tabpanel">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Request ID</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Name</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Branch</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Type</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Requested By</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($requests->where('status', 'rejected') as $request)
                                            <tr>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->request_id }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->product_name }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->department }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->branch }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->quantity }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">₱{{ number_format($request->price, 2) }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->category }}</p></td>
                                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $request->user->name }}</p></td>
                                                <td class="ps-4"><span class="badge badge-sm bg-danger">Rejected</span></td>
                                                <td class="ps-4">
                                                    <button class="btn btn-secondary btn-sm" disabled>Processed</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="container">
        <div class="alert alert-danger">
            Unauthorized access.
        </div>
    </div>
@endif

<style>
.nav-pills {
    background: #f8f9fa;
    border-radius: 0.5rem;
}

.nav-pills .nav-link {
    color: #344767;
    font-weight: 500;
    font-size: 14px;
    padding: 10px 20px;
    border-radius: 0.5rem;
}

.nav-pills .nav-link.active {
    color: #fff;
    background: linear-gradient(310deg, #c41e3a, #a01830);
    box-shadow: 0 4px 6px rgba(196, 30, 58, 0.15);
}

.nav-pills .nav-link:not(.active):hover {
    color: #c41e3a;
    background-color: rgba(196, 30, 58, 0.1);
}

.badge {
    padding: 0.35em 0.65em;
    font-size: 0.75em;
    font-weight: 500;
    border-radius: 30px;
}

.table thead th {
    padding: 12px 16px;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    border-bottom: 1px solid #e9ecef;
}

.table tbody td {
    padding: 12px 16px;
    border-bottom: 1px solid #e9ecef;
}

.text-xs {
    font-size: 0.75rem !important;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    border-radius: 0.25rem;
}
</style>

@endsection
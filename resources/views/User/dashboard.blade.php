@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    <!-- Statistics Cards -->
    <div class="row justify-content-center mb-5">
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card shadow-sm hover-card">
                <div class="card-body text-center p-4">
                    <h5 class="text-muted mb-3">My Pending Requests</h5>
                    <h2 class="display-4 fw-bold" style="color: #821131;">{{ $pendingRequestsCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card shadow-sm hover-card">
                <div class="card-body text-center p-4">
                    <h5 class="text-muted mb-3">Approved Requests</h5>
                    <h2 class="display-4 fw-bold" style="color: #821131;">{{ $approvedRequestsCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card shadow-sm hover-card">
                <div class="card-body text-center p-4">
                    <h5 class="text-muted mb-3">Rejected Requests</h5>
                    <h2 class="display-4 fw-bold" style="color: #821131;">{{ $rejectedRequestsCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Requests & Low Stock Alerts in 2 columns -->
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="text-center mb-0">Recent Requests</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th class="text-center">Request ID</th>
                                    <th class="text-center">Requested By</th>
                                    <th class="text-center">Product</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentRequests as $request)
                                    <tr>
                                        <td class="text-center">{{ $request->request_id }}</td>
                                        <td class="text-center">{{ $request->user->name }}</td>
                                        <td class="text-center">{{ $request->product_name }}</td>
                                        <td class="text-center">
                                            @if($request->status == 'pending')
                                                <span class="badge rounded-pill bg-warning">Pending</span>
                                            @elseif($request->status == 'approved')
                                                <span class="badge rounded-pill bg-success">Approved</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $request->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $recentRequests->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Card hover effect */
.hover-card {
    transition: transform 0.2s ease-in-out;
}

.hover-card:hover {
    transform: translateY(-5px);
}

/* Table styling */
.table thead th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #821131;
}

.badge {
    padding: 0.5em 1em;
}

/* Card shadows and borders */
.card {
    border: none;
    border-radius: 15px;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

/* Typography */
h5.text-muted {
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.display-4 {
    font-size: 2.5rem;
}

/* Pagination styling */
.pagination {
    margin-bottom: 0 !important;
}

.page-item.active .page-link {
    background-color: #821131 !important;
    border-color: #821131 !important;
}

.page-link {
    color: #821131;
}

.page-link:hover {
    color: #6a0e28;
}

.page-item.disabled .page-link {
    color: #6c757d;
}
</style>
@endsection
@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Stock Requests</h6>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="d-flex align-items-center mb-3">
                        <div class="nav-wrapper position-relative end-0 px-4">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist" id="requestTabs">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center" data-bs-toggle="tab" href="#approved" role="tab" aria-selected="true">
                                        Approved <span class="badge bg-success rounded-pill ms-2">{{ $requests->where('status', 'approved')->count() }}</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center" data-bs-toggle="tab" href="#pending" role="tab" aria-selected="false">
                                        Pending <span class="badge bg-warning rounded-pill ms-2">{{ $requests->where('status', 'pending')->count() }}</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center" data-bs-toggle="tab" href="#rejected" role="tab" aria-selected="false">
                                        Rejected <span class="badge bg-danger rounded-pill ms-2">{{ $requests->where('status', 'rejected')->count() }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="ms-auto px-4">
                            <button id="printApproved" class="btn btn-sm btn-primary print-btn" onclick="printTable('approved')" style="display: inline-flex;">
                                <i class="fas fa-print me-2"></i>PRINT APPROVED
                            </button>
                            <button id="printPending" class="btn btn-sm btn-primary print-btn" onclick="printTable('pending')" style="display: none;">
                                <i class="fas fa-print me-2"></i>PRINT PENDING
                            </button>
                            <button id="printRejected" class="btn btn-sm btn-primary print-btn" onclick="printTable('rejected')" style="display: none;">
                                <i class="fas fa-print me-2"></i>PRINT REJECTED
                            </button>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content" id="requestTabsContent">
                        <!-- Approved Requests -->
                        <div class="tab-pane fade show active" id="approved" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Request ID</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Requested By</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Offices</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($requests->where('status', 'approved') as $request)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $request->request_id }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $request->user->name }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $request->product_name }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs text-secondary mb-0">{{ $request->department }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs text-secondary mb-0">{{ $request->branch }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs text-secondary mb-0">{{ $request->quantity }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <span class="badge bg-success">Approved</span>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs text-secondary mb-0">{{ $request->created_at->format('M d, Y') }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <button class="btn btn-secondary btn-sm" disabled>Processed</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pending Requests -->
                        <div class="tab-pane fade" id="pending" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Request ID</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Requested By</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Offices</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($requests->where('status', 'pending') as $request)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $request->request_id }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $request->user->name }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $request->product_name }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs text-secondary mb-0">{{ $request->department }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs text-secondary mb-0">{{ $request->branch }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs text-secondary mb-0">{{ $request->quantity }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <span class="badge bg-warning">Pending</span>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs text-secondary mb-0">{{ $request->created_at->format('M d, Y') }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <!-- Add your action buttons here -->
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Rejected Requests -->
                        <div class="tab-pane fade" id="rejected" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Request ID</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Requested By</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Offices</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($requests->where('status', 'rejected') as $request)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $request->request_id }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $request->user->name }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $request->product_name }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs text-secondary mb-0">{{ $request->department }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs text-secondary mb-0">{{ $request->branch }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs text-secondary mb-0">{{ $request->quantity }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <span class="badge bg-danger">Rejected</span>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs text-secondary mb-0">{{ $request->created_at->format('M d, Y') }}</p>
                                            </td>
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

<!-- Print Template (Hidden by default) -->
<div id="printTemplate" style="display: none;">
    <div style="max-width: 800px; margin: 0 auto; padding: 20px;">
        <!-- Header Table -->
        <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
            <tr>
                <td style="width: 80px; border: 1px solid black; padding: 5px; text-align: center;">
                    <img src="{{ asset('assets/img/TUP.logo.png') }}" alt="TUP Logo" style="width: 60px;">
                </td>
                <td style="border: 1px solid black; text-align: center; padding: 5px;">
                    <div style="font-weight: bold; font-size: 11px;">TECHNOLOGICAL UNIVERSITY OF THE PHILIPPINES</div>
                    <div style="font-size: 10px;">Ayala Blvd., Ermita, Manila, 1000, Philippines</div>
                    <div style="font-size: 10px;">Tel No. +632-301-3001 local 124 | Fax No. +632-521-4063</div>
                    <div style="font-size: 10px;">Email: supply@tup.edu.ph | Website: www.tup.edu.ph</div>
                </td>
                <td style="width: 150px; border: 1px solid black; padding: 2px;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 10px;">
                        <tr>
                            <td style="padding: 1px 3px;">Index No.</td>
                            <td style="padding: 1px 3px;">F-SUP-8.9-RIS</td>
                        </tr>
                        <tr>
                            <td style="padding: 1px 3px;">Issue No.</td>
                            <td style="padding: 1px 3px;">01</td>
                        </tr>
                        <tr>
                            <td style="padding: 1px 3px;">Revision No.</td>
                            <td style="padding: 1px 3px;">00</td>
                        </tr>
                        <tr>
                            <td style="padding: 1px 3px;">Date</td>
                            <td style="padding: 1px 3px;">03142023</td>
                        </tr>
                        <tr>
                            <td style="padding: 1px 3px;">Page</td>
                            <td style="padding: 1px 3px;">1 | 1</td>
                        </tr>
                        <tr>
                            <td style="padding: 1px 3px;">QAC No.</td>
                            <td style="padding: 1px 3px;">CC-11242017</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 3px; font-size: 10px;">VAF-SUP</td>
                <td colspan="2" style="border: 1px solid black; text-align: center; padding: 3px;">
                    <div style="font-weight: bold; font-size: 11px;">REQUISITION AND ISSUE SLIP</div>
                </td>
            </tr>
        </table>

        <!-- Division Info Table -->
        <table style="width: 100%; border-collapse: collapse; margin-top: -1px; font-family: Arial, sans-serif; font-size: 10px;">
            <tr>
                <td style="width: 70%; border: 1px solid black; padding: 3px;">
                    Division <span style="display: inline-block; width: 75%; border-bottom: 1px solid black;"></span><br>
                    Office <span style="display: inline-block; width: 80%; border-bottom: 1px solid black; margin-top: 3px;"></span>
                </td>
                <td style="width: 30%; border: 1px solid black; padding: 3px;">
                    Responsibility Center Code:<br>
                    RIS No. <span style="display: inline-block; width: 100px; border-bottom: 1px solid black;"></span><br>
                    SAI No. <span style="display: inline-block; width: 100px; border-bottom: 1px solid black;"></span>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid black; text-align: center; padding: 3px;">
                    <span style="font-style: italic;">R e q u i s i t i o n</span>
                </td>
                <td style="border: 1px solid black; padding: 3px;">
                    IAR No:
                </td>
            </tr>
        </table>

        <!-- Items Table -->
        <table style="width: 100%; border-collapse: collapse; margin-top: -1px; font-family: Arial, sans-serif;">
            <tr>
                <th style="border: 1px solid black; padding: 5px; font-size: 11px; width: 15%;">Stock No.</th>
                <th style="border: 1px solid black; padding: 5px; font-size: 11px; width: 10%;">Unit</th>
                <th style="border: 1px solid black; padding: 5px; font-size: 11px; width: 35%;">Description</th>
                <th style="border: 1px solid black; padding: 5px; font-size: 11px; width: 12%;">Quantity</th>
                <th style="border: 1px solid black; padding: 5px; font-size: 11px; width: 12%;">Quantity</th>
                <th style="border: 1px solid black; padding: 5px; font-size: 11px; width: 16%;">Remarks</th>
            </tr>
            @for($i = 0; $i < 12; $i++)
            <tr>
                <td style="border: 1px solid black; padding: 5px; height: 25px;">&nbsp;</td>
                <td style="border: 1px solid black; padding: 5px;">&nbsp;</td>
                <td style="border: 1px solid black; padding: 5px;">&nbsp;</td>
                <td style="border: 1px solid black; padding: 5px;">&nbsp;</td>
                <td style="border: 1px solid black; padding: 5px;">&nbsp;</td>
                <td style="border: 1px solid black; padding: 5px;">&nbsp;</td>
            </tr>
            @endfor
        </table>

        <!-- Purpose Section -->
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-family: Arial, sans-serif;">
            <tr>
                <td style="border: 1px solid black; padding: 8px;">
                    <div style="font-style: italic;">Purpose:</div>
                </td>
            </tr>
        </table>

        <!-- Signature Section -->
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-family: Arial, sans-serif;">
            <tr>
                <td style="width: 20%; border: 1px solid black; padding: 8px;">Signature</td>
                <td style="width: 20%; border: 1px solid black; text-align: center; padding: 8px;">Requested by:</td>
                <td style="width: 20%; border: 1px solid black; text-align: center; padding: 8px;">Approved by:</td>
                <td style="width: 20%; border: 1px solid black; text-align: center; padding: 8px;">Issued by:</td>
                <td style="width: 20%; border: 1px solid black; text-align: center; padding: 8px;">Received by:</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 8px;">Printed Name</td>
                <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
                <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
                <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
                <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 8px;">Designation</td>
                <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
                <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
                <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
                <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 8px;">Date</td>
                <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
                <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
                <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
                <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
            </tr>
        </table>

        <!-- Transaction ID Section -->
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-family: Arial, sans-serif;">
            <tr>
                <td style="width: 20%; border: 1px solid black; padding: 8px;">Transaction ID</td>
                <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 20%; border: 1px solid black; padding: 8px;">Signature</td>
                <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
            </tr>
        </table>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #printTemplate, #printTemplate * {
        visibility: visible !important;
    }
    #printTemplate {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    @page {
        size: A4;
        margin: 1cm;
    }
    table {
        page-break-inside: avoid;
    }
}
</style>

<script>
function printTable(status) {
    const printTemplate = document.getElementById('printTemplate');
    printTemplate.style.display = 'block';
    setTimeout(() => {
        window.print();
        printTemplate.style.display = 'none';
    }, 100);
}

// Update active print button based on tab
document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
    tab.addEventListener('shown.bs.tab', function (e) {
        const status = e.target.getAttribute('href').replace('#', '');
        document.querySelectorAll('.print-btn').forEach(btn => btn.style.display = 'none');
        document.getElementById('print' + status.charAt(0).toUpperCase() + status.slice(1)).style.display = 'inline-flex';
    });
});
</script>

<style>
.nav-pills {
    background: #f8f9fa;
    border-radius: 0.5rem;
    padding: 0.5rem;
}

.nav-pills .nav-link {
    color: #344767;
    font-weight: 500;
    font-size: 14px;
    padding: 10px 20px;
    border-radius: 0.5rem;
    min-width: 120px;
    text-align: center;
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

.btn-secondary {
    background-color: #6c757d;
    border: none;
    font-size: 0.75rem;
    padding: 0.5rem 1rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-secondary:hover {
    background-color: #5a6268;
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

.btn-primary {
    background: linear-gradient(310deg, #c41e3a, #a01830);
    border: none;
    font-size: 0.75rem;
    padding: 0.5rem 1rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #fff;
    font-weight: 500;
    box-shadow: 0 4px 6px rgba(196, 30, 58, 0.15);
    transition: all 0.2s ease;
}

.btn-primary:hover {
    background: linear-gradient(310deg, #a01830, #c41e3a);
    box-shadow: 0 4px 8px rgba(196, 30, 58, 0.25);
}

.btn-primary:active {
    transform: translateY(1px);
    box-shadow: 0 2px 4px rgba(196, 30, 58, 0.15);
}
</style>
@endsection
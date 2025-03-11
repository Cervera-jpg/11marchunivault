@extends('layouts.user_type.auth')

@section('content')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">ACCEPTED REQUESTS</h5>
                            <div>
                                <a href="{{ route('stock.create') }}" class="btn btn-primary" style="background-color: #821131 !important;">+ ADD ITEM</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">QR CODE</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">ITEM DETAILS</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">UNIT</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">DEPARTMENT</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">BRANCH</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">STOCK LEVEL</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">UNIT PRICE</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">STATUS</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stocks as $stock)
                                    <tr>
                                        <td class="ps-4 text-center">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#qrModal{{ $stock->id }}" class="d-inline-block">
                                                {!! $stock->qr_code !!}
                                            </a>
                                            
                                            <!-- QR Code Modal -->
                                            <div class="modal fade" id="qrModal{{ $stock->id }}" tabindex="-1" aria-labelledby="qrModalLabel{{ $stock->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="qrModalLabel{{ $stock->id }}">{{ $stock->product_name }} - QR Code</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            {!! QrCode::size(250)->generate(json_encode([
                                                                'id' => $stock->id,
                                                                'name' => $stock->product_name,
                                                                'category' => $stock->category,
                                                                'department' => $stock->department,
                                                                'branch' => $stock->branch,
                                                                'control_number' => $stock->control_number,
                                                                'price' => $stock->price,
                                                                'quantity' => $stock->quantity
                                                            ])) !!}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                @if($stock->description)
                                                    <!-- Clickable Image -->
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $stock->id }}">
                                                        <img src="{{ asset('storage/' . $stock->description) }}" 
                                                             alt="{{ $stock->product_name }}" 
                                                             class="me-3"
                                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; cursor: pointer;">
                                                    </a>

                                                    <!-- Image Modal -->
                                                    <div class="modal fade" id="imageModal{{ $stock->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $stock->id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="imageModalLabel{{ $stock->id }}">{{ $stock->product_name }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <img src="{{ asset('storage/' . $stock->description) }}" 
                                                                         alt="{{ $stock->product_name }}" 
                                                                         style="max-width: 100%; max-height: 70vh; height: auto; border-radius: 8px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $stock->product_name }}</p>
                                                    <p class="text-xs text-secondary mb-0">{{ $stock->control_number }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="ps-4 text-center">
                                            <span class="text-secondary text-xs">{{ $stock->category }}</span>
                                        </td>
                                        <td class="ps-4 text-center">
                                            <span class="text-secondary text-xs department-text">{{ $stock->department }}</span>
                                        </td>
                                        <td class="ps-4 text-center">
                                            <span class="text-secondary text-xs">{{ $stock->branch }}</span>
                                        </td>
                                        <td class="ps-4 text-center">
                                            <span class="text-secondary text-xs">{{ $stock->quantity }} units</span>
                                        </td>
                                        <td class="ps-4 text-center">
                                            <span class="text-secondary text-xs">₱{{ number_format($stock->price, 2) }}</span>
                                        </td>
                                        <td class="ps-4 text-center">
                                            @if($stock->quantity == 0)
                                                <span class="badge" style="background-color: #FF0000;">OUT OF STOCK</span>
                                            @elseif($stock->quantity < 50)
                                                <span class="badge" style="background-color: #ffd700;">LOW STOCK</span>
                                            @else
                                                <span class="badge" style="background-color: #4CAF50;">IN STOCK</span>
                                            @endif
                                        </td>
                                        <td class="ps-4 text-center">
                                            <a href="{{ route('stock.edit', $stock->id) }}" class="action-btn edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" style="background-color: #821131 !important;">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="javascript:void(0)" onclick="printQR({{ $stock->id }})" class="action-btn print" data-bs-toggle="tooltip" data-bs-placement="top" title="Print" style="background-color: #821131 !important;">
                                                <i class="fa-solid fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Add this hidden div for printing -->
                                    <div id="printSection{{ $stock->id }}" style="display: none;">
                                        <div style="text-align: center; padding: 20px;">
                                            <img src="{{ asset('assets/img/logo.png') }}" alt="Company Logo" style="width: 150px; margin-bottom: 15px;">
                                            <h3>{{ $stock->product_name }}</h3>
                                            <p>Control Number: {{ $stock->control_number }}</p>
                                            {!! QrCode::size(400)->generate(json_encode([
                                                'id' => $stock->id,
                                                'name' => $stock->product_name,
                                                'category' => $stock->category,
                                                'department' => $stock->department,
                                                'branch' => $stock->branch,
                                                'control_number' => $stock->control_number,
                                                'price' => $stock->price,
                                                'quantity' => $stock->quantity
                                            ])) !!}
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer py-3">
                        <div class="d-flex justify-content-end">
                            {{ $stocks->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<style>

.pagination {
    --bs-pagination-color: #821131 !important;
    --bs-pagination-active-bg: #821131 !important;
    --bs-pagination-active-border-color: #821131 !important;
    --bs-pagination-hover-color: #6a0e28 !important;
    --bs-pagination-focus-color: #6a0e28 !important;
    --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(130, 17, 49, 0.25) !important;
}

.page-link:hover {
    background-color: rgba(130, 17, 49, 0.1) !important;
}

.page-item.active .page-link {
    background-color: #821131 !important;
    border-color: #821131 !important;
    color: white !important;
}

.page-link {
    color: #821131 !important;
}

.page-link:focus {
    box-shadow: 0 0 0 0.25rem rgba(130, 17, 49, 0.25) !important;
}

.btn-success, .btn-primary {
    background-color: #821131 !important;
    border: none;
    padding: 8px 16px;
    font-weight: 500;
    color: white;
}

.btn-success:hover, .btn-primary:hover {
    background-color: #bb2d3b !important;
    opacity: 0.9;
}

.table thead th {
    font-size: 0.65rem;
    font-weight: 700;
    padding: 0.5rem;
    color: #8898aa;
    white-space: nowrap;
}

.table tbody td {
    padding: 0.5rem;
    vertical-align: middle;
}

.badge {
    padding: 3px 6px;
    font-weight: 500;
    font-size: 0.65rem;
    border-radius: 3px;
}

.action-btn {
    display: inline-block;
    width: 32px;
    height: 32px;
    line-height: 32px;
    text-align: center;
    margin: 0 4px;
    border-radius: 4px;
    color: white !important;
    text-decoration: none;
    background-color: #dc3545;
}

.action-btn i {
    line-height: inherit;
}

.action-btn:hover {
    opacity: 0.8;
    color: white !important;
    text-decoration: none;
}

.text-dark {
    font-size: 0.75rem;
}

.text-secondary {
    color: #8898aa !important;
    font-size: 0.7rem;
}

td img, .qr-code-cell img {
    max-width: 40px;
    height: auto;
    cursor: pointer;
    transition: opacity 0.3s;
}

td img:hover, .qr-code-cell img:hover {
    opacity: 0.8;
}

.qr-code-cell {
    text-align: center;
}

.table-responsive {
    margin: 0;
    padding: 0 !important;
    width: 100%;
}

.ps-4 {
    padding-left: 0.75rem !important;
}

.table th:nth-child(1), /* QR CODE */
.table td:nth-child(1) {
    width: 8%;
}

.table th:nth-child(2), /* ITEM DETAILS */
.table td:nth-child(2) {
    width: 15%;
}

.table th:nth-child(9), /* ACTIONS */
.table td:nth-child(9) {
    width: 10%;
}

.badge[style*="background-color: #FF0000;"] {
    background-color: #ff0000d9 !important; /* Out of stock */
}

.badge[style*="background-color: #FF5252;"] {
    background-color: #ff5252d9 !important; /* Low stock */
}

.badge[style*="background-color: #4CAF50;"] {
    background-color: #4caf50d9 !important; /* In stock */
}

/* Update action buttons container */
td .d-flex {
    gap: 8px;
}

/* Reduce column spacing */
.table th, 
.table td {
    padding: 0.25rem !important;  /* Reduce overall cell padding */
}

/* Adjust text alignment and spacing */
.text-secondary.text-xs {
    font-size: 0.7rem;  /* Slightly smaller text */
    margin: 0;  /* Remove any margins */
    line-height: 1.2;  /* Tighter line height */
}

/* Optional: If you need specific column widths */
.table th:nth-child(5), /* STOCK LEVEL */
.table td:nth-child(5) {
    width: 10%;
}

.table th:nth-child(6), /* UNIT PRICE */
.table td:nth-child(6) {
    width: 10%;
}

.table th:nth-child(7), /* LAST UPDATED */
.table td:nth-child(7) {
    width: 10%;
}

/* Custom tooltip styling */
.tooltip {
    font-size: 12px;
}

.tooltip .tooltip-inner {
    background-color: #333;
    padding: 4px 8px;
    border-radius: 4px;
}

.tooltip.bs-tooltip-top .tooltip-arrow::before {
    border-top-color: #333;
}

.modal {
    visibility: hidden;
    opacity: 0;
}

.modal.show {
    visibility: visible;
    opacity: 1;
}

td img {
    display: block;
    margin: 0 auto;  /* Centers the image horizontally */
    max-width: 40px;
    height: auto;
}

.table td:first-child {
    text-align: center;
    padding: 0.5rem !important;
}

/* Update existing ps-4 style for the first column */
.table td:first-child.ps-4 {
    padding-left: 0 !important;  /* Remove left padding for QR code column */
}

/* Add new styles for department column */
.department-text {
    display: block;
    max-width: 120px;  /* Adjust this value as needed */
    margin: 0 auto;
    word-wrap: break-word;
    white-space: normal;
    line-height: 1.2;
}

/* Update the department column width */
.table th:nth-child(4), /* DEPARTMENT */
.table td:nth-child(4) {
    width: 12%;
    text-align: center;
    vertical-align: middle;
}

/* Remove left padding for department column */
.table td:nth-child(4).ps-4 {
    padding-left: 0 !important;
}

.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.modal-header {
    border-bottom: none;
    padding: 1.5rem 1.5rem 1rem;
}

.modal-body {
    padding: 1rem 1.5rem 1.5rem;
}

.modal img {
    transition: transform 0.3s ease;
}

/* Optional: Add hover effect on the thumbnail */
td img:hover {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}
</style>

@push('scripts')
<script>
// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});

function printQR(stockId) {
    console.log('Print function called for stock ID:', stockId); // Debug line
    
    try {
        // Get the print content
        const printSection = document.getElementById(`printSection${stockId}`);
        if (!printSection) {
            console.error('Print section not found for ID:', stockId);
            return;
        }
        
        const printContent = printSection.innerHTML;
        
        // Create a new window for printing
        const printWindow = window.open('', '_blank');
        if (!printWindow) {
            alert('Please allow pop-ups for printing functionality');
            return;
        }
        
        // Write the content to the new window
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
                <head>
                    <title>Print QR Code</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 0;
                        }
                        .print-container {
                            width: 100%;
                            max-width: 500px;
                            margin: 0 auto;
                            padding: 20px;
                            text-align: center;
                        }
                        .logo {
                            width: 150px;
                            margin-bottom: 15px;
                        }
                        img {
                            max-width: 400px;
                            height: auto;
                        }
                        h3 {
                            margin: 10px 0;
                            font-size: 20px;
                        }
                        p {
                            margin: 5px 0;
                            font-size: 16px;
                        }
                        @media print {
                            @page {
                                size: A6;
                                margin: 0;
                            }
                            body {
                                margin: 0;
                                padding: 10px;
                            }
                            .print-container {
                                page-break-after: always;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="print-container">
                        ${printContent}
                    </div>
                </body>
            </html>
        `);
        
        // Wait for the content to load
        printWindow.document.close();
        printWindow.onload = function() {
            printWindow.focus();
            printWindow.print();
            setTimeout(function() {
                printWindow.close();
            }, 1000);
        };
    } catch (error) {
        console.error('Error printing QR code:', error);
    }
}

// Add this to remove d-none class after page load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('deleteModal').classList.remove('d-none');
});


</script>
@endpush



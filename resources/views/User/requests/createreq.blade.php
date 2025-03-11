@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body pt-4 p-3">
            <form action="{{ route('user.requests.store') }}" method="POST" role="form text-left">
                @csrf
                <!-- Header Section -->
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <img src="{{ asset('assets/img/TUP.logo.png') }}" alt="TUP Logo" style="height: 60px;" class="me-2">
                            <div>
                                <h6 class="mb-0" style="font-size: 0.8rem;">TECHNOLOGICAL UNIVERSITY OF THE PHILIPPINES</h6>
                                <p class="mb-0" style="font-size: 0.7rem;">Ayala Boulevard, Ermita, Manila</p>
                                <h5 class="mb-0 mt-2">REQUISITION AND ISSUE SLIP</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Details Section -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="department" class="form-label small">Department</label>
                            <select name="department" id="department" class="form-control form-control-sm" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $dept => $branches)
                                    <option value="{{ $dept }}">{{ $dept }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="branch" class="form-label small">Branch</label>
                            <select name="branch" id="branch" class="form-control form-control-sm" required>
                                <option value="">Select Branch</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 80px;" class="text-center small">Item No.</th>
                                <th style="width: 100px;" class="text-center small">Unit</th>
                                <th class="text-center small">Description</th>
                                <th style="width: 100px;" class="text-center small">Quantity</th>
                                <th style="width: 120px;" class="text-center small">Remarks</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody id="items-container">
                            <tr class="item-entry">
                                <td class="text-center item-number">1</td>
                                <td>
                                    <select class="form-control form-control-sm" name="items[0][category]" required>
                                        <option value="">Select</option>
                                        <option value="Box">Box</option>
                                        <option value="Piece">Piece</option>
                                        <option value="Pack">Pack</option>
                                        <option value="Ream">Ream</option>
                                        <option value="Roll">Roll</option>
                                        <option value="Bottle">Bottle</option>
                                        <option value="Cartridges">Cartridges</option>
                                        <option value="Gallon">Gallon</option>
                                        <option value="Litre">Litre</option>
                                        <option value="Meter">Meter</option>
                                        <option value="Pound">Pound</option>
                                        <option value="Sheet">Sheet</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control form-control-sm product-select" name="items[0][product_name]" required>
                                        <option value="">Select Product</option>
                                        @foreach($supplies as $supply)
                                            <option value="{{ $supply->product_name }}" 
                                                data-quantity="{{ $supply->quantity }}"
                                                data-unit-type="{{ $supply->unit_type }}"
                                                class="{{ $supply->quantity < 10 ? 'text-danger' : '' }}">
                                                {{ $supply->product_name }} 
                                                @if($supply->quantity < 10)
                                                    (Low Stock - {{ $supply->quantity }} left)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" name="items[0][quantity]" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" name="items[0][remarks]">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-item" style="display: none;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Add Item Button -->
                <div class="row mb-4">
                    <div class="col-12">
                        <button type="button" class="btn btn-info btn-sm" id="add-item">
                            <i class="fas fa-plus"></i> Add Item
                        </button>
                    </div>
                </div>

                <!-- Purpose Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="purpose" class="form-label small">Purpose</label>
                            <textarea name="purpose" id="purpose" rows="2" class="form-control form-control-sm" required></textarea>
                        </div>
                    </div>
                </div>

                <!-- Signature Section -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="form-group text-center">
                            <label class="form-label small d-block">Requested by:</label>
                            <div class="border-bottom border-dark" style="height: 1px;"></div>
                            <small class="text-muted">Signature over Printed Name</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group text-center">
                            <label class="form-label small d-block">Approved by:</label>
                            <div class="border-bottom border-dark" style="height: 1px;"></div>
                            <small class="text-muted">Department Head</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group text-center">
                            <label class="form-label small d-block">Noted by:</label>
                            <div class="border-bottom border-dark" style="height: 1px;"></div>
                            <small class="text-muted">Property Custodian</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group text-center">
                            <label class="form-label small d-block">Released by:</label>
                            <div class="border-bottom border-dark" style="height: 1px;"></div>
                            <small class="text-muted">Supply Officer</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn bg-gradient-dark btn-md">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.table th, .table td {
    padding: 0.5rem;
    vertical-align: middle;
}
.form-control-sm {
    height: calc(1.5em + 0.5rem + 2px);
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border-radius: 0.2rem;
}
.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border-radius: 0.2rem;
}
.small {
    font-size: 0.875rem;
}
</style>

@endsection

@push('scripts')
<script>
const departments = @json($departments);

document.getElementById('department').addEventListener('change', function() {
    const department = this.value;
    const branchSelect = document.getElementById('branch');
    branchSelect.innerHTML = '<option value="">Select Branch</option>';
    
    if (department && departments[department]) {
        departments[department].forEach(branch => {
            const option = new Option(branch, branch);
            branchSelect.add(option);
        });
    }
});

// Handle product selection change
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('product-select')) {
        const selectedOption = e.target.options[e.target.selectedIndex];
        const itemEntry = e.target.closest('.item-entry');
        const unitTypeSelect = itemEntry.querySelector('select[name$="[category]"]');
        
        if (selectedOption.value) {
            const unitType = selectedOption.getAttribute('data-unit-type');
            Array.from(unitTypeSelect.options).forEach(option => {
                if (option.value.toLowerCase() === unitType.toLowerCase()) {
                    option.selected = true;
                }
            });
        }
    }
});

// Add new item row
document.getElementById('add-item').addEventListener('click', function() {
    const container = document.getElementById('items-container');
    const itemCount = container.children.length;
    const template = container.children[0].cloneNode(true);
    
    // Update item number
    template.querySelector('.item-number').textContent = itemCount + 1;
    
    // Reset form elements
    template.querySelectorAll('input, select').forEach(input => {
        if (input.classList.contains('product-select')) {
            input.selectedIndex = 0;
        } else {
            input.value = '';
        }
        if (input.name) {
            input.name = input.name.replace('[0]', `[${itemCount}]`);
        }
    });

    // Show remove button
    template.querySelector('.remove-item').style.display = 'inline-block';
    container.appendChild(template);

    // Show all remove buttons if more than one item
    if (container.children.length > 1) {
        container.querySelectorAll('.remove-item').forEach(button => {
            button.style.display = 'inline-block';
        });
    }
});

// Remove item row
document.getElementById('items-container').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-item') || e.target.closest('.remove-item')) {
        const container = document.getElementById('items-container');
        const row = e.target.closest('tr');
        row.remove();

        // Hide remove button if only one item remains
        if (container.children.length === 1) {
            container.querySelector('.remove-item').style.display = 'none';
        }

        // Update item numbers
        container.querySelectorAll('.item-number').forEach((cell, index) => {
            cell.textContent = index + 1;
        });

        // Reindex form elements
        container.querySelectorAll('.item-entry').forEach((item, index) => {
            item.querySelectorAll('input, select').forEach(input => {
                if (input.name) {
                    input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
                }
            });
        });
    }
});
</script>
@endpush
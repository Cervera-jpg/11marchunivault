@extends('layouts.user_type.auth')

@section('content')
<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">Generate Reports</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form id="reportForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="department" class="form-control-label">Department</label>
                                <select name="department" id="department" class="form-control" required>
                                    <option value="">Select Department</option>
                                    @foreach($departments as $dept => $branches)
                                        <option value="{{ $dept }}">{{ $dept }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="branch" class="form-control-label">Branch</label>
                                <select name="branch" id="branch" class="form-control" required>
                                    <option value="">Select Branch</option>
                                    @if(request('department') == 'COE')
                                        <option value="ME Laboratory">ME Laboratory</option>
                                        <option value="Civil Laboratory">Civil Laboratory</option>
                                    @elseif(request('department') == 'COS/CLA')
                                        <option value="Museum c/o Prof. Marcelina Puga">Museum c/o Prof. Marcelina Puga</option>
                                        <option value="Medical/Dental Clinic">Medical/Dental Clinic</option>
                                    @elseif(request('department') == 'CIT')
                                        <option value="Office of the Dean">Office of the Dean</option>
                                    @elseif(request('department') == 'CIE')
                                        <option value="Cultural Office">Cultural Office</option>
                                        <option value="Technical Arts Department">Technical Arts Department</option>
                                    @elseif(request('department') == 'CAFA')
                                        <option value="Fine Arts Department">Fine Arts Department</option>
                                        <option value="Physical Education Gym">Physical Education Gym</option>
                                        <option value="TUPFA Office">TUPFA Office</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date" class="form-control-label">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date" class="form-control-label">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" onclick="generateReport()" class="btn btn-primary" style="background-color: #e91e63;">
                            <i class="fas fa-file me-2"></i>
                            GENERATE REPORT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Print Modal -->
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalLabel">Stock Report Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="printContent">
                <!-- Report content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn bg-gradient-primary" onclick="window.print()">
                    <i class="fas fa-print me-2"></i>Print Report
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('dashboard')
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

document.addEventListener('DOMContentLoaded', function() {
    // Set default dates
    const today = new Date();
    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    
    document.getElementById('start_date').valueAsDate = firstDayOfMonth;
    document.getElementById('end_date').valueAsDate = today;

    // Trigger change event if department is pre-selected
    const departmentSelect = document.getElementById('department');
    if (departmentSelect.value) {
        departmentSelect.dispatchEvent(new Event('change'));
    }
});

function generateReport() {
    const formData = new FormData(document.getElementById('reportForm'));
    const department = formData.get('department');
    const branch = formData.get('branch');
    const start_date = formData.get('start_date');
    const end_date = formData.get('end_date');

    // Validate form
    if (!department || !branch || !start_date || !end_date) {
        alert('Please fill in all fields');
        return;
    }
    
    // Show modal
    const printModal = new bootstrap.Modal(document.getElementById('printModal'));
    printModal.show();
}
</script>
@endpush

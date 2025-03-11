@extends('layouts.user_type.auth')

@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Add New Stock</h6>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('stock.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_name" class="form-control-label">Product Name</label>
                                        <input type="text" class="form-control" id="product_name" name="product_name" 
                                            value="{{ session('request_data.product_name') ?? old('product_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="quantity" class="form-control-label">Quantity</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity" 
                                            value="{{ session('request_data.quantity') ?? old('quantity') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price" class="form-control-label">Price</label>
                                        <input type="number" step="0.01" class="form-control" id="price" name="price" 
                                            value="{{ session('request_data.price') ?? old('price') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department">Department</label>
                                        <select name="department" id="department" class="form-control" required>
                                            <option value="">Select Department</option>
                                            @foreach($departments as $dept => $branches)
                                                <option value="{{ $dept }}" 
                                                    {{ (session('request_data.department') == $dept || old('department') == $dept) ? 'selected' : '' }}>
                                                    {{ $dept }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="branch">Branch</label>
                                        <select name="branch" id="branch" class="form-control" required>
                                            <option value="">Select Branch</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category" class="form-control-label">Unit type</label>
                                        <select class="form-control" id="category" name="category" required>
                                            <option value="">Select Unit</option>
                                            <option value="Box" {{ (session('request_data.category') == 'Box' || old('category') == 'Box') ? 'selected' : '' }}>Box</option>
                                            <option value="Piece" {{ (session('request_data.category') == 'Piece' || old('category') == 'Piece') ? 'selected' : '' }}>Piece</option>
                                            <option value="Pack" {{ (session('request_data.category') == 'Pack' || old('category') == 'Pack') ? 'selected' : '' }}>Pack</option>
                                            <option value="Ream" {{ (session('request_data.category') == 'Ream' || old('category') == 'Ream') ? 'selected' : '' }}>Ream</option>
                                            <option value="Roll" {{ (session('request_data.category') == 'Roll' || old('category') == 'Roll') ? 'selected' : '' }}>Roll</option>
                                            <option value="Botle" {{ (session('request_data.category') == 'Botle' || old('category') == 'Botle') ? 'selected' : '' }}>Botle</option>
                                            <option value="Cartridges" {{ (session('request_data.category') == 'Cartridges' || old('category') == 'Cartridges') ? 'selected' : '' }}>Cartridges</option>
                                            <option value="Gallon" {{ (session('request_data.category') == 'Gallon' || old('category') == 'Gallon') ? 'selected' : '' }}>Gallon</option>
                                            <option value="Litre" {{ (session('request_data.category') == 'Litre' || old('category') == 'Litre') ? 'selected' : '' }}>Litre</option>
                                            <option value="Meter" {{ (session('request_data.category') == 'Meter' || old('category') == 'Meter') ? 'selected' : '' }}>Meter</option>
                                            <option value="Pound" {{ (session('request_data.category') == 'Pound' || old('category') == 'Pound') ? 'selected' : '' }}>Pound</option>
                                            <option value="Sheet" {{ (session('request_data.category') == 'Sheet' || old('category') == 'Sheet') ? 'selected' : '' }}>Sheet</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image" class="form-control-label">Product Image</label>
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                        <small class="text-muted">Supported formats: JPG, PNG, GIF. Max size: 2MB</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <a href="{{ route('admin.tables') }}" class="btn" style="background-color: #821131; color: white;">CANCEL</a>
                                    <button type="submit" class="btn" style="background-color: #821131; color: white;">ADD STOCK</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
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
            if ("{{ old('branch') }}" === branch || "{{ session('request_data.branch') ?? '' }}" === branch) {
                option.selected = true;
            }
            branchSelect.add(option);
        });
    }
});

// Trigger change event on page load if department is pre-selected
window.addEventListener('load', function() {
    const departmentSelect = document.getElementById('department');
    if (departmentSelect.value) {
        departmentSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
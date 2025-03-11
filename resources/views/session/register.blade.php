@extends('layouts.user_type.guest')

@section('content')
<main class="main-content" style="background-color: #f1f1f1; min-height: 100vh;">
    <section class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card shadow-sm" style="border-radius: 15px;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="font-weight-bold m-0" style="font-size: 1.25rem;">REGISTER</h3>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('assets/img/TUP.logo.png') }}" alt="TUP Logo" style="height: 50px;">
                                    <img src="{{ asset('assets/img/univaultlogo.png') }}" alt="UniVault Logo" style="height: 50px;">
                                </div>
                            </div>

                            <form role="form" method="POST" action="/register">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label small">Name:</label>
                                    <input type="text" class="form-control form-control-sm" name="name" id="name" 
                                        placeholder="Enter name" style="background-color: #f1f1f1; border-radius: 8px;" value="{{ old('name') }}">
                                    @error('name')
                                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <label class="form-label small">Email:</label>
                                    <input type="email" class="form-control form-control-sm" name="email" id="email" 
                                        placeholder="Enter email" style="background-color: #f1f1f1; border-radius: 8px;" value="{{ old('email') }}">
                                    @error('email')
                                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <label class="form-label small">Password:</label>
                                    <input type="password" class="form-control form-control-sm" name="password" id="password" 
                                        placeholder="Enter password" style="background-color: #f1f1f1; border-radius: 8px;">
                                    @error('password')
                                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <label class="form-label small">Confirm Password:</label>
                                    <input type="password" class="form-control form-control-sm" name="password_confirmation" id="password_confirmation" 
                                        placeholder="Confirm password" style="background-color: #f1f1f1; border-radius: 8px;">
                                </div>

                                <div class="mb-2">
                                    <label class="form-label small">Department:</label>
                                    <select name="department" id="department" class="form-control form-control-sm" style="background-color: #f1f1f1; border-radius: 8px;" required>
                                        <option value="">Select Department</option>
                                        <option value="COE">COLLEGE OF ENGINEERING</option>
                                        <option value="COS">COLLEGE OF SCIENCE</option>
                                        <option value="CLA">COLLEGE OF LIBERAL ARTS</option>
                                        <option value="CIT">COLLEGE OF INDUSTRIAL TECHNOLOGY</option>
                                        <option value="CIE">COLLEGE OF INDUSTRIAL EDUCATION</option>
                                        <option value="CAFA">COLLEGE OF ARCHITECTURE AND FINE ARTS</option>
                                        <option value="ETTEAP">EXPANDED TERTIARY EDUCATION EQUIVALENCY PROGRAM</option>
                                        <option value="ADMINISTRATION">ADMINISTRATION</option>
                                        <option value="CENTER">CENTER</option>
                                        <option value="SUPPORT SERVICES">SUPPORT SERVICES</option>
                                    </select>
                                    @error('department')
                                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <label class="form-label small">Branch:</label>
                                    <select name="branch" id="branch" class="form-control form-control-sm" style="background-color: #f1f1f1; border-radius: 8px;" required>
                                        <option value="">Select Branch</option>
                                    </select>
                                    @error('branch')
                                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <label class="form-label small">Role:</label>
                                    <select name="role" id="role" class="form-control form-control-sm" style="background-color: #f1f1f1; border-radius: 8px;">
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="agreement" id="flexCheckDefault">
                                        <label class="form-check-label small" for="flexCheckDefault">
                                            I agree to the Terms and Conditions
                                        </label>
                                    </div>
                                    @error('agreement')
                                        <p class="text-danger text-xs mt-1">First, agree to the Terms and Conditions, then try register again.</p>
                                    @enderror
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-sm text-white" 
                                        style="background-color: #c41e3a; border-radius: 8px; padding: 8px;">SIGN UP</button>
                                </div>

                                <div class="mt-2 text-center">
                                    <p class="mb-0 small">
                                        Already have an account? 
                                        <a href="login" class="text-primary text-decoration-none">Sign in</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
const departments = {
    'COE': [
        'Electrical Engineering',
        'Electronics Communication Engineering',
        'Mechanical Engineering',
        'Civil Engineering',
        'COE Office of the Dean'
    ],
    'COS': [
        'Mathematics Department',
        'Physics Department',
        'Chemistry Department',
        'Computer Studies Department',
        'COS Office of the Dean'
    ],
    'CLA': [
        'Languages Department',
        'Entrepreneurship and Management Department',
        'Social Science Department',
        'Physical Education',
        'CLA Office of the Dean'
    ],
    'CIT': [
        'Basic Industrial Technology',
        'Civil Engineering Technology',
        'Electrical Engineering Technology',    
        'Mechanical Engineering Technology',
        'Food and Apparel Technology',
        'Graphic Arts and Printing Technology',
        'Power Plant Engineering Technology',
        'Student Teaching',
        'Electronics Engineering Technology',
        'CIT Office of the Dean'
    ],
    'CIE': [
        'Cultural Office',
        'Technical Arts Department',
        'Student Teaching',
        'Technical Arts',
        'Home Economics',
        'Professional Industrial Education',    
        'CIE Office of the Dean'
    ],
    'CAFA': [
        'Architecture Department',
        'Fine Arts Department',
        'Graphics Department',
        'CAFA Office of the Dean'
    ],
    'ADMINISTRATION': [
        'Vice President - Research and Extention',
        'Vice President - Administration and Finance',
        'Vice President - Academic Affairs',
        'Vice President - Planning, Development and Special Concerns',
        'Office of the President'
    ],
    'CENTER': [
        'Integrated Research and Training Center'
    ],
    'SUPPORT SERVICES': [
        'University Registrar',
        'University Medical and Dental Clinic',
        'Industrial Relations and Job Placement Office',
        'University Information Techonology Center',
        'University Library'
    ]
};

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
</script>

<style>
.form-control:focus {
    border-color: #c41e3a;
    box-shadow: 0 0 0 0.2rem rgba(196, 30, 58, 0.25);
}

.form-check-input:checked {
    background-color: #c41e3a;
    border-color: #c41e3a;
}

.text-primary {
    color: #c41e3a !important;
}

.btn:hover {
    background-color: #a01830 !important;
}

select.form-control {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23333' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    padding-right: 2.5rem;
}

.form-control-sm {
    height: calc(1.5em + 0.5rem + 2px);
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>
@endsection


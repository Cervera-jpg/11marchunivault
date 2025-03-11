@extends('layouts.user_type.auth')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Profile Picture Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Profile Picture</h6>
                </div>
                <div class="card-body text-center">
                    <div class="profile-image-container">
                        <div class="avatar-wrapper">
                            <img src="{{ auth()->user()->avatar ?? '../assets/img/default-avatar.png' }}" 
                                 alt="Profile Picture" 
                                 class="profile-image">
                            <label for="avatar-upload" class="avatar-edit-button">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" 
                                   id="avatar-upload" 
                                   class="hidden-input" 
                                   accept="image/*"
                                   onchange="uploadAvatar(this)">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Profile Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required>
                                </div>
                            </div>
                        </div>

                        

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Change Password</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('password.change') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-control" name="current_password" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" name="new_password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(130, 17, 49, 0.15) !important;
}

.card-header {
    background: #821131;
    color: white !important;
    border-bottom: none;
    padding: 1rem 1.5rem;
    border-radius: 10px 10px 0 0 !important;
}

.card-header h6 {
    color: white !important;
    font-size: 1rem;
    font-weight: 600 !important;
}

.profile-image-container {
    padding: 1rem 0;
}

.avatar-wrapper {
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto;
}

.profile-image {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 4px solid #821131;
    object-fit: cover;
    background: #fff;
}

.avatar-edit-button {
    position: absolute;
    right: 5px;
    bottom: 5px;
    background: #821131;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.avatar-edit-button:hover {
    background: #6a0e28;
    transform: translateY(-2px);
}

.avatar-edit-button i {
    color: white;
    font-size: 16px;
}

.hidden-input {
    display: none;
}

.form-label {
    font-weight: 500;
    color: #821131;
    margin-bottom: 0.5rem;
}

.form-control {
    border: 1px solid #e3e6f0;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: #821131;
    box-shadow: 0 0 0 0.2rem rgba(130, 17, 49, 0.25);
}

.btn-primary {
    background: #821131;
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-primary:hover {
    background: #6a0e28;
    transform: translateY(-1px);
    box-shadow: 0 4px 20px rgba(130, 17, 49, 0.3);
}

.alert {
    border-radius: 8px;
    margin-bottom: 1rem;
}

.alert-success {
    background-color: rgba(130, 17, 49, 0.1);
    border-color: rgba(130, 17, 49, 0.2);
    color: #821131;
}

@media (max-width: 768px) {
    .col-md-6 {
        margin-bottom: 1rem;
    }
}
</style>

<script>
function uploadAvatar(input) {
    if (input.files && input.files[0]) {
        // Check file size
        if (input.files[0].size > 2 * 1024 * 1024) {
            showAlert('error', 'File size must be less than 2MB');
            return;
        }

        const formData = new FormData();
        formData.append('avatar', input.files[0]);
        formData.append('_token', '{{ csrf_token() }}');

        // Show loading state
        showAlert('info', 'Uploading profile picture...', false);

        fetch('/upload-avatar', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Upload failed');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update profile page image
                document.querySelector('.profile-image').src = data.path;
                
                // Update navigation profile picture
                const navProfilePic = document.querySelector('#nav-profile-picture');
                if (navProfilePic) {
                    navProfilePic.src = data.path;
                }

                // Show success message
                showAlert('success', data.message || 'Profile picture updated successfully');
            } else {
                throw new Error(data.message || 'Upload failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', error.message || 'Error updating profile picture. Please try again.');
        });
    }
}

function showAlert(type, message, autoHide = true) {
    // Remove any existing alerts
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());

    // Create new alert
    const alert = document.createElement('div');
    alert.className = `alert alert-${type === 'error' ? 'danger' : type}`;
    alert.innerHTML = message;
    alert.style.marginTop = '10px';

    // Insert alert before the profile image container
    const container = document.querySelector('.profile-image-container');
    document.querySelector('.card-body').insertBefore(alert, container);

    // Auto hide after 3 seconds if autoHide is true
    if (autoHide) {
        setTimeout(() => alert.remove(), 3000);
    }

    return alert;
}
</script>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@endsection
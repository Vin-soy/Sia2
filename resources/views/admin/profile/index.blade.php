@extends('admin.dashboard')

@section('content')
<div class="profile-container">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="header-content">
            <div class="profile-image-wrapper">
                <div class="profile-image">
                    <img src="{{ asset('images/team1.jpg') }}" alt="Profile Photo">
                    <div class="image-overlay">
                        <i class="bx bx-camera"></i>
                        <span>Change Photo</span>
                    </div>
                </div>
            </div>
            <div class="profile-title">
                <h1>{{ $user->name }}</h1>
                <span class="profile-role">System Administrator</span>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="profile-content">
        <!-- Left Section - Personal Information -->
        <div class="profile-section personal-info">
            <div class="section-header">
                <h2><i class="bx bx-user-circle"></i> Personal Information</h2>
                <button class="edit-btn" onclick="toggleEdit()">
                    <i class="bx bx-edit"></i> Edit Profile
                </button>
            </div>
            <div class="info-grid">
                <div class="info-group">
                    <label>Full Name</label>
                    <input type="text" value="{{ $user->name }}" disabled>
                </div>
                <div class="info-group">
                    <label>Email Address</label>
                    <input type="email" value="{{ $user->email }}" disabled>
                </div>
                <div class="info-group">
                    <label>Contact Number</label>
                    <input type="tel" value="{{ $user->info->contact_number ?? 'Not set' }}" disabled>
                </div>
                <div class="info-group">
                    <label>Date of Birth</label>
                    <input type="text" value="{{ $user->info->birth_date ?? 'Not set' }}" disabled>
                </div>
                <div class="info-group full-width">
                    <label>Address</label>
                    <input type="text" value="Metro Manila, Philippines" disabled>
                </div>
            </div>
        </div>

        <!-- Right Section - Account Settings -->
        <div class="profile-section account-settings">
            <div class="section-header">
                <h2><i class="bx bx-cog"></i> Account Settings</h2>
            </div>
            <div class="settings-list">
                <div class="setting-item">
                    <div class="setting-info">
                        <i class="bx bx-shield"></i>
                        <div>
                            <h3>Admin Controls</h3>
                            <p>Manage system settings and permissions</p>
                        </div>
                    </div>
                    <button class="setting-btn">Manage</button>
                </div>
                <div class="setting-item">
                    <div class="setting-info">
                        <i class="bx bx-lock-alt"></i>
                        <div>
                            <h3>Password & Security</h3>
                            <p>Update your password and security settings</p>
                        </div>
                    </div>
                    <button class="setting-btn">Update</button>
                </div>
                <div class="setting-item">
                    <div class="setting-info">
                        <i class="bx bx-bell"></i>
                        <div>
                            <h3>System Notifications</h3>
                            <p>Configure system alert preferences</p>
                        </div>
                    </div>
                    <button class="setting-btn">Configure</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Profile Container */
.profile-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

/* Profile Header */
.profile-header {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    border-radius: 16px;
    padding: 3rem 2rem;
    margin-bottom: 2rem;
    color: white;
}

.header-content {
        display: flex;
        align-items: center;
    gap: 2rem;
}

.profile-image-wrapper {
    position: relative;
    }

    .profile-image {
    width: 150px;
    height: 150px;
        border-radius: 50%;
        overflow: hidden;
    border: 4px solid rgba(255, 255, 255, 0.2);
    position: relative;
    cursor: pointer;
    }

    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.profile-image:hover .image-overlay {
    opacity: 1;
}

.image-overlay i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.profile-title h1 {
    font-size: 2rem;
    margin: 0;
    font-weight: 600;
}

.profile-role {
    font-size: 1.1rem;
    opacity: 0.9;
}

/* Profile Content */
.profile-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
}

/* Profile Sections */
.profile-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e2e8f0;
}

.section-header h2 {
    font-size: 1.25rem;
    color: #2d3748;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-header h2 i {
    font-size: 1.5rem;
    color: #4a5568;
}

/* Personal Information */
.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.info-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-group.full-width {
    grid-column: span 2;
}

.info-group label {
    font-size: 0.9rem;
    color: #4a5568;
    font-weight: 500;
}

.info-group input {
    padding: 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    color: #2d3748;
    background: #f8fafc;
}

.info-group input:disabled {
    cursor: not-allowed;
    opacity: 0.8;
}

/* Account Settings */
.settings-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.setting-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.setting-item:hover {
    transform: translateX(5px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.setting-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.setting-info i {
    font-size: 1.5rem;
    color: #4a5568;
    padding: 0.75rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.setting-info h3 {
    margin: 0;
    font-size: 1rem;
    color: #2d3748;
}

.setting-info p {
    margin: 0;
    font-size: 0.875rem;
    color: #718096;
}

/* Buttons */
.edit-btn, .setting-btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.edit-btn {
    background: #2a5298;
    color: white;
}

.setting-btn {
    background: #edf2f7;
    color: #4a5568;
}

.edit-btn:hover, .setting-btn:hover {
    transform: translateY(-2px);
}

.edit-btn:hover {
    background: #1e3c72;
}

.setting-btn:hover {
    background: #e2e8f0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .profile-container {
        padding: 1rem;
    }

    .profile-header {
        padding: 2rem 1rem;
    }

    .header-content {
        flex-direction: column;
        text-align: center;
    }

    .profile-content {
        grid-template-columns: 1fr;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .info-group.full-width {
        grid-column: span 1;
    }

    .setting-item {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .setting-info {
        flex-direction: column;
    }
    }
</style>

<script>
function toggleEdit() {
    const inputs = document.querySelectorAll('.info-group input');
    inputs.forEach(input => {
        input.disabled = !input.disabled;
    });
    
    const editBtn = document.querySelector('.edit-btn');
    if (editBtn.innerHTML.includes('Edit')) {
        editBtn.innerHTML = '<i class="bx bx-save"></i> Save Changes';
    } else {
        editBtn.innerHTML = '<i class="bx bx-edit"></i> Edit Profile';
        // Here you would typically make an API call to save the changes
        alert('Changes saved! (Frontend Only)');
    }
}
</script>
@endsection
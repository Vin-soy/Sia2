@extends('admin.dashboard')

@section('content')
<div class="admin-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1><i class='bx bx-user-circle'></i> User Management</h1>
            <div class="header-actions">
                <button class="add-user-btn" onclick="toggleAddUserForm()">
                    <i class='bx bx-user-plus'></i> Add New User
                </button>
            </div>
        </div>
    </div>

    <!-- Add User Form (Hidden by default) -->
    <div class="add-user-form-container" id="addUserForm" style="display: none;">
        <div class="card add-user-card">
            <div class="card-header">
                <h2 class="section-title">Add New User</h2>
                <button class="close-btn" onclick="toggleAddUserForm()">
                    <i class='bx bx-x'></i>
                </button>
            </div>
            <form action="{{ route('users.store') }}" method="POST" class="add-user-form">
                @csrf
                <div class="form-grid">
                    <!-- Personal Information -->
                    <div class="form-section">
                        <h3 class="form-section-title">Personal Information</h3>
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-input" required>
                            @error('first_name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="middle_name">Middle Name</label>
                            <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name') }}" class="form-input">
                            @error('middle_name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="form-input" required>
                            @error('last_name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="form-section">
                        <h3 class="form-section-title">Contact Information</h3>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input" required>
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="contact">Contact Number</label>
                            <input type="text" name="contact_number" id="contact" value="{{ old('contact_number') }}" class="form-input">
                            @error('contact_number')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="birth_date">Birth Date</label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" class="form-input">
                            @error('birth_date')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div class="form-section">
                        <h3 class="form-section-title">Role Assignment</h3>
                        <div class="form-group">
                            <label for="role">User Role</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="">Select Role</option>
                                <option value="tenant" {{ old('role') == 'tenant' ? 'selected' : '' }}>Tenant</option>
                                <option value="landlord" {{ old('role') == 'landlord' ? 'selected' : '' }}>Landlord</option>
                            </select>
                            @error('role')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="submit-btn">
                                <i class='bx bx-user-plus'></i> Create User
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Grid -->
    <div class="users-grid">
        <!-- Tenants Section -->
        <div class="card users-card">
            <div class="card-header">
                <h2 class="section-title">
                    <i class='bx bx-user'></i> Tenants
                    <span class="user-count">{{ count($tenants) }}</span>
                </h2>
                <div class="card-actions">
                    <div class="search-box">
                        <i class='bx bx-search'></i>
                        <input type="text" placeholder="Search tenants..." onkeyup="filterUsers(this, 'tenants-list')">
                    </div>
                </div>
            </div>
            <div class="users-list" id="tenants-list">
                @forelse($tenants as $tenant)
                    <div class="user-item" data-name="{{ strtolower($tenant->name) }}" data-id="{{ $tenant->id }}">
                        <div class="user-info">
                            <div class="user-avatar">
                                <img src="{{ asset('images/team1.jpg') }}" alt="{{ $tenant->name }}">
                                <span class="status-indicator active"></span>
                            </div>
                            <div class="user-details">
                                <h3>{{ $tenant->name }}</h3>
                                <p class="user-email">{{ $tenant->email }}</p>
                                @if($tenant->info && $tenant->info->contact_number)
                                    <p class="user-contact">{{ $tenant->info->contact_number }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="user-actions">
                            <button class="action-btn view-btn" title="View Details" onclick="viewUserDetails({{ $tenant->id }})">
                                <i class='bx bx-show'></i>
                            </button>
                            <button class="action-btn edit-btn" title="Edit User" onclick="editUser({{ $tenant->id }})">
                                <i class='bx bx-edit'></i>
                            </button>
                            <button class="action-btn delete-btn" title="Delete User" onclick="deleteUser({{ $tenant->id }}, 'tenant')">
                                <i class='bx bx-trash'></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="no-data">
                        <i class='bx bx-user-x'></i>
                        <p>No tenants found</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Landlords Section -->
        <div class="card users-card">
            <div class="card-header">
                <h2 class="section-title">
                    <i class='bx bx-building-house'></i> Landlords
                    <span class="user-count">{{ count($landlords) }}</span>
                </h2>
                <div class="card-actions">
                    <div class="search-box">
                        <i class='bx bx-search'></i>
                        <input type="text" placeholder="Search landlords..." onkeyup="filterUsers(this, 'landlords-list')">
                    </div>
                </div>
            </div>
            <div class="users-list" id="landlords-list">
                @forelse($landlords as $landlord)
                    <div class="user-item" data-name="{{ strtolower($landlord->name) }}" data-id="{{ $landlord->id }}">
                        <div class="user-info">
                            <div class="user-avatar">
                                <img src="{{ asset('images/team1.jpg') }}" alt="{{ $landlord->name }}">
                                <span class="status-indicator active"></span>
                            </div>
                            <div class="user-details">
                                <h3>{{ $landlord->name }}</h3>
                                <p class="user-email">{{ $landlord->email }}</p>
                                @if($landlord->info && $landlord->info->contact_number)
                                    <p class="user-contact">{{ $landlord->info->contact_number }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="user-actions">
                            <button class="action-btn view-btn" title="View Details" onclick="viewUserDetails({{ $landlord->id }})">
                                <i class='bx bx-show'></i>
                            </button>
                            <button class="action-btn edit-btn" title="Edit User" onclick="editUser({{ $landlord->id }})">
                                <i class='bx bx-edit'></i>
                            </button>
                            <button class="action-btn delete-btn" title="Delete User" onclick="deleteUser({{ $landlord->id }}, 'landlord')">
                                <i class='bx bx-trash'></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="no-data">
                        <i class='bx bx-user-x'></i>
                        <p>No landlords found</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- View User Modal -->
<div class="modal-container" id="viewUserModal" style="display: none;">
    <div class="modal-card">
        <div class="modal-header">
            <h2 class="section-title">User Details</h2>
            <button class="close-btn" onclick="closeViewModal()">
                <i class='bx bx-x'></i>
            </button>
        </div>
        <div class="modal-content">
            <div class="user-profile">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <img src="{{ asset('images/team1.jpg') }}" alt="User Avatar" id="viewUserAvatar">
                    </div>
                    <div class="profile-info">
                        <h3 id="viewUserName"></h3>
                        <span class="role-badge" id="viewUserRole"></span>
                    </div>
                </div>
                <div class="profile-details">
                    <div class="detail-group">
                        <label>Email</label>
                        <p id="viewUserEmail"></p>
                    </div>
                    <div class="detail-group">
                        <label>Contact Number</label>
                        <p id="viewUserContact"></p>
                    </div>
                    <div class="detail-group">
                        <label>Birth Date</label>
                        <p id="viewUserBirthDate"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal-container" id="editUserModal" style="display: none;">
    <div class="modal-card">
        <div class="modal-header">
            <h2 class="section-title">Edit User</h2>
            <button class="close-btn" onclick="closeEditModal()">
                <i class='bx bx-x'></i>
            </button>
        </div>
        <div class="modal-content">
            <form id="editUserForm" onsubmit="updateUser(event)">
                @csrf
                @method('PUT')
                <input type="hidden" id="editUserId">
                <div class="form-grid">
                    <!-- Personal Information -->
                    <div class="form-section">
                        <h3 class="form-section-title">Personal Information</h3>
                        <div class="form-group">
                            <label for="edit_first_name">First Name</label>
                            <input type="text" id="edit_first_name" name="first_name" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_middle_name">Middle Name</label>
                            <input type="text" id="edit_middle_name" name="middle_name" class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="edit_last_name">Last Name</label>
                            <input type="text" id="edit_last_name" name="last_name" class="form-input" required>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="form-section">
                        <h3 class="form-section-title">Contact Information</h3>
                        <div class="form-group">
                            <label for="edit_email">Email Address</label>
                            <input type="email" id="edit_email" name="email" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_contact">Contact Number</label>
                            <input type="text" id="edit_contact" name="contact_number" class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="edit_birth_date">Birth Date</label>
                            <input type="date" id="edit_birth_date" name="birth_date" class="form-input">
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div class="form-section">
                        <h3 class="form-section-title">Role Assignment</h3>
                        <div class="form-group">
                            <label for="edit_role">User Role</label>
                            <select id="edit_role" name="role" class="form-select" required>
                                <option value="tenant">Tenant</option>
                                <option value="landlord">Landlord</option>
                            </select>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="submit-btn">
                                <i class='bx bx-save'></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Container Styles */
.admin-container {
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* Page Header */
.page-header {
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-content h1 {
    font-size: 1.75rem;
    color: #1a202c;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
}

.header-content h1 i {
    font-size: 2rem;
    color: #4299e1;
}

.add-user-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: #4299e1;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.add-user-btn:hover {
    background: #3182ce;
    transform: translateY(-1px);
}

/* Add User Form */
.add-user-form-container {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.add-user-card {
    background: white;
    border-radius: 16px;
    width: 90%;
    max-width: 1000px;
    max-height: 90vh;
    overflow-y: auto;
    padding: 2rem;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.close-btn {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #718096;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.close-btn:hover {
    background: #f7fafc;
    color: #4a5568;
}

/* Form Styles */
.form-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

.form-section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-section-title {
    color: #2d3748;
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0 0 1rem 0;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: #4a5568;
    font-weight: 500;
}

.form-input,
.form-select {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.95rem;
    color: #2d3748;
    background: #f8fafc;
    transition: all 0.3s ease;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
    background: white;
}

.error-message {
    color: #e53e3e;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.form-actions {
    margin-top: 1rem;
}

.submit-btn {
    width: 100%;
    padding: 0.75rem;
    background: #4299e1;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.submit-btn:hover {
    background: #3182ce;
    transform: translateY(-1px);
}

/* Users Grid */
.users-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
}

.users-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
    font-size: 1.25rem;
    color: #2d3748;
}

.user-count {
    background: #ebf8ff;
    color: #2b6cb0;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    margin-left: 0.5rem;
}

.card-actions {
    margin-top: 1rem;
}

.search-box {
    position: relative;
}

.search-box i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #a0aec0;
}

.search-box input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.95rem;
    background: #f8fafc;
}

.search-box input:focus {
    outline: none;
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

/* Users List */
.users-list {
    padding: 1rem;
    max-height: 600px;
    overflow-y: auto;
}

.user-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
}

.user-item:hover {
    background: #f7fafc;
    transform: translateX(5px);
}

.user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-avatar {
    position: relative;
    width: 48px;
    height: 48px;
}

.user-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}

.status-indicator {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
}

.status-indicator.active {
    background: #48bb78;
}

.user-details h3 {
    margin: 0;
    color: #2d3748;
    font-size: 1rem;
    font-weight: 500;
}

.user-email {
    margin: 0;
    color: #718096;
    font-size: 0.875rem;
}

.user-actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.action-btn {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
    background: none;
}

.action-btn i {
    font-size: 1.2rem;
}

.view-btn {
    background: #ebf8ff;
    color: #3182ce;
}

.view-btn:hover {
    background: #bee3f8;
}

.edit-btn {
    background: #e6fffa;
    color: #319795;
}

.edit-btn:hover {
    background: #b2f5ea;
}

.delete-btn {
    background: #fff5f5;
    color: #e53e3e;
}

.delete-btn:hover {
    background: #fed7d7;
}

.delete-form {
    margin: 0;
    padding: 0;
    display: inline-flex;
}

.no-data {
    text-align: center;
    padding: 3rem 1rem;
    color: #a0aec0;
}

.no-data i {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.no-data p {
    margin: 0;
    font-size: 1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .admin-container {
        padding: 1rem;
    }

    .header-content {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .users-grid {
        grid-template-columns: 1fr;
    }

    .user-item {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .user-info {
        flex-direction: column;
    }

    .user-actions {
        width: 100%;
        justify-content: center;
    }
}

/* Modal Styles */
.modal-container {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-card {
    background: white;
    border-radius: 16px;
    width: 90%;
    max-width: 1000px;
    max-height: 90vh;
    overflow-y: auto;
    padding: 2rem;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.modal-content {
    margin-top: 1rem;
}

/* User Profile Styles */
.user-profile {
    padding: 1rem;
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 2rem;
    margin-bottom: 2rem;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-info h3 {
    margin: 0;
    font-size: 1.5rem;
    color: #2d3748;
}

.role-badge {
    display: inline-block;
    padding: 0.25rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    margin-top: 0.5rem;
}

.role-badge.tenant {
    background: #ebf8ff;
    color: #2b6cb0;
}

.role-badge.landlord {
    background: #e6fffa;
    color: #319795;
}

.profile-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.detail-group {
    margin-bottom: 1rem;
}

.detail-group label {
    display: block;
    font-size: 0.875rem;
    color: #718096;
    margin-bottom: 0.25rem;
}

.detail-group p {
    margin: 0;
    color: #2d3748;
    font-size: 1rem;
}

/* Add notification styles */
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 20px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
    color: white;
    transform: translateX(120%);
    transition: transform 0.3s ease;
    z-index: 1000;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.notification.success {
    background: #48bb78;
}

.notification.error {
    background: #e53e3e;
}

.notification.show {
    transform: translateX(0);
}

.notification i {
    font-size: 1.2rem;
}

/* Add transition for user items */
.user-item {
    transition: all 0.3s ease;
}
</style>

<script>
function toggleAddUserForm() {
    const form = document.getElementById('addUserForm');
    form.style.display = form.style.display === 'none' ? 'flex' : 'none';
}

function filterUsers(input, listId) {
    const filter = input.value.toLowerCase();
    const list = document.getElementById(listId);
    const items = list.getElementsByClassName('user-item');

    for (let item of items) {
        const name = item.getAttribute('data-name');
        if (name.includes(filter)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    }
}

function viewUserDetails(userId) {
    fetch(`/admin/users/${userId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('viewUserName').textContent = `${data.info.first_name} ${data.info.last_name}`;
            document.getElementById('viewUserEmail').textContent = data.user.email;
            document.getElementById('viewUserContact').textContent = data.info.contact_number || 'Not provided';
            document.getElementById('viewUserBirthDate').textContent = data.info.birth_date || 'Not provided';
            
            const roleBadge = document.getElementById('viewUserRole');
            roleBadge.textContent = data.role.charAt(0).toUpperCase() + data.role.slice(1);
            roleBadge.className = `role-badge ${data.role}`;
            
            document.getElementById('viewUserAvatar').src = "{{ asset('images/team1.jpg') }}";
            document.getElementById('viewUserModal').style.display = 'flex';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load user details. Please try again.');
        });
}

function editUser(userId) {
    fetch(`/admin/users/${userId}/edit`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('editUserId').value = userId;
            document.getElementById('edit_first_name').value = data.info.first_name;
            document.getElementById('edit_middle_name').value = data.info.middle_name || '';
            document.getElementById('edit_last_name').value = data.info.last_name;
            document.getElementById('edit_email').value = data.user.email;
            document.getElementById('edit_contact').value = data.info.contact_number || '';
            document.getElementById('edit_birth_date').value = data.info.birth_date || '';
            document.getElementById('edit_role').value = data.role;
            
            document.getElementById('editUserModal').style.display = 'flex';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load user details. Please try again.');
        });
}

function updateUser(event) {
    event.preventDefault();
    const userId = document.getElementById('editUserId').value;
    const formData = new FormData(document.getElementById('editUserForm'));
    formData.append('_method', 'PUT'); // Add PUT method override
    
    // Get all form data and create a proper object
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });
    
    fetch(`/admin/users/${userId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        alert(data.message);
        closeEditModal();
        window.location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        let errorMessage = 'Failed to update user. ';
        if (error.errors) {
            Object.values(error.errors).forEach(err => {
                errorMessage += err.join('. ');
            });
        }
        alert(errorMessage);
    });
}

function closeViewModal() {
    document.getElementById('viewUserModal').style.display = 'none';
}

function closeEditModal() {
    document.getElementById('editUserModal').style.display = 'none';
}

function deleteUser(userId, userType) {
    if (confirm(`Are you sure you want to delete this ${userType}?`)) {
        // Get the user item element
        const userItem = document.querySelector(`.user-item[data-id="${userId}"]`);
        if (userItem) {
            // Add loading state
            userItem.style.opacity = '0.5';
            userItem.style.pointerEvents = 'none';
        }

        fetch(`/admin/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            // Show success message
            showNotification(data.message, 'success');
            
            // Remove the user item with animation
            if (userItem) {
                userItem.style.transition = 'all 0.3s ease';
                userItem.style.opacity = '0';
                userItem.style.transform = 'translateX(-20px)';
                setTimeout(() => {
                    userItem.remove();
                    
                    // Update the user count
                    const listId = userType === 'tenant' ? 'tenants-list' : 'landlords-list';
                    const countElement = document.querySelector(`#${listId}`).closest('.users-card').querySelector('.user-count');
                    const currentCount = parseInt(countElement.textContent) - 1;
                    countElement.textContent = currentCount;
                    
                    // Show no data message if no users left
                    const list = document.getElementById(listId);
                    if (list.querySelectorAll('.user-item').length === 0) {
                        const noData = document.createElement('div');
                        noData.className = 'no-data';
                        noData.innerHTML = `
                            <i class='bx bx-user-x'></i>
                            <p>No ${userType}s found</p>
                        `;
                        list.appendChild(noData);
                    }
                }, 300);
            }
        })
        .catch(error => {
            // Reset loading state if there was an error
            if (userItem) {
                userItem.style.opacity = '1';
                userItem.style.pointerEvents = 'auto';
            }
            
            // Show error message
            showNotification(error.message || 'Error deleting user', 'error');
        });
    }
}

// Add notification function
function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <i class='bx ${type === 'success' ? 'bx-check' : 'bx-x'}'></i>
        <span>${message}</span>
    `;
    
    // Add to document
    document.body.appendChild(notification);
    
    // Trigger animation
    setTimeout(() => notification.classList.add('show'), 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>

@endsection
@extends('admin.dashboard')

@section('content')
<!-- Add Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="admin-container">
    <!-- Add User Section -->
    <div class="card add-user-card">
        <h2 class="section-title">Add New User</h2>
        <form action="{{ route('users.store') }}" method="POST" class="add-user-form">
            @csrf
            <div class="form-grid">
                <!-- Personal Information -->
                <div class="form-section">
                    <h3 class="form-section-title">Personal Information</h3>
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-input">
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
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="form-input">
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
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input">
                        @error('email')
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

                    <div class="form-group">
                        <label for="contact">Contact Number</label>
                        <input type="text" name="contact" id="contact" value="{{ old('contact') }}" class="form-input">
                        @error('contact')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Role Selection -->
                <div class="form-section">
                    <h3 class="form-section-title">Role Assignment</h3>
                    <div class="form-group">
                        <label for="role">User Role</label>
                        <select name="role" id="role" class="form-select">
                            <option value="">Select Role</option>
                            <option value="landlord" {{ old('role') == 'landlord' ? 'selected' : '' }}>Landlord</option>
                            <option value="tenant" {{ old('role') == 'tenant' ? 'selected' : '' }}>Tenant</option>
                        </select>
                        @error('role')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="submit-btn" onclick="this.disabled=true; this.form.submit();">
                        <i class="fas fa-user-plus"></i> Add User
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Users List Section -->
    <div class="users-grid">
        <!-- Tenants Section -->
        <div class="card users-card">
            <div class="card-header">
                <h2 class="section-title">
                    <i class="fas fa-users"></i> Tenants
                    <span class="user-count">{{ count($tenants) }}</span>
                </h2>
            </div>
            <div class="users-list">
                @foreach ($tenants as $tenant)
                    <div class="user-item">
                        <div class="user-info">
                            <div class="user-avatar">
                                <img src="{{ asset('images/2.jpg') }}" alt="{{ $tenant->name }}">
                            </div>
                            <div class="user-details">
                                <h3>{{ $tenant->name }}</h3>
                                <p class="user-email">{{ $tenant->email }}</p>
                            </div>
                        </div>
                        <div class="user-actions">
                            <a href="{{ route('users.edit', $tenant->id) }}" class="edit-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('users.destroy', $tenant->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tenant?')" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Landlords Section -->
        <div class="card users-card">
            <div class="card-header">
                <h2 class="section-title">
                    <i class="fas fa-home"></i> Landlords
                    <span class="user-count">{{ count($landlords) }}</span>
                </h2>
            </div>
            <div class="users-list">
                @foreach ($landlords as $landlord)
                    <div class="user-item">
                        <div class="user-info">
                            <div class="user-avatar">
                                <img src="{{ asset('images/2.jpg') }}" alt="{{ $landlord->name }}">
                            </div>
                            <div class="user-details">
                                <h3>{{ $landlord->name }}</h3>
                                <p class="user-email">{{ $landlord->email }}</p>
                            </div>
                        </div>
                        <div class="user-actions">
                            <a href="{{ route('users.edit', $landlord->id) }}" class="edit-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('users.destroy', $landlord->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this landlord?')" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .admin-container {
        padding: 1rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .section-title {
        color: #1a1a1a;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        max-width: 100%;
    }

    .form-section {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        min-width: 0; /* Prevents flex items from overflowing */
    }

    .form-section-title {
        color: #4a5568;
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .form-group {
        margin-bottom: 1rem;
        width: 100%;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.25rem;
        color: #4a5568;
        font-weight: 500;
    }

    .form-input,
    .form-select {
        width: 100%;
        height: 38px; /* Fixed height for consistency */
        padding: 0.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background-color: #f8fafc;
        box-sizing: border-box; /* Include padding in width calculation */
    }

    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
        background-color: white;
    }

    .error-message {
        color: #e53e3e;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .submit-btn {
        background-color: #4299e1;
        color: white;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.75rem;
    }

    .submit-btn:hover {
        background-color: #3182ce;
        transform: translateY(-1px);
    }

    .users-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1rem;
    }

    .users-card {
        height: fit-content;
    }

    .card-header {
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .user-count {
        background: #ebf8ff;
        color: #4299e1;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.875rem;
        margin-left: 0.5rem;
    }

    .users-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .user-item {
        display: flex;
        align-items: center; /* Center align all items vertically */
        justify-content: space-between;
        padding: 0.75rem 1rem;
        background: #f8fafc;
        border-radius: 6px;
        transition: all 0.3s ease;
        height: 60px; /* Fixed height for consistency */
    }

    .user-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
        min-width: 0; /* Prevents flex items from overflowing */
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0; /* Prevents avatar from shrinking */
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-details {
        flex: 1;
        min-width: 0; /* Prevents text overflow */
    }

    .user-details h3 {
        color: #2d3748;
        font-size: 0.95rem;
        font-weight: 500;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-email {
        color: #718096;
        font-size: 0.85rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        margin-left: 1rem;
        flex-shrink: 0; /* Prevents buttons from shrinking */
    }

    .delete-form {
        margin: 0;
    }

    .edit-btn {
        background: #e6f0ff;
        color: #3182ce;
        border: none;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 32px; /* Fixed width */
        height: 32px; /* Fixed height */
    }

    .edit-btn:hover {
        background: #bfdbfe;
        transform: scale(1.05);
    }

    .delete-btn {
        background: #fff1f2;
        color: #ef4444;
        border: none;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 32px; /* Fixed width */
        height: 32px; /* Fixed height */
    }

    .delete-btn:hover {
        background: #fee2e2;
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .admin-container {
            padding: 1rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
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
            display: flex;
            justify-content: center;
        }
    }
</style>

@endsection
@extends('tenant.dashboard')

@section('content')
<div class="account-container">
    <div class="page-header">
        <h2>My Account</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="account-content">
        <!-- Personal Information Section -->
        <div class="account-section">
            <h3>Personal Information</h3>
            <div class="info-card">
                <div class="info-item">
                    <span class="label">Name:</span>
                    <span class="value">{{ auth()->user()->name }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Email:</span>
                    <span class="value">{{ auth()->user()->email }}</span>
                </div>
            </div>
        </div>

        <!-- My Applications Section -->
        <div class="account-section">
            <h3>My Rental Applications</h3>
            @if($applications->count() > 0)
                <div class="applications-grid">
                    @foreach($applications as $application)
                        <div class="application-card">
                            <div class="property-image">
                                @if($application->rental->images && $application->rental->images->where('is_front_image', true)->first())
                                    @php
                                        $frontImage = $application->rental->images->where('is_front_image', true)->first();
                                        $imagePath = str_replace('public/', '', $frontImage->image_url);
                                    @endphp
                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Property Image" onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                                @else
                                    <img src="{{ asset('images/placeholder.jpg') }}" alt="Property Image">
                                @endif
                                <div class="status-badge {{ $application->status }}">
                                    {{ ucfirst($application->status) }}
                                </div>
                            </div>
                            <div class="application-details">
                                <h4>{{ $application->rental->address }}</h4>
                                <div class="detail-row">
                                    <i class="bx bx-calendar"></i>
                                    <span>Applied on {{ $application->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="detail-row">
                                    <i class="bx bx-money"></i>
                                    <span>₱{{ number_format($application->total_amount, 2) }}/month</span>
                                </div>
                                <div class="detail-row">
                                    <i class="bx bx-time"></i>
                                    <span>{{ $application->rental_period_start->format('M d, Y') }} to {{ $application->rental_period_end->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <div class="application-actions">
                                <a href="{{ route('tenant.rental.show', $application->rental->id) }}" class="view-btn">
                                    <i class="bx bx-show"></i> View Property
                                </a>
                                @if($application->status === 'pending')
                                    <form action="{{ route('transaction.cancel', $application->id) }}" method="POST" class="cancel-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cancel-btn" onclick="return confirm('Are you sure you want to cancel this application?')">
                                            <i class="bx bx-x"></i> Cancel Application
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-applications">
                    <p>You haven't applied for any properties yet.</p>
                    <a href="{{ route('tenant.history') }}" class="browse-btn">Browse Properties</a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.account-container {
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.page-header {
    margin-bottom: 2rem;
}

.page-header h2 {
    color: #2D3748;
    font-size: 1.875rem;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.alert-success {
    background-color: #C6F6D5;
    color: #2F855A;
    border: 1px solid #9AE6B4;
}

.alert-error {
    background-color: #FED7D7;
    color: #C53030;
    border: 1px solid #FEB2B2;
}

.account-section {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.account-section h3 {
    color: #2D3748;
    margin-bottom: 1.5rem;
    font-size: 1.25rem;
}

.info-card {
    background: #F7FAFC;
    border-radius: 8px;
    padding: 1.5rem;
}

.info-item {
    display: flex;
    margin-bottom: 1rem;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-item .label {
    font-weight: 600;
    width: 120px;
    color: #4A5568;
}

.applications-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.application-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #E2E8F0;
    transition: transform 0.2s;
}

.application-card:hover {
    transform: translateY(-2px);
}

.property-image {
    position: relative;
    height: 200px;
}

.property-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.status-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-badge.pending {
    background: #FEF3C7;
    color: #92400E;
}

.status-badge.approved {
    background: #C6F6D5;
    color: #2F855A;
}

.status-badge.rejected {
    background: #FED7D7;
    color: #C53030;
}

.application-details {
    padding: 1.5rem;
}

.application-details h4 {
    color: #2D3748;
    margin-bottom: 1rem;
    font-size: 1.125rem;
}

.detail-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #4A5568;
    margin-bottom: 0.5rem;
}

.detail-row i {
    color: #718096;
}

.application-actions {
    padding: 1rem 1.5rem;
    border-top: 1px solid #E2E8F0;
    display: flex;
    gap: 1rem;
}

.view-btn, .cancel-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s;
}

.view-btn {
    background: #EDF2F7;
    color: #4A5568;
    text-decoration: none;
}

.view-btn:hover {
    background: #E2E8F0;
}

.cancel-btn {
    background: #FED7D7;
    color: #C53030;
    border: none;
}

.cancel-btn:hover {
    background: #FEB2B2;
}

.no-applications {
    text-align: center;
    padding: 3rem;
    background: #F7FAFC;
    border-radius: 8px;
    color: #718096;
}

.browse-btn {
    display: inline-block;
    margin-top: 1rem;
    padding: 0.75rem 1.5rem;
    background: #4299E1;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    transition: background-color 0.3s;
}

.browse-btn:hover {
    background: #3182CE;
}

@media (max-width: 768px) {
    .account-container {
        padding: 1rem;
    }

    .applications-grid {
        grid-template-columns: 1fr;
    }

    .application-actions {
        flex-direction: column;
    }
}
</style>
@endsection
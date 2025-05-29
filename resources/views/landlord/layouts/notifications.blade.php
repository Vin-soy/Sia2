@extends('landlord.dashboard')

@section('content')
<div class="notifications-container">
    <div class="page-header">
        <div class="header-content">
            <h1>
                <i class='bx bx-bell notification-icon'></i>
                Rental Applications
                @if(isset($pendingApplications) && $pendingApplications > 0)
                    <span class="notification-badge">{{ $pendingApplications }}</span>
                @endif
            </h1>
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="pending">Pending</button>
                <button class="filter-btn" data-filter="approved">Approved</button>
                <button class="filter-btn" data-filter="cancelled">Cancelled</button>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="bx bx-check-circle"></i>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <i class="bx bx-error-circle"></i>
        <p>{{ session('error') }}</p>
    </div>
    @endif

    <div class="applications-list">
        @forelse($applications as $application)
        <div class="application-card" data-status="{{ strtolower($application->status) }}">
            <div class="application-header">
                <div class="applicant-info">
                    <img src="{{ asset('images/placeholder-avatar.jpg') }}" alt="Tenant Photo" class="applicant-photo">
                    <div class="applicant-details">
                        <h3>{{ $application->tenant->name }}</h3>
                        <span class="application-date">Applied on {{ $application->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
                <div class="status-badge {{ strtolower($application->status) }}">
                    {{ ucfirst($application->status) }}
                </div>
            </div>

            <div class="property-summary">
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
                </div>
                <div class="property-info">
                    <h4>{{ $application->rental->address }}</h4>
                    <div class="rental-details">
                        <span>{{ $application->rental->house_type }}</span>
                        <span>{{ $application->rental->number_of_rooms }} {{ Str::plural('room', $application->rental->number_of_rooms) }}</span>
                        <span>₱{{ number_format($application->rental->price, 2) }}/month</span>
                    </div>
                    <div class="rental-period">
                        <i class='bx bx-calendar'></i>
                        <span>{{ $application->rental_period_start->format('M d, Y') }} - {{ $application->rental_period_end->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="application-actions">
                @if($application->status === 'pending')
                <form action="{{ route('landlord.applications.approve', $application->id) }}" method="POST" class="action-form" onsubmit="return confirm('Are you sure you want to approve this application? This will automatically cancel all other pending applications for this property.');">
                    @csrf
                    <button type="submit" class="approve-btn">
                        <i class='bx bx-check'></i> Approve
                    </button>
                </form>
                <form action="{{ route('landlord.applications.reject', $application->id) }}" method="POST" class="action-form" onsubmit="return confirm('Are you sure you want to cancel this application?');">
                    @csrf
                    <button type="submit" class="reject-btn">
                        <i class='bx bx-x'></i> Cancel
                    </button>
                </form>
                @endif
                <a href="{{ route('rentals.show', $application->rental->id) }}" class="view-btn">
                    <i class='bx bx-show'></i> View Property
                </a>
            </div>
        </div>
        @empty
        <div class="no-applications">
            <div class="no-applications-content">
                <i class="bx bx-file"></i>
                <h3>No Applications Yet</h3>
                <p>When tenants apply for your properties, they will appear here</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
.notifications-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 24px;
}

.page-header {
    margin-bottom: 32px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.header-content h1 {
    font-size: 32px;
    font-weight: 600;
    color: #222222;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
}

.notification-icon {
    font-size: 32px;
    color: #4a5568;
}

.notification-badge {
    position: absolute;
    top: -5px;
    left: 20px;
    background: #dc2626;
    color: white;
    font-size: 12px;
    font-weight: 500;
    width: 20px;
    height: 20px;
    padding: 0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.filter-buttons {
    display: flex;
    gap: 12px;
}

.filter-btn {
    padding: 8px 16px;
    border: none;
    border-radius: 8px;
    background: #f3f4f6;
    color: #4b5563;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.filter-btn:hover {
    background: #e5e7eb;
}

.filter-btn.active {
    background: #222222;
    color: white;
}

.alert {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    border-radius: 12px;
    margin-bottom: 24px;
}

.alert-success {
    background-color: #F0FDF4;
    border: 1px solid #BBF7D0;
}

.alert-error {
    background-color: #FEF2F2;
    border: 1px solid #FECACA;
}

.alert i {
    font-size: 20px;
}

.alert-success i {
    color: #16A34A;
}

.alert-error i {
    color: #DC2626;
}

.alert p {
    margin: 0;
    color: #374151;
}

.application-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.application-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.applicant-info {
    display: flex;
    align-items: center;
    gap: 16px;
}

.applicant-photo {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
}

.applicant-details h3 {
    margin: 0;
    font-size: 18px;
    color: #222222;
}

.application-date {
    font-size: 14px;
    color: #6b7280;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 99px;
    font-size: 14px;
    font-weight: 500;
    color: white;
}

.status-badge.pending {
    background: #eab308;
}

.status-badge.approved {
    background: #22c55e;
}

.status-badge.cancelled {
    background: #ef4444;
}

.property-summary {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    padding: 16px;
    background: #f8fafc;
    border-radius: 8px;
}

.property-image {
    width: 120px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
}

.property-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.property-info h4 {
    margin: 0 0 8px 0;
    font-size: 16px;
    color: #222222;
}

.rental-details {
    display: flex;
    gap: 16px;
    margin-bottom: 8px;
}

.rental-details span {
    font-size: 14px;
    color: #6b7280;
}

.rental-period {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #6b7280;
}

.application-actions {
    display: flex;
    gap: 12px;
}

.action-form {
    margin: 0;
}

.approve-btn, .reject-btn, .view-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.approve-btn {
    background: #22c55e;
    color: white;
}

.reject-btn {
    background: #ef4444;
    color: white;
}

.view-btn {
    background: #222222;
    color: white;
    text-decoration: none;
}

.approve-btn:hover, .reject-btn:hover, .view-btn:hover {
    transform: translateY(-1px);
}

.no-applications {
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #F8FAFC;
    border-radius: 16px;
    border: 2px dashed #E2E8F0;
}

.no-applications-content {
    text-align: center;
    padding: 48px 24px;
}

.no-applications i {
    font-size: 48px;
    color: #94A3B8;
    margin-bottom: 16px;
}

.no-applications h3 {
    font-size: 24px;
    font-weight: 600;
    color: #222222;
    margin: 0 0 8px 0;
}

.no-applications p {
    font-size: 16px;
    color: #666666;
    margin: 0;
}

@media (max-width: 768px) {
    .notifications-container {
        padding: 16px;
    }

    .header-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .property-summary {
        flex-direction: column;
    }

    .property-image {
        width: 100%;
        height: 200px;
    }

    .application-actions {
        flex-direction: column;
    }

    .approve-btn, .reject-btn, .view-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const applications = document.querySelectorAll('.application-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // Filter applications
            const filter = button.dataset.filter;
            applications.forEach(app => {
                if (filter === 'all' || app.dataset.status === filter) {
                    app.style.display = 'block';
                } else {
                    app.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endsection 
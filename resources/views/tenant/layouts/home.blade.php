@extends('tenant.dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Overview Section -->
    <div class="overview-section">
        <div class="overview-card active-rentals">
            <i class='bx bx-home-alt'></i>
            <div class="card-content">
                <h3>Active Rentals</h3>
                <p class="number">{{ $activeRentals ?? 0 }}</p>
            </div>
        </div>
        <div class="overview-card pending-applications">
            <i class='bx bx-time'></i>
            <div class="card-content">
                <h3>Pending Applications</h3>
                <p class="number">{{ $pendingApplications ?? 0 }}</p>
            </div>
        </div>
        <div class="overview-card total-spent">
            <i class='bx bx-money'></i>
            <div class="card-content">
                <h3>Monthly Rent</h3>
                <p class="number">₱{{ number_format($totalMonthlyRent ?? 0, 2) }}</p>
            </div>
        </div>
        <div class="overview-card next-payment">
            <i class='bx bx-calendar'></i>
            <div class="card-content">
                <h3>Next Payment</h3>
                <p class="date">{{ $nextPaymentDate ?? 'No active rentals' }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="dashboard-grid">
        <!-- Active Rentals Section -->
        <div class="dashboard-section rentals-section">
            <div class="section-header">
                <h2><i class='bx bx-building-house'></i> My Active Rentals</h2>
                <a href="{{ route('tenant.history') }}" class="view-all-btn">View All</a>
            </div>
            <div class="rentals-list">
                @if(isset($activeRentals) && $activeRentals > 0)
                    @foreach($rentals as $rental)
                    <div class="rental-card">
                        <div class="rental-image">
                            @if($rental->images && $rental->images->where('is_front_image', true)->first())
                                @php
                                    $frontImage = $rental->images->where('is_front_image', true)->first();
                                    $imagePath = str_replace('public/', '', $frontImage->image_url);
                                @endphp
                                <img src="{{ asset('storage/' . $imagePath) }}" alt="Property Image" onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                            @else
                                <img src="{{ asset('images/placeholder.jpg') }}" alt="Property Image">
                            @endif
                        </div>
                        <div class="rental-details">
                            <h4>{{ $rental->address }}</h4>
                            <div class="rental-meta">
                                <span><i class='bx bx-building-house'></i> {{ ucfirst($rental->house_type) }}</span>
                                <span><i class='bx bx-door-open'></i> {{ $rental->number_of_rooms }} {{ Str::plural('Room', $rental->number_of_rooms) }}</span>
                            </div>
                            <div class="rental-price">
                                <i class='bx bx-money'></i>
                                <span>₱{{ number_format($rental->price, 2) }}/month</span>
                            </div>
                            <div class="rental-actions">
                                <a href="{{ route('tenant.rental.show', $rental->id) }}" class="view-btn">
                                    <i class='bx bx-show'></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="no-rentals">
                        <div class="no-rentals-content">
                            <i class='bx bx-building-house'></i>
                            <h3>No Active Rentals</h3>
                            <p>Start by browsing available properties</p>
                            <a href="{{ route('tenant.history') }}" class="browse-btn">
                                Browse Properties
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Applications Section -->
        <div class="dashboard-section applications-section">
            <div class="section-header">
                <h2><i class='bx bx-file'></i> Recent Applications</h2>
                <a href="{{ route('tenant.account') }}" class="view-all-btn">View All</a>
            </div>
            <div class="applications-list">
                @if(isset($recentApplications) && count($recentApplications) > 0)
                    @foreach($recentApplications as $application)
                    <div class="application-card">
                        <div class="application-header">
                            <div class="property-info">
                                <h4>{{ $application->rental->address }}</h4>
                                <span class="application-date">Applied {{ $application->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="status-badge {{ strtolower($application->status) }}">
                                {{ ucfirst($application->status) }}
                            </div>
                        </div>
                        <div class="application-details">
                            <div class="detail-row">
                                <i class='bx bx-money'></i>
                                <span>₱{{ number_format($application->rental->price, 2) }}/month</span>
                            </div>
                            <div class="detail-row">
                                <i class='bx bx-calendar'></i>
                                <span>{{ $application->rental_period_start->format('M d, Y') }} - {{ $application->rental_period_end->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="no-applications">
                        <div class="no-applications-content">
                            <i class='bx bx-file'></i>
                            <h3>No Recent Applications</h3>
                            <p>Your rental applications will appear here</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 24px;
}

/* Overview Section */
.overview-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.overview-card {
    background: white;
    padding: 1.5rem;
    border-radius: 16px;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.overview-card:hover {
    transform: translateY(-5px);
}

.overview-card i {
    font-size: 2.5rem;
    padding: 1rem;
    border-radius: 12px;
    color: white;
}

.active-rentals i {
    background: linear-gradient(135deg, #4299e1, #3182ce);
}

.pending-applications i {
    background: linear-gradient(135deg, #ed8936, #dd6b20);
}

.total-spent i {
    background: linear-gradient(135deg, #48bb78, #38a169);
}

.next-payment i {
    background: linear-gradient(135deg, #667eea, #5a67d8);
}

.card-content h3 {
    color: #4a5568;
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

.card-content .number {
    font-size: 1.75rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0;
}

.card-content .date {
    font-size: 1.25rem;
    font-weight: 500;
    color: #2d3748;
    margin: 0;
}

/* Dashboard Grid */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
}

.dashboard-section {
    background: white;
    border-radius: 16px;
    padding: 1.75rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.75rem;
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

.view-all-btn {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.875rem;
    background: #edf2f7;
    color: #4a5568;
    transition: all 0.3s ease;
}

.view-all-btn:hover {
    background: #e2e8f0;
    transform: translateY(-2px);
}

/* Rentals Section */
.rentals-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.rental-card {
    display: flex;
    gap: 1.5rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.rental-card:hover {
    transform: translateX(5px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.rental-image {
    width: 150px;
    height: 100px;
    border-radius: 8px;
    overflow: hidden;
}

.rental-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.rental-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.rental-details h4 {
    margin: 0;
    font-size: 1.125rem;
    color: #2d3748;
}

.rental-meta {
    display: flex;
    gap: 1rem;
    color: #718096;
    font-size: 0.875rem;
}

.rental-meta span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.rental-price {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #2d3748;
    font-weight: 600;
    font-size: 1.125rem;
}

.rental-actions {
    margin-top: auto;
}

.view-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    background: #4299e1;
    color: white;
    text-decoration: none;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.view-btn:hover {
    background: #3182ce;
    transform: translateY(-2px);
}

/* Applications Section */
.applications-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.application-card {
    padding: 1rem;
    background: #f8fafc;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.application-card:hover {
    transform: translateX(5px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.application-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.75rem;
}

.property-info h4 {
    margin: 0 0 0.25rem 0;
    font-size: 1rem;
    color: #2d3748;
}

.application-date {
    font-size: 0.875rem;
    color: #718096;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: capitalize;
}

.status-badge.pending {
    background: #fef3c7;
    color: #92400e;
}

.status-badge.approved {
    background: #def7ec;
    color: #03543f;
}

.status-badge.cancelled {
    background: #fde8e8;
    color: #9b1c1c;
}

.application-details {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.detail-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #4a5568;
    font-size: 0.875rem;
}

/* Empty States */
.no-rentals, .no-applications {
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    border-radius: 12px;
    border: 2px dashed #e2e8f0;
}

.no-rentals-content, .no-applications-content {
    text-align: center;
    padding: 2rem;
}

.no-rentals-content i, .no-applications-content i {
    font-size: 2.5rem;
    color: #a0aec0;
    margin-bottom: 1rem;
}

.no-rentals-content h3, .no-applications-content h3 {
    font-size: 1.25rem;
    color: #2d3748;
    margin: 0 0 0.5rem 0;
}

.no-rentals-content p, .no-applications-content p {
    color: #718096;
    margin: 0 0 1rem 0;
}

.browse-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: #4299e1;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.browse-btn:hover {
    background: #3182ce;
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 1rem;
    }

    .overview-section {
        grid-template-columns: 1fr;
    }

    .dashboard-grid {
        grid-template-columns: 1fr;
    }

    .rental-card {
        flex-direction: column;
    }

    .rental-image {
        width: 100%;
        height: 200px;
    }

    .rental-meta {
        flex-wrap: wrap;
    }
}
</style>
@endsection
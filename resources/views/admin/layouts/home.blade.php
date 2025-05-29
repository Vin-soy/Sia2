@extends('admin.dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Overview Cards -->
    <div class="overview-section">
        <div class="overview-card total-properties">
            <i class='bx bx-building-house'></i>
            <div class="card-content">
                <h3>Total Properties</h3>
                <p class="number">{{ $totalProperties }}</p>
            </div>
        </div>
        <div class="overview-card available">
            <i class='bx bx-check-circle'></i>
            <div class="card-content">
                <h3>Available</h3>
                <p class="number">{{ $availableProperties }}</p>
            </div>
        </div>
        <div class="overview-card rented">
            <i class='bx bx-home'></i>
            <div class="card-content">
                <h3>Rented</h3>
                <p class="number">{{ $rentedProperties }}</p>
            </div>
        </div>
        <div class="overview-card maintenance">
            <i class='bx bx-wrench'></i>
            <div class="card-content">
                <h3>Under Maintenance</h3>
                <p class="number">{{ $underMaintenanceProperties }}</p>
            </div>
        </div>
    </div>

    <!-- Users Overview -->
    <div class="users-overview">
        <div class="overview-card landlords">
            <i class='bx bx-user'></i>
            <div class="card-content">
                <h3>Total Landlords</h3>
                <p class="number">{{ $totalLandlords }}</p>
            </div>
        </div>
        <div class="overview-card tenants">
            <i class='bx bx-group'></i>
            <div class="card-content">
                <h3>Total Tenants</h3>
                <p class="number">{{ $totalTenants }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="dashboard-grid">
        <!-- Recent Properties Section -->
        <div class="dashboard-section properties-section">
            <div class="section-header">
                <h2><i class='bx bx-building-house'></i> Recent Properties</h2>
                <a href="{{ route('admin.listings') }}" class="view-all-btn">View All</a>
            </div>
            <div class="properties-list">
                @forelse($recentProperties as $property)
                    <div class="property-card">
                        <div class="property-image">
                            @if($property->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $property->images->first()->image_url) }}" 
                                     alt="Property Image" 
                                     onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                            @else
                                <img src="{{ asset('images/placeholder.jpg') }}" alt="Property Image">
                            @endif
                            <div class="property-status {{ strtolower($property->status) }}">
                                {{ ucfirst($property->status) }}
                            </div>
                        </div>
                        <div class="property-details">
                            <h4>{{ $property->address }}</h4>
                            <div class="property-meta">
                                <span><i class='bx bx-building-house'></i> {{ ucfirst($property->house_type) }}</span>
                                <span><i class='bx bx-bed'></i> {{ $property->number_of_rooms }} {{ Str::plural('Room', $property->number_of_rooms) }}</span>
                            </div>
                            <div class="property-price">
                                <i class='bx bx-money'></i>
                                <span>₱{{ number_format($property->price, 2) }}/month</span>
                            </div>
                            <div class="property-owner">
                                <i class='bx bx-user'></i>
                                <span>{{ $property->landlord->name }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-data">
                        <i class='bx bx-building-house'></i>
                        <p>No properties listed yet</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Applications Section -->
        <div class="dashboard-section applications-section">
            <div class="section-header">
                <h2><i class='bx bx-file'></i> Recent Applications</h2>
                <a href="#" class="view-all-btn">View All</a>
            </div>
            <div class="applications-list">
                @forelse($recentApplications as $application)
                    <div class="application-card">
                        <div class="application-header">
                            <div class="applicant-info">
                                <i class='bx bx-user'></i>
                                <span>{{ $application->tenant->name }}</span>
                            </div>
                            <div class="status-badge {{ $application->status }}">
                                {{ ucfirst($application->status) }}
                            </div>
                        </div>
                        <div class="application-details">
                            <h4>{{ $application->rental->address }}</h4>
                            <div class="detail-row">
                                <i class='bx bx-calendar'></i>
                                <span>Applied {{ $application->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="detail-row">
                                <i class='bx bx-money'></i>
                                <span>₱{{ number_format($application->total_amount, 2) }}/month</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-data">
                        <i class='bx bx-file'></i>
                        <p>No pending applications</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-container {
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* Overview Section */
.overview-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.users-overview {
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

.total-properties i {
    background: linear-gradient(135deg, #4299e1, #3182ce);
}

.available i {
    background: linear-gradient(135deg, #48bb78, #38a169);
}

.rented i {
    background: linear-gradient(135deg, #ed8936, #dd6b20);
}

.maintenance i {
    background: linear-gradient(135deg, #e53e3e, #c53030);
}

.landlords i {
    background: linear-gradient(135deg, #667eea, #5a67d8);
}

.tenants i {
    background: linear-gradient(135deg, #9f7aea, #805ad5);
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

/* Dashboard Grid */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
}

.dashboard-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.section-header h2 {
    font-size: 1.25rem;
    color: #2d3748;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
}

.view-all-btn {
    color: #4299e1;
    text-decoration: none;
    font-size: 0.875rem;
    transition: color 0.3s ease;
}

.view-all-btn:hover {
    color: #3182ce;
}

/* Property Cards */
.properties-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.property-card {
    display: flex;
    background: #f8fafc;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.property-card:hover {
    transform: translateX(5px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.property-image {
    width: 120px;
    height: 120px;
    position: relative;
}

.property-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.property-status {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.property-status.available {
    background: #def7ec;
    color: #03543f;
}

.property-status.rented {
    background: #fef3c7;
    color: #92400e;
}

.property-status.under_maintenance {
    background: #fde8e8;
    color: #9b1c1c;
}

.property-details {
    padding: 1rem;
    flex: 1;
}

.property-details h4 {
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
    color: #2d3748;
}

.property-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.875rem;
    color: #4a5568;
    margin-bottom: 0.5rem;
}

.property-price {
    font-weight: 600;
    color: #2d3748;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.property-owner {
    font-size: 0.875rem;
    color: #718096;
}

/* Application Cards */
.applications-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.application-card {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1rem;
    transition: all 0.3s ease;
}

.application-card:hover {
    transform: translateX(5px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.application-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}

.applicant-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    color: #2d3748;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-badge.pending {
    background: #fef3c7;
    color: #92400e;
}

.application-details h4 {
    margin: 0 0 0.5rem 0;
    font-size: 0.875rem;
    color: #4a5568;
}

.detail-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #718096;
}

.no-data {
    text-align: center;
    padding: 2rem;
    color: #a0aec0;
}

.no-data i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 1rem;
    }

    .overview-section {
        grid-template-columns: 1fr;
    }

    .users-overview {
        grid-template-columns: 1fr;
    }

    .dashboard-grid {
        grid-template-columns: 1fr;
    }

    .property-card {
        flex-direction: column;
    }

    .property-image {
        width: 100%;
        height: 200px;
    }

    .property-meta {
        flex-wrap: wrap;
    }
}
</style>
@endsection 
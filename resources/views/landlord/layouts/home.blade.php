@extends('landlord.dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Overview Section -->
    <div class="overview-section">
        <div class="overview-card total-properties">
            <i class="bx bx-home-alt"></i>
            <div class="card-content">
                <h3>Total Properties</h3>
                <p class="number">{{ $totalProperties }}</p>
            </div>
        </div>
        <div class="overview-card available-properties">
            <i class="bx bx-check-circle"></i>
            <div class="card-content">
                <h3>Available Properties</h3>
                <p class="number">{{ $availableProperties }}</p>
            </div>
        </div>
        <div class="overview-card pending-applications">
            <i class="bx bx-time"></i>
            <div class="card-content">
                <h3>Pending Applications</h3>
                <p class="number">{{ $pendingApplications }}</p>
            </div>
        </div>
        <div class="overview-card total-tenants">
            <i class="bx bx-group"></i>
            <div class="card-content">
                <h3>Active Rentals</h3>
                <p class="number">{{ $activeRentals }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="dashboard-grid">
        <!-- Recent Applications Section -->
        <div class="dashboard-section applications-section">
            <div class="section-header">
                <h2><i class="bx bx-file"></i> Recent Applications</h2>
                <a href="{{ route('landlord.notifications') }}" class="view-all-btn">View All</a>
            </div>
            <div class="applications-list">
                @forelse($recentApplications as $application)
                <div class="application-card">
                    <div class="applicant-info">
                        <img src="{{ asset('images/placeholder-avatar.jpg') }}" alt="Applicant Photo" class="applicant-photo">
                        <div class="applicant-details">
                            <h4>{{ $application->tenant->name }}</h4>
                            <p>Applied for: {{ $application->rental->address }}</p>
                            <span class="application-date">{{ $application->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="application-actions">
                        <form action="{{ route('landlord.applications.approve', $application->id) }}" method="POST" class="action-form" onsubmit="return confirm('Are you sure you want to approve this application? This will automatically cancel all other pending applications for this property.');">
                            @csrf
                            <button type="submit" class="approve-btn">
                                <i class="bx bx-check"></i> Approve
                            </button>
                        </form>
                        <form action="{{ route('landlord.applications.reject', $application->id) }}" method="POST" class="action-form" onsubmit="return confirm('Are you sure you want to cancel this application?');">
                            @csrf
                            <button type="submit" class="reject-btn">
                                <i class="bx bx-x"></i> Cancel
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="no-applications">
                    <div class="no-applications-content">
                        <i class="bx bx-file"></i>
                        <h3>No Pending Applications</h3>
                        <p>When tenants apply for your properties, they will appear here</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Payment Overview Section -->
        <div class="dashboard-section payments-section">
            <div class="section-header">
                <h2><i class="bx bx-money"></i> Payment Overview</h2>
                <a href="#" class="view-all-btn">View All</a>
            </div>
            <div class="payment-stats">
                <div class="stat-card">
                    <h4>This Month's Revenue</h4>
                    <p class="amount">₱75,000.00</p>
                    <div class="stat-trend positive">
                        <i class="bx bx-up-arrow-alt"></i>
                        <span>12% vs last month</span>
                    </div>
                </div>
                <div class="stat-card">
                    <h4>Pending Payments</h4>
                    <p class="amount">₱25,000.00</p>
                    <div class="stat-trend negative">
                        <i class="bx bx-down-arrow-alt"></i>
                        <span>5% vs last month</span>
                    </div>
                </div>
            </div>
            <div class="recent-payments">
                <h3>Recent Payments</h3>
                <!-- Sample Payment 1 -->
                <div class="payment-card">
                    <div class="payment-info">
                        <span class="tenant-name">Prince Erickson M. Sanado</span>
                        <span class="property-address">Modern Apartment in City Center</span>
                        <span class="payment-date">Jan 15, 2024</span>
                    </div>
                    <div class="payment-amount">
                        <i class="bx bx-check-circle"></i>
                        ₱25,000.00
                    </div>
                </div>

                <!-- Sample Payment 2 -->
                <div class="payment-card">
                    <div class="payment-info">
                        <span class="tenant-name">Daryl S. Lamay</span>
                        <span class="property-address">Cozy Studio Unit</span>
                        <span class="payment-date">Jan 14, 2024</span>
                    </div>
                    <div class="payment-amount">
                        <i class="bx bx-check-circle"></i>
                        ₱15,000.00
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Container */
.dashboard-container {
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
    background-color: #f8fafc;
    min-height: calc(100vh - 4rem);
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
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.overview-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
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

.available-properties i {
    background: linear-gradient(135deg, #48bb78, #38a169);
}

.pending-applications i {
    background: linear-gradient(135deg, #ed8936, #dd6b20);
}

.total-tenants i {
    background: linear-gradient(135deg, #667eea, #5a67d8);
}

.card-content h3 {
    color: #4a5568;
    font-size: 1rem;
    margin-bottom: 0.5rem;
    font-weight: 500;
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

/* Section Styling */
.dashboard-section {
    background: white;
    border-radius: 16px;
    padding: 1.75rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.05);
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

/* Applications Section */
.applications-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.application-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem;
    background: #f8fafc;
    border-radius: 12px;
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.application-card:hover {
    transform: translateX(5px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.applicant-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.applicant-photo {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.applicant-details h4 {
    margin: 0;
    color: #2d3748;
    font-size: 1rem;
    font-weight: 600;
}

.applicant-details p {
    margin: 0.25rem 0;
    color: #4a5568;
    font-size: 0.9rem;
}

.application-date {
    color: #718096;
    font-size: 0.875rem;
}

.application-actions {
    display: flex;
    gap: 0.75rem;
}

.action-form {
    margin: 0;
}

.approve-btn, .reject-btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    font-weight: 500;
}

.approve-btn {
    background: #48bb78;
    color: white;
}

.reject-btn {
    background: #f56565;
    color: white;
}

.approve-btn:hover {
    background: #38a169;
    transform: translateY(-2px);
}

.reject-btn:hover {
    background: #e53e3e;
    transform: translateY(-2px);
}

.no-applications {
    text-align: center;
    padding: 3rem 2rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 2px dashed #e2e8f0;
}

.no-applications i {
    font-size: 3rem;
    color: #a0aec0;
    margin-bottom: 1rem;
}

.no-applications h3 {
    color: #2d3748;
    font-size: 1.25rem;
    margin: 0 0 0.5rem 0;
}

.no-applications p {
    color: #718096;
    margin: 0;
}

/* Payment Section */
.payment-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: #f8fafc;
    padding: 1.25rem;
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.stat-card h4 {
    margin: 0 0 0.75rem 0;
    color: #4a5568;
    font-size: 0.9rem;
    font-weight: 500;
}

.amount {
    margin: 0 0 0.75rem 0;
    color: #2d3748;
    font-size: 1.5rem;
    font-weight: 600;
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.stat-trend.positive {
    color: #48bb78;
}

.stat-trend.negative {
    color: #f56565;
}

.stat-trend i {
    font-size: 1.25rem;
}

.recent-payments {
    margin-top: 1.5rem;
}

.recent-payments h3 {
    font-size: 1rem;
    color: #2d3748;
    margin-bottom: 1rem;
    font-weight: 500;
}

.payment-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem;
    background: #f8fafc;
    border-radius: 12px;
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.payment-card:hover {
    transform: translateX(5px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.payment-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.tenant-name {
    color: #2d3748;
    font-weight: 500;
}

.property-address {
    color: #4a5568;
    font-size: 0.9rem;
}

.payment-date {
    color: #718096;
    font-size: 0.875rem;
}

.payment-amount {
    color: #48bb78;
    font-weight: 600;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.payment-amount i {
    font-size: 1.25rem;
}

/* Buttons */
.view-all-btn {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    background: #edf2f7;
    color: #4a5568;
    font-weight: 500;
}

.view-all-btn:hover {
    background: #e2e8f0;
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

    .application-card {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .applicant-info {
        flex-direction: column;
    }

    .application-actions {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
// Simplified JavaScript without backend calls
function approveApplication() {
    alert('Application Approved! (Frontend Only)');
}

function rejectApplication() {
    alert('Application Rejected! (Frontend Only)');
}
</script>
@endsection
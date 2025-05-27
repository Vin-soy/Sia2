@extends('landlord.dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Overview Section -->
    <div class="overview-section">
        <div class="overview-card total-properties">
            <i class="fas fa-home"></i>
            <div class="card-content">
                <h3>Total Properties</h3>
                <p class="number">5</p>
            </div>
        </div>
        <div class="overview-card available-properties">
            <i class="fas fa-check-circle"></i>
            <div class="card-content">
                <h3>Available Properties</h3>
                <p class="number">3</p>
            </div>
        </div>
        <div class="overview-card pending-applications">
            <i class="fas fa-clock"></i>
            <div class="card-content">
                <h3>Pending Applications</h3>
                <p class="number">2</p>
            </div>
        </div>
        <div class="overview-card total-tenants">
            <i class="fas fa-users"></i>
            <div class="card-content">
                <h3>Active Tenants</h3>
                <p class="number">4</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="dashboard-grid">
        <!-- Properties Section -->
        <div class="dashboard-section properties-section">
            <div class="section-header">
                <h2>My Properties</h2>
                <a href="#" class="add-property-btn">
                    <i class="fas fa-plus"></i> Add New Property
                </a>
            </div>
            <div class="property-grid">
                <!-- Sample Property Card 1 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="{{ asset('images/placeholder.jpg') }}" alt="Property Image">
                        <div class="property-status available">
                            Available
                        </div>
                    </div>
                    <div class="property-details">
                        <h3>Modern Apartment in City Center</h3>
                        <div class="property-info">
                            <span><i class="fas fa-bed"></i> 3 Rooms</span>
                            <span><i class="fas fa-home"></i> Apartment</span>
                            <span class="price"><i class="fas fa-peso-sign"></i> 25,000.00</span>
                        </div>
                        <div class="property-actions">
                            <a href="#" class="view-btn">View Details</a>
                            <a href="#" class="edit-btn">Edit</a>
                        </div>
                    </div>
                </div>

                <!-- Sample Property Card 2 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="{{     }}" alt="Property Image">
                        <div class="property-status rented">
                            Rented
                        </div>
                    </div>
                    <div class="property-details">
                        <h3>Cozy Studio Unit</h3>
                        <div class="property-info">
                            <span><i class="fas fa-bed"></i> 1 Room</span>
                            <span><i class="fas fa-home"></i> Studio</span>
                            <span class="price"><i class="fas fa-peso-sign"></i> 15,000.00</span>
                        </div>
                        <div class="property-actions">
                            <a href="#" class="view-btn">View Details</a>
                            <a href="#" class="edit-btn">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Applications Section -->
        <div class="dashboard-section applications-section">
            <div class="section-header">
                <h2>Recent Applications</h2>
                <a href="#" class="view-all-btn">View All</a>
            </div>
            <div class="applications-list">
                <!-- Sample Application 1 -->
                <div class="application-card">
                    <div class="applicant-info">
                        <img src="{{ asset('images/team4.jpg') }}" alt="Applicant Photo" class="applicant-photo">
                        <div class="applicant-details">
                            <h4>John Doe</h4>
                            <p>Applied for: Modern Apartment in City Center</p>
                            <span class="application-date">2 hours ago</span>
                        </div>
                    </div>
                    <div class="application-actions">
                        <button class="approve-btn">
                            <i class="fas fa-check"></i> Approve
                        </button>
                        <button class="reject-btn">
                            <i class="fas fa-times"></i> Reject
                        </button>
                    </div>
                </div>

                <!-- Sample Application 2 -->
                <div class="application-card">
                    <div class="applicant-info">
                        <img src="{{ asset('images/default-avatar.png') }}" alt="Applicant Photo" class="applicant-photo">
                        <div class="applicant-details">
                            <h4>Jane Smith</h4>
                            <p>Applied for: Cozy Studio Unit</p>
                            <span class="application-date">5 hours ago</span>
                        </div>
                    </div>
                    <div class="application-actions">
                        <button class="approve-btn">
                            <i class="fas fa-check"></i> Approve
                        </button>
                        <button class="reject-btn">
                            <i class="fas fa-times"></i> Reject
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages Section -->
        <div class="dashboard-section messages-section">
            <div class="section-header">
                <h2>Recent Messages</h2>
                <a href="#" class="view-all-btn">View All</a>
            </div>
            <div class="messages-list">
                <!-- Sample Message 1 -->
                <div class="message-card">
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Sender Photo" class="sender-photo">
                    <div class="message-content">
                        <div class="message-header">
                            <h4>John Doe</h4>
                            <span class="message-date">1 hour ago</span>
                        </div>
                        <p class="message-preview">Hi, I'm interested in your property. Is it still available?</p>
                    </div>
                    <a href="#" class="reply-btn">
                        <i class="fas fa-reply"></i>
                    </a>
                </div>

                <!-- Sample Message 2 -->
                <div class="message-card">
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Sender Photo" class="sender-photo">
                    <div class="message-content">
                        <div class="message-header">
                            <h4>Jane Smith</h4>
                            <span class="message-date">3 hours ago</span>
                        </div>
                        <p class="message-preview">When can I schedule a viewing of the apartment?</p>
                    </div>
                    <a href="#" class="reply-btn">
                        <i class="fas fa-reply"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Payment Overview Section -->
        <div class="dashboard-section payments-section">
            <div class="section-header">
                <h2>Payment Overview</h2>
                <a href="#" class="view-all-btn">View All</a>
            </div>
            <div class="payment-stats">
                <div class="stat-card">
                    <h4>This Month's Revenue</h4>
                    <p class="amount">₱75,000.00</p>
                </div>
                <div class="stat-card">
                    <h4>Pending Payments</h4>
                    <p class="amount">₱25,000.00</p>
                </div>
            </div>
            <div class="recent-payments">
                <h3>Recent Payments</h3>
                <!-- Sample Payment 1 -->
                <div class="payment-card">
                    <div class="payment-info">
                        <span class="tenant-name">John Doe</span>
                        <span class="property-address">Modern Apartment in City Center</span>
                        <span class="payment-date">Jan 15, 2024</span>
                    </div>
                    <div class="payment-amount">
                        ₱25,000.00
                    </div>
                </div>

                <!-- Sample Payment 2 -->
                <div class="payment-card">
                    <div class="payment-info">
                        <span class="tenant-name">Jane Smith</span>
                        <span class="property-address">Cozy Studio Unit</span>
                        <span class="payment-date">Jan 14, 2024</span>
                    </div>
                    <div class="payment-amount">
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
}

/* Overview Section */
.overview-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.overview-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.overview-card:hover {
    transform: translateY(-5px);
}

.overview-card i {
    font-size: 2rem;
    padding: 1rem;
    border-radius: 10px;
    color: white;
}

.total-properties i {
    background: #4299e1;
}

.available-properties i {
    background: #48bb78;
}

.pending-applications i {
    background: #ed8936;
}

.total-tenants i {
    background: #667eea;
}

.card-content h3 {
    color: #4a5568;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.card-content .number {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0;
}

/* Dashboard Grid */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

/* Section Styling */
.dashboard-section {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
    margin: 0;
}

/* Property Cards */
.property-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}

.property-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.property-card:hover {
    transform: translateY(-5px);
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

.property-status {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    color: white;
    font-size: 0.875rem;
    font-weight: 500;
}

.property-status.available {
    background: #48bb78;
}

.property-status.rented {
    background: #ed8936;
}

.property-details {
    padding: 1rem;
}

.property-details h3 {
    margin: 0 0 1rem 0;
    font-size: 1.1rem;
    color: #2d3748;
}

.property-info {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    color: #4a5568;
}

.property-info span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.property-actions {
    display: flex;
    gap: 1rem;
}

.view-btn, .edit-btn {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.9rem;
    text-decoration: none;
    text-align: center;
    flex: 1;
    transition: all 0.3s ease;
}

.view-btn {
    background: #4299e1;
    color: white;
}

.edit-btn {
    background: #edf2f7;
    color: #4a5568;
}

.view-btn:hover {
    background: #3182ce;
}

.edit-btn:hover {
    background: #e2e8f0;
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
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
}

.applicant-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.applicant-photo {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.applicant-details h4 {
    margin: 0;
    color: #2d3748;
    font-size: 1rem;
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
    gap: 0.5rem;
}

.approve-btn, .reject-btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
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
}

.reject-btn:hover {
    background: #e53e3e;
}

/* Messages Section */
.messages-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.message-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
}

.sender-photo {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.message-content {
    flex: 1;
}

.message-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.25rem;
}

.message-header h4 {
    margin: 0;
    color: #2d3748;
    font-size: 1rem;
}

.message-date {
    color: #718096;
    font-size: 0.875rem;
}

.message-preview {
    margin: 0;
    color: #4a5568;
    font-size: 0.9rem;
}

.reply-btn {
    color: #4299e1;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.25rem;
    padding: 0.5rem;
    transition: transform 0.3s ease;
}

.reply-btn:hover {
    transform: scale(1.1);
}

/* Payment Section */
.payment-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-card {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 8px;
    text-align: center;
}

.stat-card h4 {
    margin: 0 0 0.5rem 0;
    color: #4a5568;
    font-size: 0.9rem;
}

.amount {
    margin: 0;
    color: #2d3748;
    font-size: 1.25rem;
    font-weight: 600;
}

.recent-payments {
    margin-top: 1.5rem;
}

.recent-payments h3 {
    font-size: 1rem;
    color: #2d3748;
    margin-bottom: 1rem;
}

.payment-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
    margin-bottom: 0.5rem;
}

.payment-info {
    display: flex;
    flex-direction: column;
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
}

/* Empty States */
.no-properties,
.no-applications,
.no-messages,
.no-payments {
    text-align: center;
    padding: 2rem;
    color: #718096;
}

.no-properties i,
.no-applications i,
.no-messages i,
.no-payments i {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: #cbd5e0;
}

/* Buttons */
.add-property-btn,
.view-all-btn {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.add-property-btn {
    background: #4299e1;
    color: white;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.view-all-btn {
    background: #edf2f7;
    color: #4a5568;
}

.add-property-btn:hover {
    background: #3182ce;
}

.view-all-btn:hover {
    background: #e2e8f0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 1rem;
    }

    .overview-section {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }

    .dashboard-grid {
        grid-template-columns: 1fr;
    }

    .property-grid {
        grid-template-columns: 1fr;
    }

    .application-card,
    .message-card,
    .payment-card {
        flex-direction: column;
        text-align: center;
    }

    .application-actions,
    .message-actions {
        margin-top: 1rem;
    }

    .applicant-info,
    .message-header {
        flex-direction: column;
        align-items: center;
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
@endsection 
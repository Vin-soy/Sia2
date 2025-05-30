@extends('landlord.dashboard')

@section('content')
<div class="property-container">
    <div class="page-header">
        <div class="header-content">
            <a href="{{ route('landlord.history') }}" class="back-btn">
                <i class="bx bx-arrow-back"></i> Back to Properties
            </a>
            <div class="property-status {{ strtolower($rental->status) }}">
                {{ ucfirst($rental->status) }}
            </div>
        </div>
    </div>

    <div class="property-content">
        <div class="property-gallery">
            <div class="main-image">
                @if($rental->images && $rental->images->where('is_front_image', true)->first())
                    @php
                        $frontImage = $rental->images->where('is_front_image', true)->first();
                        $imagePath = str_replace('public/', '', $frontImage->image_url);
                    @endphp
                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Property Front View" id="mainImage" onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                @else
                    <img src="{{ asset('images/placeholder.jpg') }}" alt="Property Image" id="mainImage">
                @endif
            </div>
            
            <div class="thumbnail-gallery">
                @if($rental->images && $rental->images->count() > 0)
                    @foreach($rental->images->where('is_front_image', false) as $image)
                        @php
                            $thumbPath = str_replace('public/', '', $image->image_url);
                        @endphp
                        <div class="thumbnail" onclick="updateMainImage('{{ asset('storage/' . $thumbPath) }}', this)">
                            <img src="{{ asset('storage/' . $thumbPath) }}" alt="Property Image" onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                        </div>
                    @endforeach
                @else
                    <div class="no-images">
                        <p>No additional images available</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="property-details">
            <div class="details-section">
                <h1>{{ $rental->address }}</h1>
                <div class="key-details">
                    <div class="detail-item">
                        <i class="bx bx-bed"></i>
                        <span>{{ $rental->number_of_rooms }} {{ Str::plural('Room', $rental->number_of_rooms) }}</span>
                    </div>
                    <div class="detail-item">
                        <i class="bx bx-building-house"></i>
                        <span>{{ ucfirst($rental->house_type) }}</span>
                    </div>
                    <div class="detail-item price">
                        <i class="bx bx-money"></i>
                        <span>₱{{ number_format($rental->price, 2) }}/month</span>
                    </div>
                </div>
            </div>

            <div class="details-section">
                <h2>Description</h2>
                <p>{{ $rental->description }}</p>
            </div>

            <div class="details-section">
                <h2>Property Features</h2>
                <div class="features-grid">
                    <div class="feature">
                        <i class="bx bx-check-circle"></i>
                        <span>{{ ucfirst($rental->status) }}</span>
                    </div>
                    <div class="feature">
                        <i class="bx bx-home"></i>
                        <span>{{ ucfirst($rental->house_type) }}</span>
                    </div>
                </div>
            </div>

            <!-- Add Applications Section -->
            <div class="details-section">
                <h2>Rental Applications</h2>
                @if($rental->applications && $rental->applications->count() > 0)
                    <div class="applications-list">
                        @foreach($rental->applications as $application)
                            <div class="application-card">
                                <div class="application-header">
                                    <div class="applicant-info">
                                        <i class="bx bx-user"></i>
                                        <span>{{ $application->tenant->name }}</span>
                                    </div>
                                    <div class="application-status {{ $application->status }}">
                                        {{ ucfirst($application->status) }}
                                    </div>
                                </div>
                                <div class="application-details">
                                    <p><strong>Applied on:</strong> {{ $application->created_at->format('M d, Y') }}</p>
                                    <p><strong>Rental Period:</strong> {{ $application->rental_period_start }} to {{ $application->rental_period_end }}</p>
                                    <p><strong>Monthly Rent:</strong> ₱{{ number_format($application->total_amount, 2) }}</p>
                                </div>
                                @if($application->status === 'pending')
                                    <div class="application-actions">
                                        <form action="{{ route('rental.application.approve', $application->id) }}" method="POST" class="inline-form">
                                            @csrf
                                            <button type="submit" class="approve-btn">
                                                <i class="bx bx-check"></i> Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('rental.application.reject', $application->id) }}" method="POST" class="inline-form">
                                            @csrf
                                            <button type="submit" class="reject-btn">
                                                <i class="bx bx-x"></i> Reject
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-applications">
                        <p>No applications received yet</p>
                    </div>
                @endif
            </div>

            <div class="action-buttons">
                <form action="{{ route('rentals.destroy', $rental->id) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this property? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn">
                        <i class="bx bx-trash"></i> Delete Property
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.property-container {
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

.page-header {
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #4a5568;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.back-btn:hover {
    color: #2d3748;
}

.property-status {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    color: white;
    font-size: 0.875rem;
    font-weight: 500;
}

.property-status.available {
    background: #48BB78;
}

.property-status.rented {
    background: #ED8936;
}

.property-status.under_maintenance {
    background: #4A5568;
}

.property-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

/* Gallery Styles */
.property-gallery {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.main-image {
    width: 100%;
    height: 400px;
    overflow: hidden;
}

.main-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.thumbnail-gallery {
    padding: 1rem;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 1rem;
}

.thumbnail {
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    opacity: 0.7;
    transition: all 0.3s ease;
}

.thumbnail:hover, .thumbnail.active {
    opacity: 1;
    transform: scale(1.05);
}

.thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Property Details Styles */
.property-details {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.details-section {
    margin-bottom: 2rem;
}

.details-section:last-child {
    margin-bottom: 0;
}

.property-details h1 {
    font-size: 1.75rem;
    color: #2d3748;
    margin: 0 0 1rem 0;
}

.property-details h2 {
    font-size: 1.25rem;
    color: #2d3748;
    margin: 0 0 1rem 0;
}

.key-details {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #4a5568;
}

.detail-item i {
    font-size: 1.25rem;
}

.detail-item.price {
    font-weight: 600;
    color: #2d3748;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}

.feature {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #4a5568;
}

.feature i {
    color: #48BB78;
}

.action-buttons {
    margin-top: 2rem;
    display: flex;
    gap: 1rem;
}

.delete-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: #FED7D7;
    color: #C53030;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.delete-btn:hover {
    background: #FEB2B2;
}

.no-images {
    grid-column: 1 / -1;
    text-align: center;
    padding: 2rem;
    background: #f8fafc;
    border-radius: 8px;
    color: #718096;
}

/* Applications Styles */
.applications-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.application-card {
    background: #F7FAFC;
    border-radius: 8px;
    padding: 1.5rem;
    border: 1px solid #E2E8F0;
}

.application-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.applicant-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    color: #2D3748;
}

.application-status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.application-status.pending {
    background: #FEF3C7;
    color: #92400E;
}

.application-status.approved {
    background: #C6F6D5;
    color: #2F855A;
}

.application-status.rejected {
    background: #FED7D7;
    color: #C53030;
}

.application-details {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    color: #4A5568;
}

.application-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #E2E8F0;
}

.inline-form {
    display: inline;
}

.approve-btn, .reject-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
}

.approve-btn {
    background: #48BB78;
    color: white;
}

.approve-btn:hover {
    background: #38A169;
}

.reject-btn {
    background: #F56565;
    color: white;
}

.reject-btn:hover {
    background: #E53E3E;
}

.no-applications {
    text-align: center;
    padding: 2rem;
    background: #F7FAFC;
    border-radius: 8px;
    color: #718096;
}

@media (max-width: 1024px) {
    .property-content {
        grid-template-columns: 1fr;
    }

    .main-image {
        height: 300px;
    }
}

@media (max-width: 768px) {
    .property-container {
        padding: 1rem;
    }

    .header-content {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .key-details {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>

<script>
function updateMainImage(src, thumbnail) {
    document.getElementById('mainImage').src = src;
    // Remove active class from all thumbnails
    document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
    // Add active class to clicked thumbnail
    thumbnail.classList.add('active');
}
</script>
@endsection
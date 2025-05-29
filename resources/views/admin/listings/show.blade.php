@extends('admin.dashboard')

@section('content')
<div class="property-container">
    <div class="page-header">
        <div class="header-content">
            <a href="{{ route('admin.listings') }}" class="back-btn">
                <i class="bx bx-arrow-back"></i> Back to Listings
            </a>
            <div class="header-actions">
                <button class="edit-btn" onclick="toggleEdit()">
                    <i class="bx bx-edit"></i> Edit Property
                </button>
                <form action="{{ route('admin.listings.destroy', $rental->id) }}" method="POST" class="delete-form" 
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

    @if(session('success'))
    <div class="alert alert-success">
        <i class="bx bx-check-circle"></i>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="property-content">
        <!-- Left Column - Gallery -->
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
            
            @if($rental->images && $rental->images->count() > 1)
            <div class="thumbnail-gallery">
                @foreach($rental->images->where('is_front_image', false) as $image)
                    @php
                        $imagePath = str_replace('public/', '', $image->image_url);
                    @endphp
                    <div class="thumbnail" onclick="changeMainImage(this)">
                        <img src="{{ asset('storage/' . $imagePath) }}" alt="Property Image" onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                    </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Right Column - Details -->
        <div class="property-details">
            <!-- Property Information -->
            <div class="details-section">
                <div class="section-header">
                    <h1>{{ $rental->address }}</h1>
                    <div class="property-status {{ strtolower($rental->status) }}">
                        {{ ucfirst($rental->status) }}
                    </div>
                </div>

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

            <!-- Landlord Information -->
            <div class="details-section">
                <h2><i class="bx bx-user"></i> Landlord Information</h2>
                <div class="landlord-info">
                    <div class="info-item">
                        <label>Name:</label>
                        <span>{{ $rental->landlord->name }}</span>
                    </div>
                    <div class="info-item">
                        <label>Email:</label>
                        <span>{{ $rental->landlord->email }}</span>
                    </div>
                    <div class="info-item">
                        <label>Contact:</label>
                        <span>{{ $rental->landlord->info->contact_number ?? 'Not provided' }}</span>
                    </div>
                </div>
            </div>

            <!-- Property Description -->
            <div class="details-section">
                <h2><i class="bx bx-info-circle"></i> Description</h2>
                <p>{{ $rental->description }}</p>
            </div>

            <!-- Rental Applications -->
            <div class="details-section">
                <h2><i class="bx bx-file"></i> Rental Applications</h2>
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
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-applications">
                        <i class="bx bx-file"></i>
                        <p>No applications received yet</p>
                    </div>
                @endif
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

.header-actions {
    display: flex;
    gap: 1rem;
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

.edit-btn, .delete-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.edit-btn {
    background: #EBF5FF;
    color: #2B6CB0;
    border: none;
}

.delete-btn {
    background: #FED7D7;
    color: #C53030;
    border: none;
}

.edit-btn:hover {
    background: #BEE3F8;
}

.delete-btn:hover {
    background: #FEB2B2;
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

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.property-details h1 {
    font-size: 1.75rem;
    color: #2d3748;
    margin: 0;
}

.property-details h2 {
    font-size: 1.25rem;
    color: #2d3748;
    margin: 0 0 1rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.property-details h2 i {
    font-size: 1.5rem;
    color: #4a5568;
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

.details-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #E2E8F0;
}

.details-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.landlord-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-item label {
    font-size: 0.875rem;
    color: #718096;
}

.info-item span {
    color: #2D3748;
    font-weight: 500;
}

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
    background: #DEF7EC;
    color: #03543F;
}

.application-status.cancelled {
    background: #FEE2E2;
    color: #991B1B;
}

.no-applications {
    text-align: center;
    padding: 2rem;
    background: #F8FAFC;
    border-radius: 8px;
    color: #718096;
}

.no-applications i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
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

    .header-actions {
        width: 100%;
    }

    .edit-btn, .delete-btn {
        flex: 1;
        justify-content: center;
    }

    .property-content {
        grid-template-columns: 1fr;
    }

    .main-image {
        height: 300px;
    }
}
</style>

<script>
function changeMainImage(thumbnail) {
    const mainImage = document.getElementById('mainImage');
    const thumbnails = document.querySelectorAll('.thumbnail');
    
    // Update main image
    mainImage.src = thumbnail.querySelector('img').src;
    
    // Update active state
    thumbnails.forEach(thumb => thumb.classList.remove('active'));
    thumbnail.classList.add('active');
}

function toggleEdit() {
    // Implement edit functionality
    alert('Edit functionality will be implemented here');
}
</script>
@endsection 
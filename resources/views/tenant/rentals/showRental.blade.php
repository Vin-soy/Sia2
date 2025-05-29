@extends('tenant.dashboard')

@section('content')
<div class="property-container">
    <div class="page-header">
        <div class="header-content">
            <a href="{{ route('tenant.history') }}" class="back-btn">
                <i class="bx bx-arrow-back"></i> Back to Properties
            </a>
            <div class="property-status {{ strtolower($rental->status) }}">
                {{ ucfirst($rental->status) }}
            </div>
        </div>
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

            <div class="action-buttons">
                <form action="{{ route('transaction.store') }}" method="POST" id="applyForm">
                    @csrf
                    <input type="hidden" name="house_id" value="{{ $rental->id }}">
                    <input type="hidden" name="tenant_id" value="{{ auth()->id() }}">
                    <input type="hidden" name="status" value="pending">
                    <button type="button" class="apply-btn" onclick="confirmApplication()">
                        <i class="bx bx-check"></i> Apply for Rental
                    </button>
                </form>
                <button type="button" class="contact-btn">
                    <i class="bx bx-envelope"></i> Contact Owner
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Confirm Rental Application</h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to apply for this rental property?</p>
            <p><strong>Property:</strong> {{ $rental->address }}</p>
            <p><strong>Monthly Rent:</strong> ₱{{ number_format($rental->price, 2) }}</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="modal-btn cancel-btn" onclick="closeModal()">Cancel</button>
            <button type="button" class="modal-btn confirm-btn" onclick="submitApplication()">Confirm Application</button>
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

.apply-btn, .contact-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.apply-btn {
    background: #48BB78;
    color: white;
}

.apply-btn:hover {
    background: #38A169;
}

.contact-btn {
    background: #EDF2F7;
    color: #4A5568;
}

.contact-btn:hover {
    background: #E2E8F0;
}

.no-images {
    grid-column: 1 / -1;
    text-align: center;
    padding: 2rem;
    background: #f8fafc;
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

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    width: 100%;
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

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.modal-content {
    position: relative;
    background-color: white;
    margin: 15% auto;
    padding: 2rem;
    border-radius: 12px;
    max-width: 500px;
    width: 90%;
}

.modal-header {
    margin-bottom: 1.5rem;
}

.modal-header h3 {
    margin: 0;
    color: #2D3748;
}

.modal-body {
    margin-bottom: 1.5rem;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

.modal-btn {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: 500;
}

.confirm-btn {
    background-color: #48BB78;
    color: white;
}

.confirm-btn:hover {
    background-color: #38A169;
}

.cancel-btn {
    background-color: #E2E8F0;
    color: #4A5568;
}

.cancel-btn:hover {
    background-color: #CBD5E0;
}
</style>

<script>
function confirmApplication() {
    document.getElementById('confirmationModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('confirmationModal').style.display = 'none';
}

function submitApplication() {
    document.getElementById('applyForm').submit();
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('confirmationModal');
    if (event.target == modal) {
        closeModal();
    }
}

function updateMainImage(src, thumbnail) {
    document.getElementById('mainImage').src = src;
    // Remove active class from all thumbnails
    document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
    // Add active class to clicked thumbnail
    thumbnail.classList.add('active');
}
</script>
@endsection
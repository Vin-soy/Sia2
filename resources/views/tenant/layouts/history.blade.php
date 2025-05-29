@extends('tenant.dashboard')

@section('content')
<div class="rentals-container">
    <div class="page-header">
        <div class="header-content">
            <h1>My Rental History</h1>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="bx bx-check-circle"></i>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="property-grid">
        @forelse($rentals as $rental)
        <div class="property-card">
            <div class="property-image">
                @if($rental->images && $rental->images->where('is_front_image', true)->first())
                    @php
                        $frontImage = $rental->images->where('is_front_image', true)->first();
                        $imagePath = str_replace('public/', '', $frontImage->image_url);
                    @endphp
                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Property Front View" onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                @else
                    <img src="{{ asset('images/placeholder.jpg') }}" alt="Property Image">
                @endif
                <div class="property-status {{ strtolower($rental->status) }}">
                    {{ ucfirst($rental->status) }}
                </div>
            </div>
            <div class="property-details">
                <div class="property-type">{{ ucfirst($rental->house_type) }}</div>
                <h3>{{ $rental->address }}</h3>
                <div class="property-meta">
                    <span>{{ $rental->number_of_rooms }} {{ Str::plural('room', $rental->number_of_rooms) }}</span>
                </div>
                <div class="property-price">
                    <span class="price">₱{{ number_format($rental->price, 2) }}</span>
                    <span class="period">month</span>
                </div>
                <div class="property-actions">
                    <a href="{{ route('tenant.rental.show', $rental->id) }}" class="view-btn">View details</a>
                </div>
            </div>
        </div>
        @empty
        <div class="no-properties">
            <div class="no-properties-content">
                <i class="bx bx-building-house"></i>
                <h3>No rental history yet</h3>
                <p>Your rental applications and history will appear here</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
.rentals-container {
    max-width: 1400px;
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
}

.header-content h1 {
    font-size: 32px;
    font-weight: 600;
    color: #222222;
}

.alert {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    border-radius: 12px;
    margin-bottom: 24px;
    background-color: #F7FEE7;
    border: 1px solid #BEF264;
}

.alert i {
    font-size: 20px;
    color: #65A30D;
}

.alert p {
    color: #365314;
    margin: 0;
}

.property-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}

.property-card {
    border-radius: 12px;
    overflow: hidden;
    background: white;
    transition: all 0.2s ease;
}

.property-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.property-image {
    position: relative;
    padding-top: 66.67%;
    overflow: hidden;
}

.property-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.property-card:hover .property-image img {
    transform: scale(1.05);
}

.property-status {
    position: absolute;
    top: 16px;
    right: 16px;
    padding: 6px 12px;
    border-radius: 99px;
    font-size: 14px;
    font-weight: 500;
    color: white;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
}

.property-status.available {
    background: rgba(21, 128, 61, 0.85);
}

.property-status.rented {
    background: rgba(194, 65, 12, 0.85);
}

.property-status.pending {
    background: rgba(234, 179, 8, 0.85);
}

.property-status.rejected {
    background: rgba(220, 38, 38, 0.85);
}

.property-details {
    padding: 20px;
}

.property-type {
    font-size: 14px;
    font-weight: 500;
    color: #666666;
    margin-bottom: 8px;
}

.property-details h3 {
    font-size: 18px;
    font-weight: 500;
    color: #222222;
    margin: 0 0 8px 0;
    line-height: 1.4;
}

.property-meta {
    font-size: 15px;
    color: #666666;
    margin-bottom: 12px;
}

.property-price {
    margin-bottom: 16px;
}

.property-price .price {
    font-size: 18px;
    font-weight: 600;
    color: #222222;
}

.property-price .period {
    font-size: 16px;
    color: #666666;
}

.property-price .period::before {
    content: '/';
    margin: 0 4px;
    color: #666666;
}

.property-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

.view-btn {
    flex: 1;
    display: inline-block;
    padding: 12px 24px;
    background: #222222;
    color: white;
    text-align: center;
    text-decoration: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.view-btn:hover {
    background: #000000;
}

.no-properties {
    grid-column: 1 / -1;
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #F8FAFC;
    border-radius: 16px;
    border: 2px dashed #E2E8F0;
}

.no-properties-content {
    text-align: center;
    padding: 48px 24px;
}

.no-properties i {
    font-size: 48px;
    color: #94A3B8;
    margin-bottom: 16px;
}

.no-properties h3 {
    font-size: 24px;
    font-weight: 600;
    color: #222222;
    margin: 0 0 8px 0;
}

.no-properties p {
    font-size: 16px;
    color: #666666;
    margin: 0 0 24px 0;
}

@media (max-width: 768px) {
    .rentals-container {
        padding: 16px;
    }

    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .header-content h1 {
        font-size: 28px;
    }

    .property-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
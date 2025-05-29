@extends('admin.dashboard')

@section('content')
<div class="rentals-container">
    <div class="page-header">
        <div class="header-content">
            <h1>Property Listings</h1>
            <div class="header-actions">
                <a href="#" class="filter-btn">
                    <i class="bx bx-filter"></i> Filter
                </a>
                <a href="#" class="export-btn">
                    <i class="bx bx-export"></i> Export
                </a>
            </div>
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
                @if($rental->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $rental->images->first()->image_url) }}" alt="Property Front View" onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
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
                    <span><i class="bx bx-bed"></i> {{ $rental->number_of_rooms }} {{ Str::plural('room', $rental->number_of_rooms) }}</span>
                    <span><i class="bx bx-user"></i> {{ $rental->landlord->name }}</span>
                </div>
                <div class="property-price">
                    <span class="price">₱{{ number_format($rental->price, 2) }}</span>
                    <span class="period">month</span>
                </div>
                <div class="property-actions">
                    <a href="{{ route('admin.listings.show', $rental->id) }}" class="view-btn">View details</a>
                    <form action="{{ route('rentals.destroy', $rental->id) }}" method="POST" class="delete-form" 
                          onsubmit="return confirm('Are you sure you want to delete this property?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">
                            <i class="bx bx-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="no-properties">
            <div class="no-properties-content">
                <i class="bx bx-building-house"></i>
                <h3>No Properties Listed</h3>
                <p>There are currently no properties in the system</p>
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

.header-actions {
    display: flex;
    gap: 12px;
}

.filter-btn, .export-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}

.filter-btn {
    background: #F8FAFC;
    color: #222222;
    border: 1px solid #E2E8F0;
}

.export-btn {
    background: #222222;
    color: white;
}

.filter-btn:hover {
    background: #F1F5F9;
}

.export-btn:hover {
    background: #000000;
    transform: translateY(-1px);
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
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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

.property-status.under_maintenance {
    background: rgba(30, 41, 59, 0.85);
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
    display: flex;
    gap: 16px;
    font-size: 15px;
    color: #666666;
    margin-bottom: 12px;
}

.property-meta span {
    display: flex;
    align-items: center;
    gap: 4px;
}

.property-meta i {
    font-size: 18px;
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

.delete-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 8px;
    background: #FEE2E2;
    color: #DC2626;
    cursor: pointer;
    transition: all 0.2s ease;
}

.delete-btn:hover {
    background: #FECACA;
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
    margin: 0;
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

    .header-actions {
        width: 100%;
    }

    .filter-btn, .export-btn {
        flex: 1;
        justify-content: center;
    }

    .property-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
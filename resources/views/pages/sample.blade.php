@extends('layouts.app')

@section('title', 'Sample Properties')

@section('content')
<div class="properties-container">
    <h1>Featured Properties</h1>
    
    <div class="filters">
        <select class="filter-select">
            <option value="">Property Type</option>
            <option value="house">House</option>
            <option value="apartment">Apartment</option>
            <option value="condo">Condo</option>
        </select>
        <select class="filter-select">
            <option value="">Price Range</option>
            <option value="0-100000">$0 - $100,000</option>
            <option value="100000-200000">$100,000 - $200,000</option>
            <option value="200000+">$200,000+</option>
        </select>
        <select class="filter-select">
            <option value="">Bedrooms</option>
            <option value="1">1 Bedroom</option>
            <option value="2">2 Bedrooms</option>
            <option value="3">3+ Bedrooms</option>
        </select>
    </div>

    <div class="property-grid">
        <!-- Sample Property Cards -->
        @for ($i = 1; $i <= 6; $i++)
        <div class="property-card">
            <div class="property-image">
                <img src="{{ asset('assets/project-' . $i . '.jpg') }}" alt="Property">
                <span class="property-tag">For Rent</span>
            </div>
            <div class="property-info">
                <h3>Beautiful Home in City Center</h3>
                <p class="price">$299,000</p>
                <p class="location"><i class="fas fa-map-marker-alt"></i> 123 Main St, City</p>
                <div class="property-features">
                    <span><i class="fas fa-bed"></i> 3 Beds</span>
                    <span><i class="fas fa-bath"></i> 2 Baths</span>
                    <span><i class="fas fa-ruler-combined"></i> 1,500 sqft</span>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>

<style>
    .properties-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .properties-container h1 {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 2rem;
        text-align: center;
    }

    .filters {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        justify-content: center;
    }

    .filter-select {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: white;
        min-width: 150px;
    }

    .property-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .property-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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

    .property-tag {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: #4CAF50;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        font-size: 0.875rem;
    }

    .property-info {
        padding: 1.5rem;
    }

    .property-info h3 {
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 1.25rem;
    }

    .price {
        color: #4CAF50;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .location {
        color: #666;
        margin-bottom: 1rem;
    }

    .property-features {
        display: flex;
        gap: 1rem;
        color: #666;
        font-size: 0.875rem;
    }

    .property-features span {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
</style>
@endsection 
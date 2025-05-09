@extends('landlord.dashboard')

@section('content')
<style>
    .title{
        text-align: center;
    }
    .home-card {
        border-radius: 10px;
        border: 1px solid red;
      
        width: 100%;
        overflow: hidden;
    }
    .image {
        height: 203px;
        overflow: hidden;
    }
    .image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
    .bottom {
        padding: 15px;
    }

    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 400px));
        gap: 20px;
        justify-content: center;
    }
    .card-btn {
        display: flex;
        gap: 4px;
        margin: 5px
    }
    .card-btn button {
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #007bff;
        color: white;
        transition: background-color 0.3s ease;
    }
    .card-btn a:hover {
        background-color: #0056b3;
    }
</style>
<h2>My Rentals</h2>

    <div class="card-grid">
            <div class="home-card">
                <div class="image">
                    <img src="{{ asset('assets/project-1.jpg') }}" alt="Modern Apartment">
                </div>
                <div class="bottom">
                    <p class="title">Modern Apartment</p>
                    <p class="address">123 Main St, Downtown, Cityville</p>
                    <p class="rooms">Rooms: 2</p>
                    <p class="price">Price: $1,200/month</p>
                </div>
                <div class="card-btn">
                    <button type="submit" >View</button>
                    <button type="submit">Delete</button>
                </div>
            </div>
        
            <div class="home-card">
                <div class="image">
                    <img src="{{ asset('assets/project-2.jpg') }}" alt="Cozy Cottage">
                </div>
                <div class="bottom">
                    <p class="title">Cozy Cottage</p>
                    <p class="address">456 Oak Rd, Greenfield</p>
                    <p class="rooms">Rooms: 3</p>
                    <p class="price">Price: $950/month</p>
                </div>
                <div class="card-btn">
                    <button type="submit" >View</button>
                    <button type="submit">Delete</button>
                </div>
            </div>
        
            <div class="home-card">
                <div class="image">
                    <img src="{{ asset('assets/project-3.jpg') }}" alt="Luxury Villa">
                </div>
                <div class="bottom">
                    <p class="title">Luxury Villa</p>
                    <p class="address">789 Palm Blvd, Sunset Beach</p>
                    <p class="rooms">Rooms: 5</p>
                    <p class="price">Price: $3,500/month</p>
                </div>
                <div class="card-btn">
                    <button type="submit" >View</button>
                    <button type="submit">Delete</button>
                </div>
            </div>
        
            <div class="home-card">
                <div class="image">
                    <img src="{{ asset('assets/project-4.jpg') }}" alt="Urban Loft">
                </div>
                <div class="bottom">
                    <p class="title">Urban Loft</p>
                    <p class="address">101 City Plaza, Metro City</p>
                    <p class="rooms">Rooms: 1</p>
                    <p class="price">Price: $1,500/month</p>
                </div>
                <div class="card-btn">
                    <button type="submit" >View</button>
                    <button type="submit">Delete</button>
                </div>
            </div>
        
            <div class="home-card">
                <div class="image">
                    <img src="{{ asset('assets/project-5.jpg') }}" alt="Family Home">
                </div>
                <div class="bottom">
                    <p class="title">Family Home</p>
                    <p class="address">202 Maple Ln, Suburbia</p>
                    <p class="rooms">Rooms: 4</p>
                    <p class="price">Price: $2,000/month</p>
                </div>
                <div class="card-btn">
                    <button type="submit" >View</button>
                    <button type="submit">Delete</button>
                </div>
            </div>
        
        @foreach($rentals as $rental)
        <div class="home-card">
            <div class="image">
                <img src="{{ asset('assets/project-4.jpg') }}" alt="">
            </div>
            <div class="bottom">
                <p>{{ $rental->address }}</p>
                <p>6391 Elin St. delina, Delaware 10299</p>
                <p>Rooms: {{ $rental->number_of_rooms }}</p>
                <p>Price: ${{ number_format($rental->price, 2) }}</p>
            </div>
            <div class="card-btn">
                <form action="{{ route('rentals.show', $rental->id) }}" method="get">
                    <button type="submit">View</button>
                </form>
                
                <form action="{{ route('rentals.destroy', $rental->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this rental?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endsection
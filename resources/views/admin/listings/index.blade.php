@extends('admin.dashboard')

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
    <h1 class="title">Listings</h1>
    <div class="card-grid">
        @foreach($rentals as $rental)
        <div class="home-card">
            <div class="image">
                @if($rental->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $rental->images->first()->image_url) }}" alt="First House Image">
                @else
                    <img src="{{ asset('assets/project-4.jpg') }}" alt="Default Image">
                @endif
            </div>

            <div class="bottom">
                <p class="title">{{ $rental->address }}</p>
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
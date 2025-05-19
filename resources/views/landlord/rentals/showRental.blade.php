@extends('landlord.dashboard')

@section('content')

<style>
    
   .home-container {
        height: 100%;
        width: 100%;
        display: grid;
        grid-template-columns: 300px 1fr;
    }   
    .home-left {
        background-color: #f0f0f0;
        height: 100%;
    }
    .home-right {
        height: 100%;
    }
    
    .home-left .home-details {
        padding: 20px;
        display: grid;
        grid-template-columns: 1fr 1fr; /* Two equal columns */
        gap: 20px;
        font-size: 16px;
        color: #333;
        width: 100%;
        box-sizing: border-box;
    }

    .home-details h2 {
        font-size: 22px;
        margin-bottom: 10px;
        color: #111;
        grid-column: span 2; /* Makes the header span across both columns */
    }

    .home-details p {
        margin: 0;
        line-height: 1.6;
    }

    .home-details .label {
        font-weight: 600;
        color: #555;
    }

    .carousel {
        margin: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .carousel-slides {
        width: 100%;
        height: 100%;
        display: flex;
        transition: transform 0.5s ease;
    }

    .carousel-slide {
        flex: 0 0 100%; /* Each slide takes 100% of the carousel width */
        height: 100%;   /* Match the carousel height */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .carousel-slide img {
        height: 100%;
        width: 100%;
        object-fit: contain;
    }

    button.prev,
    button.next {
        position: absolute;
        top: 30%;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        font-size: 2rem;
        padding: 10px;
        border: none;
        cursor: pointer;
        z-index: 1;
        top: 50%
    }

    button.prev {
        left: 10px;
    }

    button.next {
        right: 10px;
    }
    .home-left .img {
        width: 100%;
        height: 50%;
        overflow: hidden;
    }
    .home-left .img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
<div class="home-container">
    <div class="home-left">
        <div class="img">
            @if($rental->images->isNotEmpty())
                <img src="{{ asset('storage/' . $rental->images->first()->image_url) }}" alt="Main House Image">
            @else
                <img src="{{ asset('images/placeholder.jpg') }}" alt="Placeholder Image">
            @endif
        </div>
        <div class="home-details">
            <h2>Property Details</h2>
            <p><span class="label">Address:</span>{{ $rental->address }}</p>
            <p><span class="label">Description:</span> {{ $rental->description }}</p>
            <p><span class="label">Price:</span>{{ $rental->price }}</p>
            <p><span class="label">Number of Rooms:</span> {{ $rental->number_of_rooms }}</p>
            <p><span class="label">House Type:</span> {{ $rental->House_type }}</p>
            <p><span class="label">Status:</span> {{ $rental->status }}</p>
        </div>
    </div>
    <div class="carousel">
        <div class="carousel-slides">
            @if($rental->images->count() > 1)
                @foreach($rental->images->slice(1) as $image)
                    <div class="carousel-slide">
                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="House Image">
                    </div>
                @endforeach
            @else
                <p>No additional images available.</p>
            @endif
            {{-- <div class="carousel-slide">
                <img src="https://media.istockphoto.com/id/485371557/photo/twilight-at-spirit-island.jpg?s=612x612&w=0&k=20&c=FSGliJ4EKFP70Yjpzso0HfRR4WwflC6GKfl4F3Hj7fk=" alt="Image 1">
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('assets/project-2.jpg') }}" alt="Image 2">
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('assets/project-3.jpg') }}" alt="Image 3">
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('assets/project-4.jpg') }}" alt="Image 4">
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('assets/project-5.jpg') }}" alt="Image 5">
            </div> --}}
        </div>
        <button class="prev">&#10094;</button>
        <button class="next">&#10095;</button>
    </div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slides = document.querySelectorAll('.carousel-slide');
        const prevButton = document.querySelector('.prev');
        const nextButton = document.querySelector('.next');
        let currentIndex = 0;

        function updateSlidePosition() {
            const offset = -currentIndex * 100;
            document.querySelector('.carousel-slides').style.transform = `translateX(${offset}%)`;
        }

        prevButton.addEventListener('click', function () {
            currentIndex = (currentIndex === 0) ? slides.length - 1 : currentIndex - 1;
            updateSlidePosition();
        });

        nextButton.addEventListener('click', function () {
            currentIndex = (currentIndex === slides.length - 1) ? 0 : currentIndex + 1;
            updateSlidePosition();
        });
    });
</script>
@endsection
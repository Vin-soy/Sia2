@extends('landlord.dashboard')

@section('content')

<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    } 
   .home-container {
        border: 1px solid red;
        display: grid;
        grid-template-columns: 1fr 2fr;
        max-height: 90%;
        overflow: hidden;
    }   
    .home-left {
        background-color: #f0f0f0;
        height: 80%;
    }
    .home-right {
        height: autofit;
        overflow: hidden;
        height: 100%;
        background-color: #e0e0e0;
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

    .home-right {
        width: 100%;
        margin: 0 auto;
        position: relative;
        height: fit-content;
    }

    .carousel {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .carousel-slides {
        display: flex;
        transition: transform 0.5s ease;
    }

    .carousel-slide {
        min-width: 100%;
        
        max-height: 100%;
        flex: 0 0 auto;
        overflow: hidden;
    }

    .carousel-slide img {
        width: 100%;
        object-fit: cover;
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
        object-fit: contain;
    }
</style>
<div class="home-container">
    <div class="home-left">
        <div class="img">
            <img src="{{ asset('assets/project-6.jpg') }}" alt="">
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
        <div class="buttons">
            <form action="{{ route('rental.apply') }}" method="POST">
                @csrf
                <input type="hidden" name="house_id" value="{{ $rental->id }}">
                <input type="hidden" name="rental_period_start" value="{{ now()->toDateString() }}">
                <input type="hidden" name="rental_period_end" value="{{ now()->addMonth()->toDateString() }}">
                <input type="hidden" name="total_amount" value="{{ $rental->price }}">
                <button type="submit">Apply</button>
            </form>
            <button>View Owner</button>
        </div>
    </div>
    <div class="home-right">
        <div class="carousel">
            <div class="carousel-slides">
                <div class="carousel-slide">
                    <img src="{{ asset('assets/project-1.jpg') }}" alt="Image 1">
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
                </div>
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
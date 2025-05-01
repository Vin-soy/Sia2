@extends('admin.dashboard')

@section('content')
    <style>
        .title{
            text-align: center;
        }
        .home-card {
            border-radius: 10px;
            border: 1px solid red;
            max-width: 450px;
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
            padding: 20px;
        }
        
        .card-grid {
           display: grid;
           grid-template-columns: repeat(2, 1fr);
           gap: 20px;

        }

        @media only screen and (max-width: 1000px) {
            .card-grid {
                grid-template-columns: repeat(2, 450px);
            }
        }
    </style>
    <h1 class="title">Listings</h1>
    <div class="card-grid">
        <div class="home-card">
            <div class="image">
                <img src="{{ asset('assets/project-4.jpg') }}" alt="">
            </div>
            <div class="bottom">
                <p>New Apartment</p>
                <p>6391 Elin St. delina, Delaware 10299</p>
                <p>Rooms: </p>
                <p>Price: </p>
            </div>
        </div>

        <div class="home-card">
            <div class="image">
                <img src="{{ asset('assets/project-4.jpg') }}" alt="">
            </div>
            <div class="bottom">
                <p>Description: New Apartment</p>
                <p>Address: 6391 Elin St. delina, Delaware 10299</p>
                <p>Rooms: </p>
                <p>Price: </p>
            </div>
        </div>
    </div>
@endsection
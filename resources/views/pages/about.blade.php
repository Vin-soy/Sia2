@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="about-container">
    <h1>About PaUpa</h1>
    <div class="about-content">
        <div class="about-text">
            <h2>Our Story</h2>
            <p>PaUpa is dedicated to helping people find their perfect home. With years of experience in the real estate industry, we understand that finding the right property is about more than just four walls and a roof – it's about finding a place where memories will be made.</p>
            
            <h2>Our Mission</h2>
            <p>We strive to make the process of finding and securing your dream property as smooth and enjoyable as possible. Our team of dedicated professionals is here to guide you every step of the way.</p>
        </div>
        
        <div class="team-section">
            <h2>Our Team</h2>
            <div class="team-grid">
                <div class="team-member">
                    <img src="{{ asset('images/team1.jpg') }}" alt="Team Member">
                    <h3>Prince Erickson M. Sanado</h3>
                    <p>Programmer</p>
                </div>
                <div class="team-member">
                    <img src="{{ asset('images/team2.jpg') }}" alt="Team Member">
                    <h3>Daryl S. Lamay</h3>
                    <p>Programmer</p>
                </div>
                <div class="team-member">
                    <img src="{{ asset('images/team3.jpg') }}" alt="Team Member">
                    <h3>Mel Duo</h3>
                    <p>Designer</p>
                </div>
                <div class="team-member">
                    <img src="{{ asset('images/team4.jpg') }}" alt="Team Member">
                    <h3>Arvin Jay B. Lazan</h3>
                    <p>Designer</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .about-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .about-container h1 {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 2rem;
        text-align: center;
    }

    .about-content {
        display: grid;
        gap: 3rem;
    }

    .about-text h2 {
        color: #333;
        margin-bottom: 1rem;
        font-size: 1.8rem;
    }

    .about-text p {
        color: #666;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .team-section h2 {
        color: #333;
        margin-bottom: 2rem;
        text-align: center;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }

    .team-member {
        text-align: center;
    }

    .team-member img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 1rem;
    }

    .team-member h3 {
        color: #333;
        margin-bottom: 0.5rem;
    }

    .team-member p {
        color: #666;
    }
</style>
@endsection 
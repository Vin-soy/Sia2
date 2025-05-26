@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="header">
    <div class="header_left">
        <h1>A home built and unique with love and dreams</h1>
        <p>
            Discover a curated selection of homes, apartments, and commercial
            properties, along with expert tips, market insights, and valuable
            resources to help you make the best real estate decisions. Join us
            today and let's unlock the doors to your dream property!
        </p>
    </div>
    
    <div class="header_right">
        <div class="header_image">
            <img src="{{ asset('assets/header.png') }}" alt="header" />
        </div>
    </div>
</div>

<style>
    .header {
        display: flex;
        padding: 2rem;
        gap: 2rem;
    }

    .header_left {
        flex: 1;
        padding: 2rem;
    }

    .header_left h1 {
        font-size: 3rem;
        font-weight: 600;
        color: #333333;
        margin-bottom: 1rem;
    }

    .header_left p {
        color: #767268;
        line-height: 1.6;
    }

    .header_right {
        flex: 1;
    }

    .header_image img {
        width: 100%;
        height: auto;
        border-radius: 20px;
        object-fit: cover;
    }
</style>
@endsection 
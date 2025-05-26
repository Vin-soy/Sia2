@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="contact-container">
    <h1>Contact Us</h1>
    
    <div class="contact-content">
        <div class="contact-info">
            <h2>Get in Touch</h2>
            <p>We're here to help you with any questions about our properties or services.</p>
            
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <h3>Office Address</h3>
                    <p>123 Real Estate Street<br>City, State 12345</p>
                </div>
            </div>
            
            <div class="info-item">
                <i class="fas fa-phone"></i>
                <div>
                    <h3>Phone</h3>
                    <p>+1 (123) 456-7890</p>
                </div>
            </div>
            
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <div>
                    <h3>Email</h3>
                    <p>info@paupa.com</p>
                </div>
            </div>
            
            <div class="office-hours">
                <h3>Office Hours</h3>
                <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                <p>Saturday: 10:00 AM - 4:00 PM</p>
                <p>Sunday: Closed</p>
            </div>
        </div>

        <div class="contact-form">
            <h2>Send us a Message</h2>
            <form action="" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="submit-btn">Send Message</button>
            </form>
        </div>
    </div>
</div>

<style>
    .contact-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .contact-container h1 {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 2rem;
        text-align: center;
    }

    .contact-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
    }

    .contact-info h2,
    .contact-form h2 {
        color: #333;
        margin-bottom: 1.5rem;
        font-size: 1.8rem;
    }

    .info-item {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .info-item i {
        font-size: 1.5rem;
        color: #4CAF50;
        margin-top: 0.25rem;
    }

    .info-item h3 {
        color: #333;
        margin-bottom: 0.5rem;
    }

    .info-item p {
        color: #666;
        line-height: 1.4;
    }

    .office-hours {
        margin-top: 2rem;
    }

    .office-hours h3 {
        color: #333;
        margin-bottom: 0.5rem;
    }

    .office-hours p {
        color: #666;
        margin-bottom: 0.25rem;
    }

    .contact-form form {
        display: grid;
        gap: 1.5rem;
    }

    .form-group {
        display: grid;
        gap: 0.5rem;
    }

    .form-group label {
        color: #333;
        font-weight: 500;
    }

    .form-group input,
    .form-group textarea {
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
    }

    .form-group textarea {
        resize: vertical;
    }

    .submit-btn {
        background-color: #4CAF50;
        color: white;
        padding: 1rem;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .submit-btn:hover {
        background-color: #45a049;
    }

    @media (max-width: 768px) {
        .contact-content {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection 
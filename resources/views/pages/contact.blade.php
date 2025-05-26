@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="contact-container">
    <h1>Contact Us</h1>
    
    <div class="contact-content">
        <div class="contact-info">
            <h2>Get in Touch</h2>
            <p class="subtitle">We're here to help you with any questions about our properties or services.</p>
            
            <div class="info-grid">
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h3>Office Address</h3>
                        <p>123 Real Estate Street, City, State 12345</p>
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
                
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <h3>Office Hours</h3>
                        <p>Mon-Fri: 9AM-6PM<br>Sat: 10AM-4PM</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="contact-form">
            <h2>Send us a Message</h2>
            <form action="" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="4" required></textarea>
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
        padding: 1.5rem;
    }

    .contact-container h1 {
        font-size: 2rem;
        color: #333;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .contact-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: start;
    }

    .contact-info h2,
    .contact-form h2 {
        color: #333;
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }

    .subtitle {
        color: #666;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .info-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        background-color: #f8f8f8;
        border-radius: 8px;
    }

    .info-item i {
        font-size: 1.2rem;
        color: #002040;
        margin-top: 0.25rem;
    }

    .info-item h3 {
        color: #333;
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }

    .info-item p {
        color: #666;
        line-height: 1.4;
        font-size: 0.9rem;
    }

    .contact-form form {
        display: grid;
        gap: 1rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .form-group {
        display: grid;
        gap: 0.25rem;
    }

    .form-group label {
        color: #333;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .form-group input,
    .form-group textarea {
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 0.9rem;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .submit-btn {
        background-color: #002040;
        color: white;
        padding: 0.75rem;
        border: none;
        border-radius: 5px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 0.5rem;
    }

    .submit-btn:hover {
        background-color: #003366;
    }

    @media (max-width: 768px) {
        .contact-content {
            grid-template-columns: 1fr;
        }
        
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection 
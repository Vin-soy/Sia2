<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title') - PaUpa</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap");
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                font-family: "Open sans", sans-serif;
            }

            .nav_var {
                background-color: rgb(242, 237, 237);
                align-items: center;
                justify-content: space-between;
                margin: auto;
                height: 70px;
                padding: 2rem 1rem;
                display: flex;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;
            }

            .nav_logo{
                flex: 1;
                display: flex;
                align-items: center;
            }

            .nav_logo img {
                height: 40px;
                width: auto;
            }

            .nav_links{
                list-style: none;
                display: flex;
                gap: 2rem;
                margin-right: 2rem;
            }
            
            .link a {
                text-decoration: none;
                font-weight: 500;
                color: #333333;
                position: relative;
                padding: 0.5rem 0;
                transition: color 0.3s ease;
            }

            .link a::after {
                content: '';
                position: absolute;
                width: 0;
                height: 2px;
                bottom: 0;
                left: 0;
                background-color: #002040;
                transition: width 0.3s ease;
            }

            .link a:hover {
                color: #002040;
            }

            .link a:hover::after {
                width: 100%;
            }

            /* Add active state for current page */
            .link a.active {
                color: #002040;
            }

            .link a.active::after {
                width: 100%;
            }

            .nav_btns {
                flex: 1;
                display: flex;
                justify-content: end;
                gap: 1rem;
            }
            .nav_btns a {
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
                outline: none;
                border-radius: 5px;
                cursor: pointer;
                transition: 0.3s;
                text-decoration: none;
            }
            .login_btn {
                color: white;
                background-color: black;
            }

            .register_btn {
                color: white;
                background-color: black;
            }

            .content {
                margin-top: 90px;
                padding: 2rem;
                opacity: 0;
                transform: translateY(20px);
                animation: fadeInUp 0.6s ease forwards;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Modal Styles */
            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.7);
                z-index: 2000;
                align-items: center;
                justify-content: center;
            }

            .modal.active {
                display: flex;
            }

            .modal-content {
                background-color: white;
                border-radius: 15px;
                width: 100%;
                max-width: 900px;
                position: relative;
                display: flex;
                overflow: hidden;
                box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            }

            .modal-left {
                flex: 1;
                padding: 3rem;
            }

            .modal-right {
                flex: 1;
                background-image: url('{{ asset("assets/project-3.jpg") }}');
                background-size: cover;
                background-position: center;
                position: relative;
            }

            .modal-right::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(45deg, rgba(0,32,63,0.7), rgba(0,32,63,0.4));
            }

            .close-btn {
                position: absolute;
                top: 1rem;
                right: 1rem;
                font-size: 1.5rem;
                cursor: pointer;
                color: #666;
                z-index: 1;
            }

            .form-header {
                margin-bottom: 2rem;
            }

            .form-title {
                font-size: 2rem;
                color: #002040;
                margin-bottom: 0.5rem;
                font-weight: 600;
            }

            .form-subtitle {
                color: #666;
                font-size: 0.9rem;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            .form-group label {
                display: block;
                margin-bottom: 0.25rem;
                color: #002040;
                font-weight: 500;
                font-size: 0.9rem;
            }

            .form-group input {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid #e1e1e1;
                border-radius: 8px;
                font-size: 0.95rem;
                transition: all 0.3s ease;
                background-color: #f8f8f8;
            }

            .form-group input:focus {
                outline: none;
                border-color: #002040;
                background-color: #fff;
                box-shadow: 0 0 0 2px rgba(0, 32, 64, 0.1);
            }

            .form-group input::placeholder {
                color: #999;
            }

            .form-submit {
                width: 100%;
                padding: 0.875rem;
                background-color: #002040;
                color: white;
                border: none;
                border-radius: 8px;
                font-size: 1rem;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.3s ease;
                margin-top: 0.5rem;
            }

            .form-submit:hover {
                background-color: #003366;
                transform: translateY(-1px);
            }

            .form-footer {
                margin-top: 1.5rem;
                text-align: center;
                font-size: 0.9rem;
                color: #666;
            }

            .form-footer a {
                color: #002040;
                font-weight: 500;
                text-decoration: none;
                margin-left: 0.25rem;
            }

            .form-footer a:hover {
                text-decoration: underline;
            }

            .social-login {
                margin-top: 1.5rem;
                text-align: center;
            }

            .social-login p {
                color: #666;
                font-size: 0.9rem;
                margin-bottom: 1rem;
                position: relative;
            }

            .social-login p::before,
            .social-login p::after {
                content: '';
                position: absolute;
                top: 50%;
                width: 45%;
                height: 1px;
                background-color: #e1e1e1;
            }

            .social-login p::before {
                left: 0;
            }

            .social-login p::after {
                right: 0;
            }

            .social-buttons {
                display: flex;
                justify-content: center;
                gap: 1rem;
            }

            .social-button {
                width: 40px;
                height: 40px;
                border: 1px solid #e1e1e1;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s ease;
                background-color: #fff;
            }

            .social-button:hover {
                border-color: #002040;
                transform: translateY(-2px);
            }

            .social-button i {
                color: #666;
                font-size: 1.1rem;
            }

            /* Page Transition Styles */
            .page-transition {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(255, 255, 255, 0.9);
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
            }

            .page-transition.active {
                opacity: 1;
                pointer-events: all;
            }

            .loading-spinner {
                width: 40px;
                height: 40px;
                border: 3px solid #f3f3f3;
                border-top: 3px solid #002040;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            .alert {
                padding: 1rem;
                border-radius: 8px;
                margin-bottom: 1.5rem;
            }

            .alert-error {
                background-color: #FEE2E2;
                border: 1px solid #FCA5A5;
                color: #DC2626;
            }

            .alert-error ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
            }

            .alert-error li {
                margin-bottom: 0.5rem;
            }

            .alert-error li:last-child {
                margin-bottom: 0;
            }

            .error-message {
                display: block;
                color: #DC2626;
                font-size: 0.875rem;
                margin-top: 0.5rem;
            }

            .form-group input.error,
            .form-group select.error {
                border-color: #DC2626;
            }
        </style>
    </head>
    <body>
        <!-- Page Transition Overlay -->
        <div class="page-transition">
            <div class="loading-spinner"></div>
        </div>

        <nav>
            <div class="nav_var">
                <div class="nav_logo">
                    <img src="{{ asset('images/logo.png') }}" alt="PaUpa Logo">
                </div>
                <ul class="nav_links">
                    <li class="link"><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                    <li class="link"><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
                    <li class="link"><a href="{{ route('sample') }}" class="{{ request()->routeIs('sample') ? 'active' : '' }}">Sample</a></li>
                    <li class="link"><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
                </ul>
                <div class="nav_btns">
                    <a href="#" class="login_btn" onclick="openModal('loginModal')">Login</a>
                    <a href="#" class="register_btn" onclick="openModal('registerModal')">Register</a>
                </div>
            </div>
        </nav>

        <!-- Login Modal -->
        <div id="loginModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal('loginModal')">&times;</span>
                <div class="modal-left">
                    <div class="form-header">
                        <h2 class="form-title">Welcome Back</h2>
                        <p class="form-subtitle">Please enter your details to sign in</p>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required value="{{ old('email') }}">
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="remember-forgot">
                            <label class="remember-me">
                                <input type="checkbox" name="remember">
                                <span>Remember me</span>
                            </label>
                            <a href="#" class="forgot-password">Forgot Password?</a>
                        </div>
                        <button type="submit" class="form-submit">Sign In</button>
                        <div class="social-login">
                            <p>Or continue with</p>
                            <div class="social-buttons">
                                <div class="social-button">
                                    <i class="fab fa-google"></i>
                                </div>
                                <div class="social-button">
                                    <i class="fab fa-apple"></i>
                                </div>
                                <div class="social-button">
                                    <i class="fab fa-facebook-f"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-footer">
                            Don't have an account? <a href="#" onclick="switchModal('loginModal', 'registerModal')">Sign up</a>
                        </div>
                    </form>
                </div>
                <div class="modal-right"></div>
            </div>
        </div>

        <!-- Register Modal -->
        <div id="registerModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal('registerModal')">&times;</span>
                <div class="modal-left">
                    <div class="form-header">
                        <h2 class="form-title">Welcome to PaUpa</h2>
                        <p class="form-subtitle">Create your account to get started</p>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter your full name" required value="{{ old('name') }}">
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="reg-email">Email</label>
                            <input type="email" id="reg-email" name="email" placeholder="Enter your email" required value="{{ old('email') }}">
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="reg-password">Password</label>
                            <input type="password" id="reg-password" name="password" placeholder="Create a strong password" required>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                            @error('password_confirmation')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">I am a</label>
                            <select id="role" name="role" class="form-input" required>
                                <option value="">Select your role</option>
                                <option value="tenant" {{ old('role') == 'tenant' ? 'selected' : '' }}>Tenant</option>
                                <option value="landlord" {{ old('role') == 'landlord' ? 'selected' : '' }}>Landlord</option>
                            </select>
                            @error('role')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="form-submit">Create Account</button>
                        <div class="social-login">
                            <p>Or sign up with</p>
                            <div class="social-buttons">
                                <div class="social-button">
                                    <i class="fab fa-google"></i>
                                </div>
                                <div class="social-button">
                                    <i class="fab fa-apple"></i>
                                </div>
                                <div class="social-button">
                                    <i class="fab fa-facebook-f"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-footer">
                            Already have an account? <a href="#" onclick="switchModal('registerModal', 'loginModal')">Sign in</a>
                        </div>
                    </form>
                </div>
                <div class="modal-right"></div>
            </div>
        </div>

        <div class="content">
            @yield('content')
        </div>

        <script>
            function openModal(modalId) {
                document.getElementById(modalId).classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.remove('active');
                document.body.style.overflow = 'auto';
            }

            function switchModal(closeModalId, openModalId) {
                closeModal(closeModalId);
                openModal(openModalId);
            }

            // Close modal when clicking outside
            window.onclick = function(event) {
                if (event.target.classList.contains('modal')) {
                    closeModal(event.target.id);
                }
            }

            // Page Transition Handler
            document.addEventListener('DOMContentLoaded', function() {
                const transitionOverlay = document.querySelector('.page-transition');
                const links = document.querySelectorAll('a[href]:not([target="_blank"]):not([href^="#"])');

                links.forEach(link => {
                    link.addEventListener('click', function(e) {
                        // Don't handle modal links or external links
                        if (this.getAttribute('onclick') || this.getAttribute('href').startsWith('#')) {
                            return;
                        }

                        e.preventDefault();
                        const targetHref = this.getAttribute('href');

                        // Show transition overlay
                        transitionOverlay.classList.add('active');

                        // Navigate after transition
                        setTimeout(() => {
                            window.location.href = targetHref;
                        }, 300);
                    });
                });

                // Hide transition overlay when page loads
                window.addEventListener('load', function() {
                    transitionOverlay.classList.remove('active');
                });

                // Handle browser back/forward buttons
                window.addEventListener('popstate', function() {
                    transitionOverlay.classList.add('active');
                    setTimeout(() => {
                        transitionOverlay.classList.remove('active');
                    }, 300);
                });
            });
        </script>
    </body>
</html>

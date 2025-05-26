<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title') - PaUpa</title>

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
            }
        </style>
    </head>
    <body>
        <nav>
            <div class="nav_var">
                <div class="nav_logo">
                    <img src="{{ asset('images/logo.png') }}" alt="PaUpa Logo">
                </div>
                <ul class="nav_links">
                    <li class="link"><a href="{{ route('home') }}">Home</a></li>
                    <li class="link"><a href="{{ route('about') }}">About</a></li>
                    <li class="link"><a href="{{ route('sample') }}">Sample</a></li>
                    <li class="link"><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
                <div class="nav_btns">
                    <a href="{{ route('login') }}" class="login_btn">Login</a>
                    <a href="{{ route('register') }}" class="register_btn">Register</a>
                </div>
            </div>
        </nav>

        <div class="content">
            @yield('content')
        </div>
    </body>
</html>

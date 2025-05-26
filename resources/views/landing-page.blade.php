<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap");
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Open sans", sans-serif ;
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
        }

        .nav_logo{
            flex: 1;
        }

        .nav_links{
            list-style: none;
            display: flex;
            gap: 2rem;
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
        .header {
            margin-top: 80px;
            display: flex;
            padding: 2rem;
        }

        .header_left {
            padding: 4rem;
            text-align: center;
            align-items: center;
            flex: 2;
        }
        .header_left h1 {
            font-size: 4rem;
            font-weight: 600;
            color: #333333;
        }
        .header_left p {
            color: #767268;

        }
        .header_right {
            flex-grow: 4;
            flex: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .header_image {
            overflow: hidden;
        }
        .header_image img {
            width: 100%;
            object-fit: cover;
            border-radius: 20px;
        }
    </style>
</head>
<body>
 
    <nav>
        <div class="nav_var">
            <div class="nav_logo">PaUpa</div>
            <ul class="nav_links">
                <li class="link"><a href="">Home</a></li>
                <li class="link"><a href="">About</a></li>
                <li class="link"><a href="">Sample</a></li>
                <li class="link"><a href="">Contact</a></li>
            </ul>
            <div class="nav_btns">
                <a href="{{ route('login') }}" class="login_btn">Login</a>
                <a href="{{ route('register') }}" class="register_btn">Register</a>
            </div>
        </div>
    </nav>

    <header class="header">
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
            
            <img src="assets/header.png" alt="header" />
          </div>
        </div>
    </header>
    
</body>
</html>
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
        .nav_btns button {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            outline: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .login_btn {
            color: #333333;
            border: 2px solid #767268;
            background-color: transparent;
        }

        .register_btn {
            color: white;
            border: 2px solid #5d5fef;
            background-color: #5d5fef;
        }
        .header {
            background-color: #f8f8f8;
            margin-top: 80px;
        }
        .header_container {
            display: grid;
            grid-template-columns:
            minmax(0, 1fr)
            minmax(0, calc(var(--max-width) / 2))
            minmax(0, 1fr);
        }
        .header__content {
            padding: 5rem 1rem;
            grid-column: 2/3;
        }
        .header__content h1 {
            margin-bottom: 1rem;
            font-size: 4rem;
            font-weight: 600;
            line-height: 5rem;
            color: var(--text-dark);
        }
        .header__content p {
            margin-bottom: 2rem;
            color: var(--text-light);
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
                <button>Login</button>
                <button>Register</button>
            </div>
        </div>
    </nav>

    <header class="header">
        <div class="header_container">
            <div class="header_content">
                <h1>A home built and unique with love and dreams</h1>
                <p>
                    Discover a curated selection of homes, apartments, and commercial
                    properties, along with expert tips, market insights, and valuable
                    resources to help you make the best real estate decisions. Join us
                    today and let's unlock the doors to your dream property!
                </p>
                
                <div class="header_image">
                    <div class="img"></div>
                </div>
            </div>
        </div>
    </header>
</body>
</html>
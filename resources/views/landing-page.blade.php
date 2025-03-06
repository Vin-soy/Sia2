<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .nav_var {
            background-color: red;
            align-items: center;
            justify-content: space-between;
            margin: auto;
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
            font-weight: 600;
            color: #333333;
        }

        .nav_btns {
            flex: 1;
            display: flex;
            justify-content: end;
            gap: 1rem;
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

</body>
</html>
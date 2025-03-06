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
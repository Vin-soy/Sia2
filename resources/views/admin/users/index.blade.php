<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
   @include('admin.layouts.nav')

    <main class="container">
        <div class="tenant">
            <h2>Tenants</h2>

            <div class="tenant-col">
                @foreach ($users as $user)
                    
                    <div class="tenant-info">
                        <div class="left-side">
                            <img class="user-img" src="images/1 (1).jpg" alt="">
                            <p>{{ $user->name }}</p>
                        </div>
                        <div class="right-side">
                            <p>banned</p>
                            <button>Ban</button>
                        </div>
                    </div>
                @endforeach
                
                <div class="tenant-info">
                    <div class="left-side">
                        <img class="user-img" src="images/1 (1).jpg" alt="">
                        <p>Lorem ipsom</p>
                    </div>
                    <div class="right-side">
                        <p>banned</p>
                        <button>Ban</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="landlord">
            <h2>Landlords</h2>

            <div class="tenant-col">
                <div class="tenant-info">
                    <div class="left-side">
                        <img class="user-img" src="images/1 (1).jpg" alt="">
                        <p>Lorem ipsom</p>
                    </div>
                    <div class="right-side">
                        <p>banned</p>
                        <button>Ban</button>
                    </div>
                </div>
                <div class="tenant-info">
                    <div class="left-side">
                        <img class="user-img" src="images/1 (1).jpg" alt="">
                        <p>Lorem ipsom</p>
                    </div>
                    <div class="right-side">
                        <p>banned</p>
                        <button>Ban</button>
                    </div>
                </div>
                <div class="tenant-info">
                    <div class="left-side">
                        <img class="user-img" src="images/1 (1).jpg" alt="">
                        <p>Lorem ipsom</p>
                    </div>
                    <div class="right-side">
                        <p>banned</p>
                        <button>Ban</button>
                    </div>
                </div>
                <div class="tenant-info">
                    <div class="left-side">
                        <img class="user-img" src="images/1 (1).jpg" alt="">
                        <p>Lorem ipsom</p>
                    </div>
                    <div class="right-side">
                        <p>banned</p>
                        <button>Ban</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
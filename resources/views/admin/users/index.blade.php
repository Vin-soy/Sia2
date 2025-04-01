@extends('admin.dashboard')


@section('content')
<div class="tenant">
    <h2>Tenants</h2>

    <div class="tenant-col">
        @foreach ($users as $user)
            
            <div class="tenant-info">
                <div class="left-side">
                    <img class="user-img" src="{{ asset('images/2.jpg') }}" alt="">
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
@endsection
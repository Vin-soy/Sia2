<nav class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="">
    </div>
    <ul class="nav-list">
        <a href="{{ route('tenant.home') }}">
            <li>
                <i class='bx bx-grid-alt'></i>
                Home
            </li>
        </a>
        
        <a href="{{ route('tenant.account') }}">
            <li>
                <i class='bx bx-user'></i>
                Accounts
            </li>
        </a>
        <a href="{{ route('tenant.history') }}">
            <li>
                <i class='bx bx-cart-alt'></i>
                <p>Listings</p>
            </li>
        </a>
        <a href="{{ route('tenant.profile') }}">
            <li>
                <i class='bx bx-user'></i>
                <p>Profile</p>
            </li>
        </a>
    </ul>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="logout_btn" type="submit">Log Out</button>
    </form>
</nav>
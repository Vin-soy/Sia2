<nav class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="">
    </div>
    <ul class="nav-list">
        <li>
            <i class='bx bx-grid-alt'></i>
            <a href="">Home</a>
        </li>
        <a href="{{ route('users.index') }}">
            <li>
                <i class='bx bx-user'></i>
                Accounts
            </li>
        </a>

        <a href="{{ route('rentals.index') }}">
            <li>
                <i class='bx bx-folder'></i>
                Listing
            </li>
        </a>
        
        <li>
            <i class='bx bx-cart-alt'></i>
            <a href="">Reports</a>
        </li>
        <li>
            <i class='bx bx-user'></i>
            <a href="">Profile</a>
        </li>
    </ul>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Log Out</button>
    </form>
   
</nav>
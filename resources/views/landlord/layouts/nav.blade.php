<nav class="sidebar">
    <div>Logo</div>
    <ul class="nav-list">
        <a href="{{ route('landlord.home') }}">
            <li>
                <i class='bx bx-grid-alt'></i>
                Home
            </li>
        </a>
        
        <a href="{{ route('landlord.account') }}">
            <li>
                <i class='bx bx-user'></i>
                Accounts
            </li>
        </a>
        <a href="{{ route('landlord.history') }}">
            <li>
                <i class='bx bx-cart-alt'></i>
                <p>History</p>
            </li>
        </a>
        
        <a href="{{ route('landlord.profile') }}">
            <li>
                <i class='bx bx-user'></i>
                <p>Profile</p>
            </li>
        </a>
    </ul>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Log Out</button>
    </form>
   
</nav>
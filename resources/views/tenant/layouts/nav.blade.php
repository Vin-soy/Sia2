<nav class="sidebar">
    <div>Logo</div>
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
                <p>History</p>
            </li>
        </a>
       
        <li>
            <i class='bx bx-user'></i>
            <p>Profile</p>
        </li>
    </ul>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Log Out</button>
    </form>
   
</nav>
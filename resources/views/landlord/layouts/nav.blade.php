<nav class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="">
    </div>
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

        <a href="{{ route('landlord.notifications') }}" class="notification-link">
            <li>
                <i class='bx bx-bell'></i>
                <p>Notifications</p>
                @if(isset($pendingApplications) && $pendingApplications > 0)
                    <span class="notification-badge">{{ $pendingApplications }}</span>
                @endif
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
        <button class="logout_btn" type="submit">Log Out</button>
    </form>
</nav>

<style>
.notification-link {
    position: relative;
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #dc2626;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
    min-width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
}

.nav-list a {
    text-decoration: none;
    color: inherit;
    position: relative;
}

.nav-list li {
    position: relative;
    display: flex;
    align-items: center;
    padding: 12px 15px;
    margin: 8px 0;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.nav-list li:hover {
    background: rgba(255, 255, 255, 0.1);
}

.nav-list i {
    font-size: 20px;
    margin-right: 10px;
}
</style>
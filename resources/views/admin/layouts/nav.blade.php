<nav class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="">
    </div>
    <ul class="nav-list">

        <a href="{{ route('admin.home') }}">
            <li>
                <i class='bx bx-grid-alt'></i>
                Home
            </li>
        </a>
        
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
        
        <a href="{{ route('admin.reports') }}">
            <li>
                <i class='bx bx-chart'></i>
                Reports
            </li>
        </a>
        <a href="{{ route('admin.profile') }}">
            <li>
                <i class='bx bx-user'></i>
                Profile
            </li>
        </a>
    </ul>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Log Out</button>
    </form>
</nav>
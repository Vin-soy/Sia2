<nav class="sidebar">
    <div>Logo</div>
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
    <div>Log Out</div>
</nav>
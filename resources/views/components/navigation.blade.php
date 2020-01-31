<div class="navigation">
    <input onchange="closeContainer(this)" id="burger" type="checkbox">
    <label class="burger" for="burger">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56 56">
            <path
                d="M28 0C12.561 0 0 12.561 0 28s12.561 28 28 28 28-12.561 28-28S43.439 0 28 0zm0 54C13.663 54 2 42.336 2 28S13.663 2 28 2s26 11.664 26 26-11.663 26-26 26z" />
            <path
                d="M40 16H16a1 1 0 100 2h24a1 1 0 100-2zM40 27H16a1 1 0 100 2h24a1 1 0 100-2zM40 38H16a1 1 0 100 2h24a1 1 0 100-2z" />
        </svg>
    </label>
    <ul class="navigation__menu">
        <li class="desktop-link">
            <a href="{{ route('categories.user-view') }}">Categories</a>
        </li>
        @vip
        <li>
            <a href="{{ route('products', ['category' => 15]) }}">VIP</a>
        </li>
        @endvip
        @admin
        <li>
            <a href="{{ route('categories.index') }}">Category list</a>
        </li>
        <li>
            <a href="{{ route('products.index') }}">Product list</a>
        </li>
        <li>
            <a href="{{ route('orders.index') }}">Order list</a>
        </li>
        <li>
            <a href="{{ route('users.index') }}">User list</a>
        </li>
        @else
        @auth
        <li>
            <a href="{{ route('users.profile') }}">My account</a>
        </li>
        @endauth
        @endadmin
        @auth
        <li>
            <a href="#" onclick="
                event.preventDefault();
                window.cartObj.clear();
                document.getElementById('logout-form').submit();
            ">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
        </li>
        @else
        <li>
            <a href="{{ route('login') }}">Login</a>
        </li>
        <li>
            <a href="{{ route('register') }}">Register</a>
        </li>
        @endauth
        <li>
            <a href="{{ route('terms') }}">Terms and conditions</a>
        </li>
    </ul>
</div>

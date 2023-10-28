<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm">
  <div class="container-fluid mx-2">
    <a class="navbar-brand" href="/">
      <h4>CHADSHOP</h4>
      <p>SUPPLEMENT</p>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarTogglerDemo02">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ URL::to('kategori') }}">Category</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ URL::to('kontak') }}">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ URL::to('about') }}">About</a>
        </li>
      </ul>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item">
          <form class="d-flex search" role="search" action="/cari" method="GET">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="key">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </li>
      </ul>
      <ul class="navbar-nav mb-2 mb-lg-0">
      @guest
        @if (Route::has('login'))
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
          </li>
        @endif

        @if (Route::has('register'))
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
          </li>
        @endif
        <li class="nav-item">
          <a class="nav-link" href="{{ route('wishlist.index') }}"><i class="fa-solid fa-heart"></i> Wishlist</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('cart.index') }}"><i class="fa-solid fa-cart-shopping"></i> Cart</a>
        </li>
      @else
        <li class="nav-item dropdown">
          <div class="btn-group">
            <button type="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
            {{ Auth::user()->name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-lg-end">
              <li><a class="dropdown-item" href="{{ URL::to('transaksi_list') }}"><i class="fa-solid fa-bars-staggered"></i> Daftar Transaksi</a></li>
              @if (Auth::user()->role == 'member')
              <li><a class="dropdown-item" href="{{ URL::to('profil') }}"><i class="fa-solid fa-user"></i> Profil User</a></li>
              @endif
              <li><hr class="dropdown-divider"></li>
              @if (Auth::user()->role == 'seller')
                <li><a class="dropdown-item" href="{{ URL::to('/seller') }}"><i class="fa-solid fa-repeat"></i> Switch to sell</a></li>
              @elseif (Auth::user()->role == 'admin')
                <li><a class="dropdown-item" href="{{ URL::to('/admin') }}"><i class="fa-solid fa-repeat"></i> Switch to admin</a></li>
              @endif
              <li>
                <a class="dropdown-item logout-btn" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('wishlist.index') }}">(<livewire:wishlist-count>) <i class="fa-solid fa-heart"></i> Wishlist</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('cart.index') }}">(<livewire:cart-count>) <i class="fa-solid fa-cart-shopping"></i> Cart</a>
        </li>
      @endguest
    </div>
  </div>
</nav>
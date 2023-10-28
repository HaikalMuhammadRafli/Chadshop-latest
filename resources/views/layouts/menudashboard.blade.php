<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
      <li class="nav-item">
        <a href="{{ URL::to('seller') }}" class="nav-link">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-folder-open"></i>
          <p>
            Produk
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('produk.index') }}" class="nav-link">
              <i class="nav-icon fas fa-store"></i>
              <p>Produk</p>
            </a>
          </li>
          <li class="nav-item">
            <li class="nav-item">
              <a href="{{ route('promo.index') }}" class="nav-link">
                <i class="nav-icon fas fa-tags"></i>
                <p>Promo</p>
              </a>
            </li>
          </li>
          <li class="nav-item">
            <li class="nav-item">
              <a href="{{ route('eventdetail.index') }}" class="nav-link">
                <i class="nav-icon fas fa-calendar"></i>
                <p>Produk Event</p>
              </a>
            </li>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="{{ URL::to('seller/pesanan') }}" class="nav-link">
          <i class="nav-icon fas fa-receipt"></i>
          <p>
            Pesanan
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ URL::to('seller/profil') }}" class="nav-link">
          <i class="nav-icon fas fa-users"></i>
          <p>
            Profil
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
          <i class="nav-icon fas fa-sign-out-alt"></i>
          <p>
            Sign Out
          </p>
        </a>
      </li>
    </ul>
  </nav>

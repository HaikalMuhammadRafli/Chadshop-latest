<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
      <li class="nav-item">
        <a href="{{ URL::to('admin') }}" class="nav-link">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('kategori.index') }}" class="nav-link">
          <i class="nav-icon fas fa-layer-group"></i>
          <p>
            Kategori
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('event.index') }}" class="nav-link">
          <i class="nav-icon fas fa-calendar"></i>
          <p>
            Event
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('transaksi.index') }}" class="nav-link">
          <i class="nav-icon fas fa-receipt"></i>
          <p>
            Transaksi
          </p>
        </a>
      </li>
      <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              Setting
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('slideshow.index') }}" class="nav-link">
                <i class="far fa-images nav-icon"></i>
                <p>Slideshow</p>
              </a>
            </li>
          </ul>
        </a>
      </li>
      <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-folder"></i>
            <p>
              Pages
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ URL::to('admin/about') }}" class="nav-link">
                <i class="far fa-images nav-icon"></i>
                <p>About Us Page</p>
              </a>
            </li>
          </ul>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ URL::to('admin/kontak') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Contact Us Page</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="{{ URL::to('admin/profil') }}" class="nav-link">
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

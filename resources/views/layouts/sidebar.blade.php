<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="{{ route('dashboard') }}" class="brand-link">
    <span class="brand-text font-weight-light">Inventaris & Aset</span>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        @php $u = session('user'); @endphp
        @if(($u['role'] ?? '') === 'admin')
        <li class="nav-item">
          <a href="{{ route('user.index') }}" class="nav-link"><p>Manajemen User</p></a>
        </li>
        @endif
        <li class="nav-item">
          <a href="{{ route('warga.index') }}" class="nav-link"><p>Warga</p></a>
        </li>
        <li class="nav-item">
          <a href="{{ route('bina-desa.index') }}" class="nav-link"><p>Bina Desa</p></a>
        </li>
      </ul>
    </nav>
  </div>
</aside>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">☰</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    @php $u = session('user'); @endphp
    <li class="nav-item">
      <span class="nav-link">Hai, {{ $u['name'] ?? 'Tamu' }}</span>
    </li>
    <li class="nav-item">
      <form method="post" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-sm btn-outline-secondary">Logout</button>
      </form>
    </li>
  </ul>
</nav>

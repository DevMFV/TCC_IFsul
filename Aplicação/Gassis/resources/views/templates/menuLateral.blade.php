
 @yield('menu')

      <li class="nav-item active">
        <a class="nav-link" href="{{route('dashboard')}}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Página inicial</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.index')}}">
          <i class="fas fa-fw fa-user"></i>
          <span>Solicitantes</span></a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="{{route('tipoSol.index')}}">
          <i class="fas fa-fw fa-user"></i>
          <span>Tipo de Solicitante</span></a>
      </li>

      
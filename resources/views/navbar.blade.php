	<nav id='navbar' class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand rounded" style='background-color:rgba(255,255,255,.9)'>
   <!--  <img src="{{asset('images/logo.png')}}" width='100'> -->
   <span style='padding:15px;' >Ótica <b>Rose</b></span>
  </a>

  <div class=" navbar-collapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item @if($active=='visaoGeral') active @endif ">
        <a class="nav-link" href="{{route('pagina.geral')}}">Visao Geral</a>
      </li>
      <li class="nav-item @if($active=='clientes') active @endif ">
        <a class="nav-link" href="{{route('pagina.clientes')}}">Clientes</a>
      </li>
      <li class="nav-item @if($active=='modelos') active @endif">
        <a class="nav-link" href="{{route('pagina.modelos')}}">Modelos</a>
      </li>
      <li class="nav-item @if($active=='vendas') active @endif ">
        <a class="nav-link" href="{{route('pagina.vendas')}}">Vendas</a>
      </li>
      <
  </div>

  <ul><li>
    <a href="{{ route('logout') }}" style="color:grey; text-transform:none; text-decoration: none;"
        onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
        Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>



  </li></ul>
</nav>

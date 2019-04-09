	<nav id='navbar' class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand rounded" style='background-color:rgba(255,255,255,.9)'>
    <img src="{{asset('images/logo.png')}}" width='100'>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar"aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
  </div>
</nav>

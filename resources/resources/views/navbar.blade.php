	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Otica <br> <b>nome</b></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbar">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item @if($active=='visaoGeral') active @endif ">
        <a class="nav-link" href="dashboard">Visao Geral</a>
      </li>
      <li class="nav-item @if($active=='clientes') active @endif ">
        <a class="nav-link" href="clientes">Clientes</a>
      </li>
      <li class="nav-item @if($active=='modelos') active @endif">
        <a class="nav-link" href="modelos">Modelos</a>
      </li>
      <li class="nav-item @if($active=='vendas') active @endif ">
        <a class="nav-link" href="vendas">Vendas</a>
      </li>
  </div>
</nav>

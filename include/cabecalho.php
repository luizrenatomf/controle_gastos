<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script defer src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!-- endBootstrap -->   
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

  <title>Controle de gastos mensais</title>
</head>
<body>
        
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
  <?php if(isset($_COOKIE["email"]) && $_COOKIE["email"] != ""): ?>
    <a class="navbar-brand" href="principal.php">Controlin</a>
  <?php else: ?>
    <a class="navbar-brand" href="index.php">Controlin</a>
  <?php endif ?>  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php if(isset($_COOKIE["email"]) && $_COOKIE["email"] != ""): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            Incluir
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="incluir.php?tipo=RF">Receitas fixas</a>
            <a class="dropdown-item" href="incluir.php?tipo=RV">Receitas variáveis</a>
            <a class="dropdown-item" href="incluir.php?tipo=DF">Despesas fixas</a>
            <a class="dropdown-item" href="incluir.php?tipo=DV">Despesas variáveis</a>
          </div>
        </li>
      <?php endif ?> 
      <li class="nav-item">
        <a class="nav-link" href="periodo.php">Planilha</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="excluir.php">Excluir</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contato.php">Contato</a>
      </li>
    </ul>
    <ul class="navbar-nav">
      <li class="nav-item">
      <?php if(isset($_COOKIE["email"]) && $_COOKIE["email"] != ""): ?>
        <a class="nav-link" href="logout.php">Logout</a>
      <?php else: ?>
        <a class="nav-link" href="index.php">Login</a>
      <?php endif ?>
      </li>
    </ul>
  </div>
</nav>
<h1 align="center">Controle de gastos mensais</h1>
<h5 align="center" class="mb-3"><?= $nomePagina; ?></h5>
<hr>
<div id="mensagem"></div>
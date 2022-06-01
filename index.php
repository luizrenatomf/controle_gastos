<?php

$nomePagina = "Login";
include "include/cabecalho.php";

?>

<form action="login.php" method="post">
    <div class="container">
    <h5 align="center" class="mb-3">Digite seus dados de identificação para acessar o sistema:</h5>
        <div class="row justify-content-center">
            <div class="form-group col-md-4 mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group col-md-4 mb-4">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" name="senha" id="senha" required>
            </div>
        </div>
        <div class="row justify-content-center">
            <input type="submit" class="btn btn-primary col-md-2" value="&nbsp;Login&nbsp;">
        </div>
    </div>
</form>
<p align="center" class="mt-4">Esqueceu a senha? Clique <a href="/">aqui</a>.</p>
<p align="center" class="mt-3 mb-5">Não possui cadastro? Clique <a href="cadastro.php">aqui</a>.</p>

<?php

include "include/rodape.php";

?>
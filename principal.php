<?php

include "include/valida_cookies.inc";
$nomePagina = "Usuário: " . $_COOKIE["email"];
include "include/cabecalho.php";

?>

<p align="center">Seja bem vindo! Escolha a opção desejada:</p>
<p align="center">
    <b>Incluir:</b><br>
    <a href="incluir.php?tipo=RF"><font size="4">Receitas fixas</font></a><br>
    <a href="incluir.php?tipo=RV"><font size="4">Receitas variáveis</font></a><br>
    <a href="incluir.php?tipo=DF"><font size="4">Despesas fixas</font></a><br>
    <a href="incluir.php?tipo=DV"><font size="4">Despesas variáveis</font></a><br>
</p>
<p align="center">
    <b>Visualizar:</b><br>
    <a href="periodo.php"><font size="4">Planilha de gastos mensais</font></a>
</p>
<p align="center">
    <b>Excluir:</b><br>
    <a href="excluir.php"><font size="4">Excluir receitas e despesas</font></a><br>
</p>

<?php

include "include/rodape.php";

?>
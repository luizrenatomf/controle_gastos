<?php

require_once "include/conecta_banco.inc";
include "include/cabecalho.php";

$email = $_POST["email"];
$senha = $_POST["senha"];



$sql ="select * from usuarios_autorizados where email='$email' and senha='$senha'";
$res = $conexao->query($sql);
$rows = $res->fetchAll();

if(empty($rows)) {
    echo "<html><body>";
    echo "<p align=\"center\">O login não foi realizado porque os dados digitados são inválidos.</p>";
    echo "<p align=\"center\"><a href=\"index.php\">Voltar</a></p>";
    echo "</body></html>";
}
else {    
    setcookie("email",$email);
    setcookie("senha",$senha);
    header("Location: principal.php");
}

include "include/rodape.php";

?>
<?php

require_once "include/valida_cookies.inc";
require_once "include/conecta_banco.inc";

$email   = $_COOKIE["email"];
$tipo      = $_POST["tipo"];
$descricao = $_POST["descricao"];
$mes       = $_POST["mes"];
$ano       = $_POST["ano"];
$valor     = $_POST["valor"];
$valor     = preg_replace('/[,]+/', '.', $_POST["valor"]);
$data      = "$ano-$mes-01";

if($descricao == "nova")
{
    $nova_descricao = $_POST["descricao_nova"];
}
else
{
    $nova_descricao = $_POST["descricao_existente"];
}

$sql = "insert into receitas_despesas (email, descricao, tipo, data, valor)
            values ('$email', '$nova_descricao', '$tipo', '$data', $valor)";

if($conexao->query($sql))
{
    $response = array("success" => true);
	echo json_encode($response);
}
else
{
    $response = array("success" => false);
	echo json_encode($response);
}

?>
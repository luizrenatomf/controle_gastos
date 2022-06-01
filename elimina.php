<?php
    
require_once "include/conecta_banco.inc";

$email = $_COOKIE["email"];
$id = $_POST["id"] ? $_POST["id"] : ($_GET["id"] ? $_GET["id"] : "");

$sql = "delete from receitas_despesas where email = '$email' and id = '$id'";

if($conexao->query($sql))
{
    $response = array("success" => true, "html" => "Registro excluído com sucesso.");
}
else
{
    $response = array("success" => false);
}

echo json_encode($response);
    
?>

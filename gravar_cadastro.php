<?php

require_once "include/conecta_banco.inc";

$email       = $_POST["email"] ? $_POST["email"] : ($_GET["email"] ? $_GET["email"] : "");
$senha       = $_POST["senha"] ? $_POST["senha"] : ($_GET["senha"] ? $_GET["senha"] : "");
$nome        = $_POST["nome"] ? $_POST["nome"] : ($_GET["nome"] ? $_GET["nome"] : "");
$idade       = $_POST["idade"] ? $_POST["idade"] : ($_GET["idade"] ? $_GET["idade"] : "");
$genero      = $_POST["genero"] ? $_POST["genero"] : ($_GET["genero"] ? $_GET["genero"] : "");
$endereco    = $_POST["endereco"] ? $_POST["endereco"] : ($_GET["endereco"] ? $_GET["endereco"] : "");
$numero      = $_POST["numero"] ? $_POST["numero"] : ($_GET["numero"] ? $_GET["numero"] : "");
$complemento = $_POST["complemento"] ? $_POST["complemento"] : ($_GET["complemento"] ? $_GET["complemento"] : "");
$bairro      = $_POST["bairro"] ? $_POST["bairro"] : ($_GET["bairro"] ? $_GET["bairro"] : "");
$cidade      = $_POST["cidade"] ? $_POST["cidade"] : ($_GET["cidade"] ? $_GET["cidade"] : "");
$estado      = $_POST["estado"] ? $_POST["estado"] : ($_GET["estado"] ? $_GET["estado"] : "");
$cep         = $_POST["cep"] ? $_POST["cep"] : ($_GET["cep"] ? $_GET["cep"] : "");
$novidade    = $_POST["novidade"] ? "S" : ($_GET["novidade"] ? "S" : "N");

$sql = "insert into usuarios_autorizados (email, senha, nome, idade, genero, endereco, numero, complemento, bairro, cidade, estado, cep, novidade) 
        values ('$email','$senha','$nome','$idade','$genero','$endereco','$numero','$complemento','$bairro','$cidade','$estado','$cep','$novidade')";
        
if($conexao->query($sql)) {
    $response = array("success" => true);
	echo json_encode($response);
} else {
    $response = array("success" => false);
	echo json_encode($response);
}



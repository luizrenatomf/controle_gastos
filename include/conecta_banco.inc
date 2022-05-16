<?php

$hostname = "127.0.0.1";
$user = "root";
$password = "";
$database = "projeto_financeiro";

try {
    $conexao = new PDO('mysql:host='.$hostname.';dbname='.$database.'', $user, $password);
} catch (PDOException $e) {
    echo "Connection falied: " . $e->getMessage() . "</br>";
    die();
}

?>
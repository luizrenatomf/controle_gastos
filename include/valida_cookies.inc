<?php

if(isset($_COOKIE["email"]))
{
    $email = $_COOKIE["email"];
}
if(isset($_COOKIE["senha"]))
{
    $senha = $_COOKIE["senha"];
}

if(!(empty($email) or empty($senha))) 
{
    require_once "conecta_banco.inc";
    $sql = "select * from usuarios_autorizados where email='$email' and senha='$senha'";
    $res = $conexao->query($sql);    
    
    if(empty($res)) 
    {
        setcookie("email");
        setcookie("senha");
        echo "LOGIN inválido!";
        exit;
    }
}
else 
{
    echo "Você não efetuou o LOGIN!";
    exit;
}

?>
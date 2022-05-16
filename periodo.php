<?php

$nomePagina = "Planilha de gastos mensais";
require_once "include/valida_cookies.inc";
include "include/cabecalho.php";

$meses = array("Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez");

?>

<form action="planilha.php" method="post">
    <p align="center">Escolha o período de visualização:</p>
    <p align="center">Mês: <select size="1" name="mes">
        <?php
            foreach($meses as $key => $mes)
            {
                $key++;
                if($key == date("m",time()))
                {
                    echo "<option value=\"$key\" selected>$mes</option>";
                }
                else
                {
                    echo "<option value=\"$key\">$mes</option>";
                }
            }
        ?>
    </select>
    Ano: <input type="text" name="ano" size="4" maxlength="4" value="<?= date("Y",time()); ?>">
    </p> 
    <p align="center">até</p>
    <p align="center">Mês: <select size="1" name="mes2">
        <?php
            foreach($meses as $key => $mes)
            {
                $key++;
                if($key == date("m",time()))
                {
                    echo "<option value=\"$key\" selected>$mes</option>";
                }
                else
                {
                    echo "<option value=\"$key\">$mes</option>";
                }
            }
        ?>
    </select>
    Ano: <input type="text" name="ano2" size="4" maxlength="4" value="<?= date("Y",time()); ?>">
    </p>
    <p align="center">&nbsp;<input type="submit" value="Visualizar" name="ok"></p>
</form>
<hr>
<p align="center"><a href="principal.php">Voltar</a></p>

<?php

include "include/rodape.php";

?>
<?php

$tipo = $_GET["tipo"];
if($tipo == "V")
{
    $nomePagina = "Visualização de registros";
    $form       = "gera_registro.php";
}
else if($tipo == "E")
{
    $nomePagina = "Exclusão de registros";
    $form       = "excluir.php";
}
else if($tipo == "P")
{
    $nomePagina = "Planilha de gastos mensais";
    $form       = "planilha.php";
}

require_once "include/cabecalho.php";
require_once "include/valida_cookies.inc";
require_once "include/conecta_banco.inc";

$meses = array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");

?>

<form action="<?= $form; ?>" method="POST" name="formulario" id="formulario">
    <p align="center">Selecione o período:</p>
    <div class="container">
       <div class="row justify-content-center gx-1 mb-5">
            <div class="col-sm-2 col-xl-2">
                <select class="form-select" name="mes" id="mes">
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
            </div>
            <div class="col-sm-2 col-xl-1">
                <input class="form-control" type="text" name="ano" id="ano" maxlength="4" value="<?= date("Y",time()); ?>">
            </div>  
            <div class="col-sm-2 col-xl-2">
                <select class="form-select" name="mes2" id="mes2">
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
            </div>
            <div class="col-sm-2 col-xl-1">
                <input class="form-control" type="text" name="ano2" id="ano2" maxlength="4" value="<?= date("Y",time()); ?>">
            </div>             
            <button type="submit" class="btn btn-primary col-sm-2 col-xl-2" id="visualizar">Visualizar</a>
        </div>
    </div>
</form>

<div class="container" id="conteudo"></div>

<script type="text/javascript" language="javascript">
    const frm = $("#formulario");
    frm.submit(function(e){
        e.preventDefault();
        $.ajax ({
            dataType: "json",
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function(retorno) {
                if(retorno.success) {
                    $("#conteudo").html("");
                    $("#conteudo").append(retorno.html);
                } else {
                    $("#conteudo").html("");
                    $("#mensagem").append("<div class=\"alert alert-danger\" role=\"alert\"><h6 align=\"center\">"+retorno.html+"</h6></div>");
                    window.setTimeout(function(){$("#mensagem").empty()},5000)
                }
            },
        });
    });
</script>

<?php 

require_once "include/rodape.php";

?>
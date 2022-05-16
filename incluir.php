<?php

$email = $_COOKIE["email"];
$tipo = $_GET["tipo"];
if($tipo == "RF")
{
    $titulo = "RECEITAS FIXAS";
}
else if($tipo == "RV")
{
    $titulo = "RECEITAS VARIÁVEIS";
}
else if($tipo == "DF")
{
    $titulo = "DESPESAS FIXAS";
}
else if($tipo == "DV")
{
    $titulo = "DESPESAS VARIÁVEIS";
}

$nomePagina = "Inclusão de $titulo";
require_once "include/cabecalho.php";
require_once "include/valida_cookies.inc";
require_once "include/conecta_banco.inc";

?>

<form action="" method="post" name="formulario" id="formulario" onSubmit="return valida_dados(this)">
    <input type="hidden" name="tipo" value="<?= $tipo; ?>" checked>
    <div class="container">
        <div class="form-row justify-content-center">
            <div class="col-md-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="descricao" id="descricao_nova" value="nova" checked>
                    <label class="form-check-label" for="descricao_nova">Nova: </label>
                </div>
                <input class="form-control" type="text" name="descricao_nova" onKeyDown="javascript:formulario.descricao[0].checked=true" autocomplete="off">
            </div>
            <div class="col-md-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="descricao" id="descricao_e" value="existente">
                    <label class="form-check-label" for="descricao_e">Existente: </label>
                </div>
                <div class="form-group">
                    <select class="form-control" name="descricao_existente" onChange="javascript:formulario.descricao[1].checked=true">
                    <?php     
                        $sql = "select distinct(descricao) 
                                    from receitas_despesas 
                                    where email = '$email'
                                    and tipo = '$tipo'
                                    order by descricao";
                        $res = $conexao->query($sql);
                        $rows = $res->fetchAll();
                        foreach($rows as $row)
                        {
                            $descricao = $row["descricao"];
                            echo "<option value=\"$descricao\">$descricao</option>";
                        }
                    ?>
                    </select>
                </div>        
            </div>
        </div>
        <div class="form-row justify-content-center">
            <div class="form-group col-md-2">
                <label class="form-check-label" for="mes">Mês: </label>
                <select class="form-control" name="mes" id="mes">
                <?php
                    $meses = array("Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez");
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
            <div class="form-group col-md-2">
                <label class="form-check-label" for="ano">Ano: </label>
                <input class="form-control" type="text" name="ano" id="ano" value="<?= date("Y",time()); ?>">
            </div>
            <div class="form-group col-md-2">
                <label class="form-check-label" for="ano">Valor: </label>
                <input class="form-control" type="text" name="valor" id="valor" maxlength="10" autocomplete="off">
            </div>
        </div>
        <div class="form-row justify-content-center">
            <div class="form-group col-md-1">
                <input class="btn btn-primary" type="button" value="&nbsp;Enviar&nbsp;" name="enviar" onclick="gravar()">
            </div>
            <div class="form-group col-md-1">
                <input class="btn btn-secondary" type="reset" value="&nbsp;Limpar&nbsp;" name="limpar" id="limpar">
            </div>
        </div>
    </div>
</form>
<hr>
<p align="center"><a href="principal.php">Voltar</a></p>

<script type="text/javascript" language="javascript">
    function gravar() {  
        var dados = $("#formulario").serialize();
        $.ajax ({
            type: "POST",
            dataType: "json",
            url: "gravar.php",
            async: true,
            data: dados,
            success: function(retorno) {
                if(retorno.success) {
                    $("#limpar").click();
                    $("#mensagem").append("<div class=\"alert alert-success\" role=\"alert\"><h6 align=\"center\">Inclusão realizada com sucesso.</h6></div>");
                    window.setTimeout(function(){$("#mensagem").empty()},3000)
                }
                else {
                    $("#mensagem").append("<div class=\"alert alert-danger\" role=\"alert\"><h6 align=\"center\">Erro ao incluir.</h6></div>");
                    window.setTimeout(function(){$("#mensagem").empty()},3000)
                }
            },
        });
    }
</script>

<script src="./static/script.js"></script>

<?php

require_once "include/rodape.php";

?>
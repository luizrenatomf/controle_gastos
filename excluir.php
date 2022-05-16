<?php

$nomePagina = "Exclusão de registros";
require_once "include/valida_cookies.inc";
require_once "include/conecta_banco.inc";
include "include/cabecalho.php";

$email = $_COOKIE["email"];
$meses = array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
$tipos = array("RF" => "Receita fixa", "RV" => "Receita variável", "DF" => "Despesa fixa", "DV" => "Despesa variável");

$sql = "select id, descricao, data, valor, tipo
            from receitas_despesas
            where email = '$email'
            order by data desc, id desc";

$res = $conexao->query($sql);
$rows = $res->fetchAll();

?>

<form action="" method="POST" name="formulario" id="formulario"> 
    <div class="container">
        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th scope="col" class="text-center">ID</th>
                    <th scope="col" class="text-center">Descrição</th>
                    <th scope="col" class="text-center">Valor</th>
                    <th scope="col" class="text-center">Referência</th>
                    <th scope="col" class="text-center">Tipo</th>
                    <th scope="col" class="text-center">Excluir?</th>
                </tr>
            </thead>
            <tbody>

<?php

for($i = 0; $i < sizeof($rows); $i++)
{
    $id = $rows[$i]["id"];
    $descricao = $rows[$i]["descricao"];
    $data = $rows[$i]["data"];
    $valor = $rows[$i]["valor"];
    $tipo = $tipos[$rows[$i]["tipo"]];
    $aux = explode("-",$data);
    $ano = $aux[0];
    $mes = $aux[1];
    $dia = $aux[2];
    $nome_mes = $meses[$mes-1];

    echo "<tr><th scope=\"row\" class=\"text-center\">$id</th><td class=\"text-center\">$descricao</td><td class=\"text-center\">".number_format($valor, 2, ',', '.')."</td><td class=\"text-center\">$nome_mes</td><td class=\"text-center\">$tipo</td><td class=\"text-center\"><a href=\"\" onclick=\"excluir($id)\">Excluir</a></td</tr>";
}

?>
            </tbody>
        </table>
    </div>
</form>
<hr>
<br>
<a href="principal.php">Voltar</a>

<script type="text/javascript" language="javascript">
    function excluir(id) {  
        var dados = $("#formulario").serialize();
        $.ajax ({
            type: "POST",
            dataType: "json",
            url: "elimina.php?id="+id,
            async: true,
            data: dados,
            success: function(retorno) {
                if(retorno.success) {
                    window.location.reload();
                }
                else {
                    $("#mensagem").append("<div class=\"alert alert-danger\" role=\"alert\"><h6 align=\"center\">Erro ao excluir registro.</h6></div>");
                    window.setTimeout(function(){$("#mensagem").empty()},3000)
                }
            },
        });
    }
</script>

<?php

include "include/rodape.php";

?>
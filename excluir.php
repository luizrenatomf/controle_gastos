<?php

require_once "include/conecta_banco.inc";

$email = $_COOKIE['email'];
$mes = $_POST['mes'] ? $_POST['mes'] : ($_GET['mes'] ? $_GET['mes'] : '');
$ano = $_POST['ano'] ? $_POST['ano'] : ($_GET['ano'] ? $_GET['ano'] : '');
$mes2 = $_POST['mes2'] ? $_POST['mes2'] : ($_GET['mes2'] ? $_GET['mes2'] : '');
$ano2 = $_POST['ano2'] ? $_POST['ano2'] : ($_GET['ano2'] ? $_GET['ano2'] : '');

$data = "$ano-$mes-01";
$data2 = "$ano2-$mes2-01";

$tipos = array("DF" => "Despesa fixa","DV" => "Despesa variável","RF" => "Receita fixa","RV" => "Receita variável");

$sql = "select id, descricao, data, valor, tipo
          from receitas_despesas
         where email = '$email'
           and data between '$data' and '$data2'
         order by data desc, id desc";

$res = $conexao->query($sql);
$rows = $res->fetchAll();

if(empty($rows))
{
    $response = array("success" => false, "html" => "Registros não encontrados para o período especificado.");
}
else
{
    $html = "
    <form action=\"elimina.php\" method=\"POST\" name=\"formularioExclusao\" id=\"formularioExclusao\"> 
        <div class=\"container\">
            <table class=\"table table-sm table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\" class=\"text-center\">ID</th>
                        <th scope=\"col\" class=\"text-center\">Descrição</th>
                        <th scope=\"col\" class=\"text-center\">Valor</th>
                        <th scope=\"col\" class=\"text-center\">Referência</th>
                        <th scope=\"col\" class=\"text-center\">Tipo</th>
                        <th scope=\"col\" class=\"text-center\">Excluir?</th>
                    </tr>
                </thead>
                <tbody>
    ";

    foreach($rows as $row)
    {
        $id = $row["id"];
        $descricao = $row["descricao"];
        $data = explode('-',$row['data'])[1]."/".explode('-',$row['data'])[0];
        $valor = number_format($row["valor"], 2, ',', '.');
        $tipo = $tipos[$row["tipo"]];

        $html .= "<tr><th scope=\"row\" class=\"text-center\">$id</th><td class=\"text-center\">$descricao</td><td class=\"text-center\">R$".$valor."</td><td class=\"text-center\">$data</td><td class=\"text-center\">$tipo</td><td class=\"text-center\"><a href=\"\" onclick=\"return excluir($id);\">Excluir</a></td></tr>";
    }

    $html .= "
                    </tbody>
                </table>
            </div>
        </form>
    ";

    $response = array("success" => true, "html" => $html);
}

echo json_encode($response);

?>
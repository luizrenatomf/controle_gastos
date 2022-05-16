<?php

require_once "include/valida_cookies.inc";
require_once "include/config_grafico.inc";
require_once "include/conecta_banco.inc";

header("Content-type: image/png");

$email      = $_COOKIE["email"];
$data         = $_GET["data"];

$meses        = array("Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez");

$aux          = explode("-",$data);
$mes          = $aux[0];
$ano          = $aux[1];

$mes          = array_search($mes, $meses)+1;
$data_buscar  = "$ano-$mes-01";

$image        = ImageCreate($largura,$altura);
$fundo        = ImageColorAllocate($image,236,226,226);
$preto        = ImageColorAllocate($image,0,0,0);
$azul         = ImageColorAllocate($image,0,0,255);
$verde        = ImageColorAllocate($image,0,255,0);
$vermelho     = ImageColorAllocate($image,255,0,0);
$amarelo      = ImageColorAllocate($image,255,255,0);
$laranja      = ImageColorAllocate($image,255,153,0);
$magenta      = ImageColorAllocate($image,255,128,255);
$ciano        = ImageColorAllocate($image,128,255,255);
$verde_escuro = ImageColorAllocate($image,0,128,0);
$cinza        = ImageColorAllocate($image,192,192,192);
$cores        = array($azul,$verde,$vermelho,$amarelo,$laranja,$magenta,$ciano,$verde_escuro,$cinza);

$sql = "select descricao, valor 
         from receitas_despesas 
        where email = '$email'
          and data = '$data_buscar'
          and (tipo = 'DF' or tipo = 'DV')";
$res = $conexao->query($sql);
$rows = $res->fetchAll();

for($i = 0; $i < $rows; $i++)
{
    $dados[]   = $rows[$i][0];
    $valores[] = $rows[$i][1];
}

$total = 0;
$num_linhas = sizeof($dados);

for($i = 0; $i < $num_linhas; $i++)
{
    $total += $valores[$i];
}

ImageEllipse($image,$centrox,$centroy,$diametro,$diametro,$preto);
ImageString($image,3,3,3,"Total Despesas: $\$$total",$preto);
$raio = $diametro / 2;

for($i = 0; $i < $num_linhas; $i++)
{
    $percentual = ($valores[$i] / $total) * 100;
    $percentual = number_format($percentual, 2);
    $percentual .= "%";
    $val = 360 * ($valores[$i] / $total);
    $angulo += $val;
    $angulo_meio = $angulo - ($val / 2); $x_final = $centrox + $raio * cos(deg2rad($angulo));
    $y_final = $centroy + (- $raio * sin(deg2rad($angulo)));
    $x_meio = $centrox + ($raio/2 * cos(deg2rad($angulo_meio)));
    $y_meio = $centroy + (- $raio/2 * sin(deg2rad($angulo_meio)));
    $x_texto = $centrox + ($raio * cos(deg2rad($angulo_meio))) * 1.2;
    $y_texto = $centroy + (- $raio * sin(deg2rad($angulo_meio))) * 1.2;
    ImageLine($imagem, $centrox, $centroy, $x_final, $y_final, $preto);
    ImageFillToBorder($imagem, $x_meio, $y_meio, $preto, $cores[$i%sizeof($cores)]);
    ImageString($imagem, 2, $x_texto, $y_texto, $percentual, $preto); 
}

?>
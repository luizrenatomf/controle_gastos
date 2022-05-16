<?php

$nomePagina = "Planilha de gastos por período";
require_once "include/valida_cookies.inc";
require_once "include/conecta_banco.inc";
include "include/cabecalho.php";

$meses = array("Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez");

$email = $_COOKIE["email"];

$mes = $_POST["mes"];
$ano = $_POST["ano"];
$mes2 = $_POST["mes2"];
$ano2 = $_POST["ano2"];

$data = "$ano-$mes-01";
$data2 = "$ano2-$mes2-01";
$array_datas = $RF = $RV = $DF = $DV = array();

$sql = "select descricao, tipo, data, valor
          from receitas_despesas
         where email = '$email'
           and data between '$data' and '$data2'
         order by data, descricao";
$res = $conexao->query($sql);
$rows = $res->fetchAll();

if($rows == 0)
{
    echo "Não há receitas e despesas no período escolhido.";
    exit;
}
else
{
    foreach($rows as $row)
    {
        $descricao = $row["descricao"];
        $tipo      = $row["tipo"];
        $data      = $row["data"];
        $valor     = $row["valor"];

        $aux = explode("-",$data);
        $ano = $aux[0];
        $mes = $aux[1];
        $dia = $aux[2];
        $numero_mes = $mes - 1;
        $data = $meses[$numero_mes] . "-" . $ano;
        if(!in_array($data,$array_datas))
        {
            $array_datas[] = $data;
        }
        if($tipo == "RF")
        {
            if(!in_array($descricao, $RF))
            {
                $RF[] = $descricao;
            }
            if(isset($receitas_fixas[$descricao][$data]))
            {
                $receitas_fixas[$descricao][$data] += $valor;
            }
            else
            {
                $receitas_fixas[$descricao][$data] = $valor;
            }
            if(isset($total_receitas[$data]))
            {
                $total_receitas[$data] += $valor;
            }
            else
            {
                $total_receitas[$data] = $valor;
            }
        }
        elseif($tipo == "RV")
        {
            if(!in_array($descricao,$RV))
            {
                $RV[] = $descricao;
            }
            if(isset($receitas_variaveis[$descricao][$data]))
            {
                $receitas_variaveis[$descricao][$data] += $valor;
            }
            else
            {
                $receitas_variaveis[$descricao][$data] = $valor;
            }
            if(isset($total_receitas[$data]))
            {
                $total_receitas[$data] += $valor;
            }
            else
            {
                $total_receitas[$data] = $valor;
            }
        }
        elseif($tipo == "DF")
        {
            if(!in_array($descricao, $DF))
            {
                $DF[] = $descricao;
            }
            if(isset($despesas_fixas[$descricao][$data]))
            {
                $despesas_fixas[$descricao][$data] += $valor;
            }
            else
            {
                $despesas_fixas[$descricao][$data] = $valor;
            }
            if(isset($total_despesas[$data]))
            {
                $total_despesas[$data] += $valor;
            }
            else
            {
                $total_despesas[$data] = $valor;
            }
        }
        elseif($tipo == "DV")
        {
            if(!in_array($descricao,$DV))
            {
                $DV[] = $descricao;
            }
            if(isset($despesas_variaveis[$descricao][$data]))
            {
                $despesas_variaveis[$descricao][$data] += $valor;
            }
            else
            {
                $despesas_variaveis[$descricao][$data] = $valor;
            }
            if(isset($total_despesas[$data]))
            {
                $total_despesas[$data] += $valor;
            }
            else
            {
                $total_despesas[$data] = $valor;
            }
        }
    }    
}
$numero_colunas = sizeof($array_datas);
$colunas_html = $numero_colunas + 1;

?>
<div align="center">
    <center>
        <table border="1" cellspacing="0">
            <tr>
                <td width="142"></td>
                <?php
                    foreach($array_datas as $data)
                    {
                        echo "<td align=\"center\" width=\"100\"><b><font color=\"000080\">$data</font></b></td>";
                    }
                ?>
            </tr>
            <tr>
                <td colspan="<?= $colunas_html; ?>" bgcolor="#F5F5F5">
                    <b>RECEITAS FIXAS</b>
                </td>
            </tr>
            <?php
                for($i = 0; $i < sizeof($RF); $i++)
                {
                    $descricao = $RF[$i];
                    echo "<tr><td width=\"142\">$descricao</td>";
                    for($j = 0; $j < $numero_colunas; $j++)
                    {
                        $data = $array_datas[$j];
                        if(isset($receitas_fixas[$descricao][$data]))
                        {
                            $valor = $receitas_fixas[$descricao][$data];
                            echo "<td align=\"center\" width=\"100\"> " . number_format($valor, 2, ',', '.') . "</td>";
                        }
                        else
                        {
                            echo "<td align=\"center\" width=\"100\">&nbsp;&nbsp;</td>";
                        }
                    }
                    echo "</tr>";
                }
            ?>
            <tr>
                <td colspan="<?= $colunas_html; ?>" bgcolor="#F5F5F5">
                    <b>RECEITAS VARIÁVEIS</b>
                </td>
            </tr>
            <?php
                for($i = 0; $i < sizeof($RV); $i++)
                {
                    $descricao = $RV[$i];
                    echo "<tr><td width=\"142\">$descricao</td>";
                    for($j = 0; $j < $numero_colunas; $j++)
                    {
                        $data = $array_datas[$j];
                        if(isset($receitas_variaveis[$descricao][$data]))
                        {
                            $valor = $receitas_variaveis[$descricao][$data];
                            echo "<td align=\"center\" width=\"100\"> " . number_format($valor, 2, ',', '.') . "</td>";
                        }
                        else
                        {
                            echo "<td align=\"center\" width=\"100\">&nbsp;&nbsp;</td>";
                        }
                    }
                    echo "</tr>";
                }
            ?>
            <tr>
                <td width="142" bgcolor="#D7FFFF"><b>Total Receitas:</b></td>
                <?php
                    foreach($array_datas as $data)
                    {
                        if(isset($total_receitas[$data]))
                        {
                            $total = $total_receitas[$data];
                        }
                        else
                        {
                            $total = 0;
                        }
                        echo "<td align=\"center\" bgcolor=\"#D7FFFF\" width=\"100\"><b> " . number_format($total, 2, ',', '.') . "</b></td>";
                    }
                ?>
            </tr>
            <tr>
                <td colspan="<?= $colunas_html; ?>" bgcolor="#F5F5F5"><b>DESPESAS FIXAS</b></td>
            </tr>
            <?php
                for($i = 0; $i < sizeof($DF); $i++)
                {
                    $descricao = $DF[$i];
                    echo "<tr><td width=\"142\">$descricao</td>";
                    for($j = 0; $j < $numero_colunas; $j++)
                    {
                        $data = $array_datas[$j];
                        if(isset($despesas_fixas[$descricao][$data]))
                        {
                            $valor = $despesas_fixas[$descricao][$data];
                            echo "<td align=\"center\" width=\"100\"> " . number_format($valor, 2, ',', '.') . "</td>";
                        }
                        else
                        {
                            echo "<td align=\"center\" width=\"100\">&nbsp;&nbsp;</td>";
                        }
                    }
                    echo "</tr>";
                }
            ?>
            <tr>
                <td colspan="<?= $colunas_html; ?>" bgcolor="#F5F5F5"><b>DESPESAS VARIÁVEIS</b></td>
            </tr>
            <?php
                for($i = 0; $i < sizeof($DV); $i++)
                {
                    $descricao = $DV[$i];                        
                    echo "<tr><td width=\"142\">$descricao</td>";
                    for($j = 0; $j < $numero_colunas; $j++)
                    {
                        $data = $array_datas[$j];
                        if(isset($despesas_variaveis[$descricao][$data]))
                        {
                            $valor = $despesas_variaveis[$descricao][$data];
                            echo "<td align=\"center\" width=\"100\"> " . number_format($valor, 2, ',', '.') . "</td>";
                        }
                        else
                        {
                            echo "<td align=\"center\" width=\"100\">&nbsp;&nbsp;</td>";
                        }
                    }
                    echo "</tr>";
                }
            ?>
            <tr>
                <td width="142" bgcolor="#D7FFFF"><b>Total Despesas:</b></td>
                <?php
                    foreach($array_datas as $data)
                    {
                        if(isset($total_despesas[$data]))
                        {
                            $total = $total_despesas[$data];
                        }
                        else
                        {
                            $total = 0;
                        }
                        echo "<td align=\"center\" bgcolor=\"#D7FFFF\" width=\"100\"><b> " . number_format($total, 2, ',', '.') . "</b></td>";
                    }
                ?>
            </tr>
<!--                
            <tr>
                <td width="142"><b>GRÁFICO DESPESAS</b></td>
                <?php
                    foreach($array_datas as $data)
                    {
                        if(isset($total_despesas[$data]))
                        {
                            echo "<td align=\"center\" width=\"100\"><a href=\"gera_grafico.php?data=$data\"><img src=\"grafico.gif\" border=\"0\"></a></td>";
                        }
                        else
                        {
                            echo "<td align=\"center\" width=\"100\">-</td>";
                        }
                    }
                ?>
            </tr>
            <tr>
                <td widt="142"><b>PDF DESPESAS</b></td>
                <?php
                    foreach($array_datas as $data)
                    {
                        if(isset($total_despesas[$data]))
                        {
                            echo "<td align=\"center\" width=\"100\"><a href=\"gera_pdf.php?data=$data\" target=\"blank\"><img src=\"pdf.gif\" border=\"0\"></a></td>";
                        }
                        else
                        {
                            echo "<td align=\"center\" width=\"100\">-</td>";
                        }
                    }
                ?>
            </tr>
-->                
            <tr>
                <td width="142" bgcolor="#CCFFCC"><b>SALDO</b></td>
                <?php
                    foreach($array_datas as $data)
                    {
                        $saldo = 0;
                        if(isset($total_receitas[$data]))
                        {
                            $saldo += $total_receitas[$data];
                        }
                        if(isset($total_despesas[$data]))
                        {
                            $saldo -= $total_despesas[$data];
                        }
                        if($saldo < 0)
                        {
                            $cor = "#FF0000";
                        }
                        else
                        {
                            $cor = "#0000FF";
                        }
                        echo "<td align=\"center\" bgcolor=\"#CFFCC\" width=\"100\"><font colo=\"$cor\"><b> " . number_format($saldo, 2, ',', '.') . "</b></font></td>";
                    }
                ?>
            </tr>
        </table>
    </center>
</div>
<p align="center"><a href="principal.php">Voltar</a></p>

<?php

include "./include/rodape.php";

?>


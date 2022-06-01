<?php

require_once "include/conecta_banco.inc";

$email = $_COOKIE['email'];
$mes = $_POST['mes'] ? $_POST['mes'] : ($_GET['mes'] ? $_GET['mes'] : '');
$ano = $_POST['ano'] ? $_POST['ano'] : ($_GET['ano'] ? $_GET['ano'] : '');
$mes2 = $_POST['mes2'] ? $_POST['mes2'] : ($_GET['mes2'] ? $_GET['mes2'] : '');
$ano2 = $_POST['ano2'] ? $_POST['ano2'] : ($_GET['ano2'] ? $_GET['ano2'] : '');

$data = "$ano-$mes-01";
$data2 = "$ano2-$mes2-01";
$array_datas = $RF = $RV = $DF = $DV = array();

$meses = array("Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez");

$sql = "select descricao, tipo, data, valor
          from receitas_despesas
         where email = '$email'
           and data between '$data' and '$data2'
         order by data, descricao";

         $res = $conexao->query($sql);
$rows = $res->fetchAll();

if(empty($rows))
{
    $response = array("success" => false, "html" => "Registros não encontrados para o período especificado.");    
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

    $numero_colunas = sizeof($array_datas);
    $colunas_html = $numero_colunas + 1;

    $html = "
    <div align=\"center\">
        <center>
            <table border=\"1\" cellspacing=\"0\">
                <tr>
                    <td width=\"142\"></td>
    ";                

    foreach($array_datas as $data)
    {
        $html .= "<td align=\"center\" width=\"100\"><b><font color=\"000080\">$data</font></b></td>";
    }

    $html .= " 
            </tr>
            <tr>
                <td colspan=\"<?= $colunas_html; ?>\" bgcolor=\"#F5F5F5\">
                    <b>RECEITAS FIXAS</b>
                </td>
            </tr>
    ";        

    for($i = 0; $i < sizeof($RF); $i++)
    {
        $descricao = $RF[$i];
        $html .= "<tr><td width=\"142\">$descricao</td>";
        for($j = 0; $j < $numero_colunas; $j++)
        {
            $data = $array_datas[$j];
            if(isset($receitas_fixas[$descricao][$data]))
            {
                $valor = $receitas_fixas[$descricao][$data];
                $html .= "<td align=\"center\" width=\"100\"> " . number_format($valor, 2, ',', '.') . "</td>";
            }
            else
            {
                $html .= "<td align=\"center\" width=\"100\">&nbsp;&nbsp;</td>";
            }
        }
        $html .= "</tr>";
    }

    $html .= "
            <tr>
                <td colspan=\"<?= $colunas_html; ?>\" bgcolor=\"#F5F5F5\">
                    <b>RECEITAS VARIÁVEIS</b>
                </td>
            </tr>
    ";

    for($i = 0; $i < sizeof($RV); $i++)
    {
        $descricao = $RV[$i];
        $html .= "<tr><td width=\"142\">$descricao</td>";
        for($j = 0; $j < $numero_colunas; $j++)
        {
            $data = $array_datas[$j];
            if(isset($receitas_variaveis[$descricao][$data]))
            {
                $valor = $receitas_variaveis[$descricao][$data];
                $html .= "<td align=\"center\" width=\"100\"> " . number_format($valor, 2, ',', '.') . "</td>";
            }
            else
            {
                $html .= "<td align=\"center\" width=\"100\">&nbsp;&nbsp;</td>";
            }
        }
        $html .= "</tr>";
    }

    $html .= "
            <tr>
                <td width=\"142\" bgcolor=\"#D7FFFF\"><b>Total Receitas:</b></td>
    ";

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
        $html .= "<td align=\"center\" bgcolor=\"#D7FFFF\" width=\"100\"><b> " . number_format($total, 2, ',', '.') . "</b></td>";
    }

    $html .= "
            </tr>
            <tr>
                <td colspan=\"<?= $colunas_html; ?>\" bgcolor=\"#F5F5F5\"><b>DESPESAS FIXAS</b></td>
            </tr>
    ";        

    for($i = 0; $i < sizeof($DF); $i++)
    {
        $descricao = $DF[$i];
        $html .= "<tr><td width=\"142\">$descricao</td>";
        for($j = 0; $j < $numero_colunas; $j++)
        {
            $data = $array_datas[$j];
            if(isset($despesas_fixas[$descricao][$data]))
            {
                $valor = $despesas_fixas[$descricao][$data];
                $html .= "<td align=\"center\" width=\"100\"> " . number_format($valor, 2, ',', '.') . "</td>";
            }
            else
            {
                $html .= "<td align=\"center\" width=\"100\">&nbsp;&nbsp;</td>";
            }
        }
        $html .= "</tr>";
    }

    $html .= "
            <tr>
                <td colspan=\"<?= $colunas_html; ?>\" bgcolor=\"#F5F5F5\"><b>DESPESAS VARIÁVEIS</b></td>
            </tr>
    ";

    for($i = 0; $i < sizeof($DV); $i++)
    {
        $descricao = $DV[$i];                        
        $html .= "<tr><td width=\"142\">$descricao</td>";
        for($j = 0; $j < $numero_colunas; $j++)
        {
            $data = $array_datas[$j];
            if(isset($despesas_variaveis[$descricao][$data]))
            {
                $valor = $despesas_variaveis[$descricao][$data];
                $html .= "<td align=\"center\" width=\"100\"> " . number_format($valor, 2, ',', '.') . "</td>";
            }
            else
            {
                $html .= "<td align=\"center\" width=\"100\">&nbsp;&nbsp;</td>";
            }
        }
        $html .= "</tr>";
    }

    $html .= "
            <tr>
                <td width=\"142\" bgcolor=\"#D7FFFF\"><b>Total Despesas:</b></td>
    ";

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
        $html .= "<td align=\"center\" bgcolor=\"#D7FFFF\" width=\"100\"><b> " . number_format($total, 2, ',', '.') . "</b></td>";
    }

    $html .= "
            </tr>
    ";        
/*                
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
*/
    
    $html .= "               
            <tr>
                <td width=\"142\" bgcolor=\"#CCFFCC\"><b>SALDO</b></td>
    ";

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
        $html .= "<td align=\"center\" bgcolor=\"#CFFCC\" width=\"100\"><font colo=\"$cor\"><b> " . number_format($saldo, 2, ',', '.') . "</b></font></td>";
    }

    $html .= "
                    </tr>
                </table>
            </center>
        </div>
    ";

    $response = array("success" => true, "html" => $html);
}

echo json_encode($response);

?>
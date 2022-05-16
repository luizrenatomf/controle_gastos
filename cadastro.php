<?php

$nomePagina = "Cadastro de usuário";
require_once "include/cabecalho.php";
require_once "include/conecta_banco.inc";

$estadosBrasileiros = array(
    'AC'=>'Acre',
    'AL'=>'Alagoas',
    'AP'=>'Amapá',
    'AM'=>'Amazonas',
    'BA'=>'Bahia',
    'CE'=>'Ceará',
    'DF'=>'Distrito Federal',
    'ES'=>'Espírito Santo',
    'GO'=>'Goiás',
    'MA'=>'Maranhão',
    'MT'=>'Mato Grosso',
    'MS'=>'Mato Grosso do Sul',
    'MG'=>'Minas Gerais',
    'PA'=>'Pará',
    'PB'=>'Paraíba',
    'PR'=>'Paraná',
    'PE'=>'Pernambuco',
    'PI'=>'Piauí',
    'RJ'=>'Rio de Janeiro',
    'RN'=>'Rio Grande do Norte',
    'RS'=>'Rio Grande do Sul',
    'RO'=>'Rondônia',
    'RR'=>'Roraima',
    'SC'=>'Santa Catarina',
    'SP'=>'São Paulo',
    'SE'=>'Sergipe',
    'TO'=>'Tocantins'
    );

?>

<form action="" method="POST" name="formulario" id="formulario">
  <div class="container">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email">
        </div>
        <div class="form-group col-md-6">
            <label for="senha">Senha</label>
            <input type="password" class="form-control" name="senha" id="senha">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" name="nome" id="nome">
        </div>
        <div class="form-group col-md-3">
            <label for="idade">Idade</label>
            <input type="text" class="form-control" name="idade" id="idade">
        </div>
        <div class="form-group col-md-3">
            <label for="genero">Gênero</label>
            <select type="text" class="form-control" name="genero" id="genero">
                <option selected>Escolha...</option>                
                <option value="F">Femenino</option>
                <option value="M">Masculino</option>
                <option value="N">Não desejo informar</option>                
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="endereco">Endereço</label>
            <input type="text" class="form-control" name="endereco" id="endereco" placeholder="Rua Principal">
        </div>
        <div class="form-group col-md-2">
            <label for="numero">Número</label>
            <input type="text" class="form-control" name="numero" id="numero" placeholder="1234">
        </div>
        <div class="form-group col-md-4">
            <label for="complemento">Complemento</label>
            <input type="text" class="form-control" name="complemento" id="complemento" placeholder="Apartamento, bloco, andar...">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="bairro">Bairro</label>
            <input type="text" class="form-control" name="bairro" id="bairro">
        </div>
        <div class="form-group col-md-4">
            <label for="cidade">Cidade</label>
            <input type="text" class="form-control" name="cidade" id="cidade">
        </div>
        <div class="form-group col-md-3">
            <label for="estado">Estado</label>
            <select type="text" class="form-control" name="estado" id="estado">
                <option selected>Escolha...</option>
                <?php foreach($estadosBrasileiros as $key => $estado) { ?>
                <option value="<?=$key;?>"><?=$estado;?></option>
                <?php } ?>
            </select>
        </div>            
        <div class="form-group col-md-2 center">
            <label for="cep">CEP</label>
            <input type="text" class="form-control" name="cep" id="cep" maxlength="9">
        </div>
    </div>
    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="novidade" id="novidade">
            <label class="form-check-label" for="novidade">Desejo receber novidades</label>
        </div>
    </div>
    <button class="btn btn-primary" id="cadastrar" onclick="gravar_cadastro()">Cadastrar</button>
    <a class="btn btn-secondary" href="index.php" >Voltar</a>
  </div>
</form>

<script type="text/javascript" language="javascript">
    function gravar_cadastro() {  
        var dados = $("#formulario").serialize();
        $.ajax ({
            type: "POST",
            dataType: "json",
            url: "gravar_cadastro.php",
            async: true,
            data: dados,
            success: function(retorno) {
                if(retorno.success) {
                    location.assign("index.php");
                }
                else {
                    $("#mensagem").append("<div class=\"alert alert-danger\" role=\"alert\"><h6 align=\"center\">Erro ao finalizar cadastro.</h6></div>");
                    window.setTimeout(function(){$("#mensagem").empty()},5000)
                }
            },
        });
    }
</script>

<?php

require_once "include/rodape.php";

?>
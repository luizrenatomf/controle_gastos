<?php

$nomePagina = "Entre em contato";
include "include/cabecalho.php";

?>

<form method="post" id="formulario" autocomplete="off">
    <div class="container">
        <div class="form-row justify-content-center">
            <div class="form-group col-md-5">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" id="nome" required> 
            </div>
        </div>
        <div class="form-row justify-content-center">
            <div class="form-group col-md-5">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
        </div>
        <div class="form-row justify-content-center">
            <div class="form-group col-md-5">
                <label for="assunto">Assunto</label>
                <input type="text" class="form-control" name="assunto" id="assunto" required>
            </div>
        </div>
        <div class="form-row justify-content-center">
            <div class="form-group col-md-8">
                <label for="mensagem">Mensagem</label>
                <textarea type="textarea" class="form-control" name="mensagem" id="mensagem" rows="10" placeholder="Escreva sua mensagem aqui..." required></textarea>
            </div>
        </div>
        <div class="form-row justify-content-center">
            <input type="submit" class="btn btn-primary" value="&nbsp;Enviar&nbsp;">
        </div>
    </div>
</form>

<?php

include "include/rodape.php";

?>
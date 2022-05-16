function valida_dados(formulario) 
{
    if(formulario.descricao_nova.value == "" && 
        formulario.descricao[0].checked == true)
    {
        alert("Você não digitou a descrição.");
        return false;
    }
    if(formulario.ano.value.length < 4)
    {
        alert("Digite o ano com quatro dígitos.");
        return false;
    }
    if(formulario.valor.value == "")
    {
        alert("Você não digitou o valor.");
        return false;
    }
    return true;
}
// Função para carregar os campos para cadastrar pessoa física
function formPessoaFisica() {

    document.getElementById("titulo").style.color = '#ffffff'
    document.getElementById("form").style.backgroundColor = '#ffffff'
    document.getElementById("tipo-pessoa").style.background = 'linear-gradient(135deg, #228d02, #145400)'

    const elementos = document.querySelectorAll('.input-radio');
    elementos.forEach(elemento => {
        elemento.style.color = 'white';
    });

    // Apresentar o título cadastrar pessoa física
    document.getElementById("titulo-pessoa-fisica").style.display = 'flex';
    document.getElementById("titulo-pessoa-juridica").style.display = 'none';

    // Apresentar o formulário cadastrar pessoa física
    document.getElementById("form-pessoa-fisica").style.display = 'flex';
    document.getElementById("form-pessoa-juridica").style.display = 'none';

    // Carregar o botão cadastrar após o usuário selecionar o tipo de formulário pessoa física ou jurídica
    document.getElementById("form-btn-cadastrar").style.display = 'block';
    }

    // Função para carregar os campos para cadastrar pessoa jurídica
    function formPessoaJuridica() {

    document.getElementById("titulo").style.color = '#ffffff'
    document.getElementById("form").style.backgroundColor = '#ffffff'
    document.getElementById("tipo-pessoa").style.background = 'linear-gradient(135deg, #228d02, #145400)'

    const elementos = document.querySelectorAll('.input-radio');
    elementos.forEach(elemento => {
        elemento.style.color = 'white';
    });

    // Apresentar o título cadastrar pessoa jurídica
    document.getElementById("titulo-pessoa-juridica").style.display = 'flex';
    document.getElementById("titulo-pessoa-fisica").style.display = 'none';

    // Apresentar o formulário cadastrar pessoa jurídica
    document.getElementById("form-pessoa-fisica").style.display = 'none';
    document.getElementById("form-pessoa-juridica").style.display = 'flex';

    // Carregar o botão cadastrar após o usuário selecionar o tipo de formulário pessoa física ou jurídica
    document.getElementById("form-btn-cadastrar").style.display = 'block';
}

// máscaras nos campos de pessoa física
$('#cpf').mask('000.000.000-00', {reverse: true});
$('#telefoneFisica').mask('(00) 0000-0000');
$('#cepFisica').mask('00000-000');
$('#cepJuridica').mask('00000-000');
$('#cnpj').mask('00.000.000/0000-00', {reverse: true});
$('#telefoneFisica').mask('(00) 00000-0000');
$('#telefoneJuridica').mask('(00) 0000-0000');

// Função para buscar endereço via CEP para Pessoa Física
$(document).ready(function() {

    function limpa_formulário_cep() {
        $("#ruaFisica").val("");
        $("#bairroFisica").val("");
        $("#cidadeFisica").val("");
    }
    
    // Quando o campo CEP de Pessoa Física perde o foco
    $("#cepFisica").blur(function() {
        console.log("Evento blur no CEP acionado");
        var cep = $(this).val().replace(/\D/g, '');
        console.log("CEP digitado:", cep);

        if (cep !== "") {
            var validacep = /^[0-9]{8}$/;
            console.log("Validando CEP:", validacep.test(cep));

            if(validacep.test(cep)) {
                $("#ruaFisica").val("...");
                $("#bairroFisica").val("...");
                $("#cidadeFisica").val("...");
                console.log("CEP válido. Consultando ViaCEP.");

                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                    console.log("Resposta ViaCEP:", dados);
                    if (!("erro" in dados)) {
                        // Atualiza os campos com os valores da consulta.
                        $("#ruaFisica").val(dados.logradouro);
                        $("#bairroFisica").val(dados.bairro);
                        $("#cidadeFisica").val(dados.localidade);
                        console.log("Endereço preenchido com sucesso.");
                    } else {
                        // CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                        console.log("CEP não encontrado.");
                    }
                }).fail(function() {
                    // Erro na requisição.
                    limpa_formulário_cep();
                    alert("Erro ao consultar o CEP. Por favor, tente novamente.");
                    console.log("Falha na requisição ViaCEP.");
                });
            } else {
                // CEP é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
                console.log("Formato de CEP inválido.");
            }
        } else {
            // CEP sem valor, limpa formulário.
            limpa_formulário_cep();
            console.log("CEP vazio. Formulário limpo.");
        }
    });
});

// Função para buscar endereço via CEP para Pessoa Jurídica
$(document).ready(function() {

    function limpa_formulário_cep() {
        $("#ruaJuridica").val("");
    }
    
    // Quando o campo CEP de Pessoa Física perde o foco
    $("#cepFisica").blur(function() {
        var cep = $(this).val().replace(/\D/g, '');
        if (cep !== "") {
            var validacep = /^[0-9]{8}$/;
            console.log("Validando CEP:", validacep.test(cep));

            if(validacep.test(cep)) {
                $("#ruaJuridica").val("...");
                console.log("CEP válido. Consultando ViaCEP.");

                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                    console.log("Resposta ViaCEP:", dados);
                    if (!("erro" in dados)) {
                        // Atualiza os campos com os valores da consulta.
                        $("#ruaJuridica").val(dados.logradouro);
                        console.log("Endereço preenchido com sucesso.");
                    } else {
                        // CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                        console.log("CEP não encontrado.");
                    }
                }).fail(function() {
                    // Erro na requisição.
                    limpa_formulário_cep();
                    alert("Erro ao consultar o CEP. Por favor, tente novamente.");
                    console.log("Falha na requisição ViaCEP.");
                });
            } else {
                // CEP é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
                console.log("Formato de CEP inválido.");
            }
        } else {
            // CEP sem valor, limpa formulário.
            limpa_formulário_cep();
            console.log("CEP vazio. Formulário limpo.");
        }
    });
});
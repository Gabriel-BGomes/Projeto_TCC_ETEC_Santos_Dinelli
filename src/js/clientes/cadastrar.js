// Função para carregar os campos para cadastrar pessoa física
function formPessoaFisica() {

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

    // Apresentar o título cadastrar pessoa jurídica
    document.getElementById("titulo-pessoa-juridica").style.display = 'flex';
    document.getElementById("titulo-pessoa-fisica").style.display = 'none';

    // Apresentar o formulário cadastrar pessoa jurídica
    document.getElementById("form-pessoa-fisica").style.display = 'none';
    document.getElementById("form-pessoa-juridica").style.display = 'flex';

    // Carregar o botão cadastrar após o usuário selecionar o tipo de formulário pessoa física ou jurídica
    document.getElementById("form-btn-cadastrar").style.display = 'block';
}

let campoCpf = document.querySelector('.cpf');

/* // Função que deixa no padrão o CPF
document.addEventListener("DOMContentLoaded", function () {
    const campoCpf = document.querySelector("input[name='cpf_cliente']");

    campoCpf.addEventListener('keypress', () => {
        let tamanhoCampo = campoCpf.value.length;

        // Adiciona o primeiro ponto após o terceiro número
        if (tamanhoCampo === 3) {
            campoCpf.value += '.';
        }

        // Adiciona o segundo ponto após o sexto número
        if (tamanhoCampo === 7) {
            campoCpf.value += '.';
        }

        // Adiciona o traço após o nono número
        if (tamanhoCampo === 11) {
            campoCpf.value += '-';
        }
    });
}); */

$('#cpf').mask('000.000.000-00', {reverse: true});
$('#telefoneFisica').mask('(00) 0000-0000');
$('#cepFisica').mask('00000-000');
$('#cepJuridica').mask('00000-000');
$('#cnpj').mask('00.000.000/0000-00', {reverse: true});
$('#telefoneFisica').mask('(00) 00000-0000');
$('#telefoneJuridica').mask('(00) 0000-0000');
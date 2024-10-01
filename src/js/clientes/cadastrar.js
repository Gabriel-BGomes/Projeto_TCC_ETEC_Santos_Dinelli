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
});

// Função que adiciona máscara de telefone conforme o usuário digita
document.addEventListener("DOMContentLoaded", function () {
    const campoTelefone = document.querySelector("input[name='telefone']");

    campoTelefone.addEventListener('keypress', () => {
        let tamanhoCampo = campoTelefone.value.length;

        // Adiciona o parêntese esquerdo após o primeiro dígito do DDD
        if (tamanhoCampo === 0) {
            campoTelefone.value += '(';
        }

        // Adiciona o parêntese direito após o segundo dígito do DDD
        if (tamanhoCampo === 3) {
            campoTelefone.value += ') ';
        }

        // Adiciona o traço após o quinto dígito para celulares (formato (XX) XXXXX-)
        if (tamanhoCampo === 10) {
            campoTelefone.value += '-';
        }
    });
});
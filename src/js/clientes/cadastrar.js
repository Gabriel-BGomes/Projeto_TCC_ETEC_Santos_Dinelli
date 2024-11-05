// Função para mostrar o formulário com animação
function mostrarFormulario(formId) {
    // Esconde todos os formulários
    document.querySelectorAll('#form-pessoa-fisica, #form-pessoa-juridica').forEach(form => {
        if (form) {
            form.classList.remove('slide-down');
            form.style.display = 'none';
        }
    });

    // Mostra o formulário selecionado
    const formSelecionado = document.getElementById(formId);
    if (formSelecionado) {
        formSelecionado.style.display = 'flex';
        formSelecionado.style.backgroundColor = 'white';
        setTimeout(() => {
            formSelecionado.classList.add('slide-down');
        }, 10);
    }

    // Mostra o botão de cadastrar
    const btnCadastrar = document.getElementById('form-btn-cadastrar');
    if (btnCadastrar) {
        btnCadastrar.classList.remove('slide-down');
        btnCadastrar.style.display = 'block';
        // Força um reflow antes de adicionar a classe de animação
        void btnCadastrar.offsetWidth;
        btnCadastrar.classList.add('slide-down');
    }
}

function esconderFormulario() {
    // Esconde todos os formulários
    document.querySelectorAll('#form-pessoa-fisica, #form-pessoa-juridica').forEach(form => {
        if (form) {
            form.classList.remove('slide-down');
            form.style.display = 'none';
        }
    });
}

// Adicione os event listeners quando o DOM estiver completamente carregado
document.addEventListener('DOMContentLoaded', function() {
    const tipoPessoaFisica = document.getElementById('tipo_pessoa_fisica');
    const tipoPessoaJuridica = document.getElementById('tipo_pessoa_juridica');

    if (tipoPessoaFisica) {
        tipoPessoaFisica.addEventListener('change', function() {
            mostrarFormulario('form-pessoa-fisica');
        });
    }

    if (tipoPessoaJuridica) {
        tipoPessoaJuridica.addEventListener('change', function() {
            mostrarFormulario('form-pessoa-juridica');
        });
    }

    // Inicializar as máscaras
    if (jQuery().mask) {
        $('#cpf').mask('000.000.000-00', {reverse: true});
        $('#telefoneFisica').mask('(00) 00000-0000');
        $('#cepFisica').mask('00000-000');
        $('#cepJuridica').mask('00000-000');
        $('#cnpj').mask('00.000.000/0000-00', {reverse: true});
        $('#telefoneJuridica').mask('(00) 0000-0000');
    }

    const elementos = document.querySelectorAll('.input-radio');
    elementos.forEach(elemento => {
        elemento.style.color = 'white';
    });

    function showMessage(messageId) {
        const message = document.getElementById(messageId);
        if (message) {
            message.style.display = 'block';
            setTimeout(function() {
                message.style.opacity = '0';
                setTimeout(function() {
                    message.style.display = 'none';
                    message.style.opacity = '1';
                }, 500);
            }, 3000);
        }
    }

    // Verifica se há uma mensagem de sucesso ou erro
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');

    if (successMessage) {
        showMessage('successMessage');
    } else if (errorMessage) {
        showMessage('errorMessage');
    }

});



// Função para buscar endereço via CEP (comum para Pessoa Física e Jurídica)
function buscarEnderecoPorCEP(cepInput, ruaInput, bairroInput, cidadeInput) {
    $(cepInput).blur(function() {
        var cep = $(this).val().replace(/\D/g, '');
        if (cep !== "") {
            var validacep = /^[0-9]{8}$/;
            if(validacep.test(cep)) {
                $(ruaInput).val("...");
                $(bairroInput).val("...");
                $(cidadeInput).val("...");

                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                    if (!("erro" in dados)) {
                        $(ruaInput).val(dados.logradouro);
                        $(bairroInput).val(dados.bairro);
                        $(cidadeInput).val(dados.localidade);
                    } else {
                        limpaFormularioCEP(ruaInput, bairroInput, cidadeInput);
                        alert("CEP não encontrado.");
                    }
                }).fail(function() {
                    limpaFormularioCEP(ruaInput, bairroInput, cidadeInput);
                    alert("Erro ao consultar o CEP. Por favor, tente novamente.");
                });
            } else {
                limpaFormularioCEP(ruaInput, bairroInput, cidadeInput);
                alert("Formato de CEP inválido.");
            }
        } else {
            limpaFormularioCEP(ruaInput, bairroInput, cidadeInput);
        }
    });
}

function limpaFormularioCEP(ruaInput, bairroInput, cidadeInput) {
    $(ruaInput).val("");
    $(bairroInput).val("");
    $(cidadeInput).val("");
}

$(document).ready(function() {
    buscarEnderecoPorCEP("#cepFisica", "#ruaFisica", "#bairroFisica", "#cidadeFisica");
    buscarEnderecoPorCEP("#cepJuridica", "#ruaJuridica", "#bairroJuridica", "#cidadeJuridica");
});
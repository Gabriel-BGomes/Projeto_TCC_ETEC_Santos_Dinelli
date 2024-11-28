// Executar quando o documento HTML for completamente carregado
document.addEventListener('DOMContentLoaded', function () {

    // Receber o SELETOR calendar do atributo id
    var calendarEl = document.getElementById('calendar');

    // Receber o SELETOR da janela modal cadastrar
    const cadastrarModal = new bootstrap.Modal(document.getElementById("cadastrarModal")); 

    // Receber o SELETOR da janela modal visualizar
    const visualizarModal = new bootstrap.Modal(document.getElementById("visualizarModal"));

    // Receber o SELETOR "msgViewEvento"
    const msgViewEvento = document.getElementById('msgViewEvento');

    // Instanciar FullCalendar.Calendar e atribuir a variável calendar
    var calendar = new FullCalendar.Calendar(calendarEl, {

        // Incluir o bootstrap 5
        themeSystem: 'bootstrap5',

        title: {
            text: 'Teste'
        },

        // Criar o cabeçalho do calendário
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        // Definir o idioma usado no calendário
        locale: 'pt-br',

        // Permitir clicar nos nomes dos dias da semana 
        navLinks: true,

        // Permitir clicar e arrastar o mouse sobre um ou vários dias no calendário
        selectable: true,

        // Indicar visualmente a área que será selecionada antes que o usuário solte o botão do mouse para confirmar a seleção
        selectMirror: true,

        // Permitir arrastar e redimensionar os eventos diretamente no calendário.
        editable: true,

        // Número máximo de eventos em um determinado dia, se for true, o número de eventos será limitado à altura da célula do dia
        dayMaxEvents: true,

        // Chamar o arquivo PHP para recuperar os eventos
        events: '../php/agenda/listar_evento.php',

        // Identificar o clique do usuário sobre o evento
        eventClick: function (info) {
            
            // Apresentar os detalhes do evento
            document.getElementById("visualizarEvento").style.display = "block";
            document.getElementById("visualizarModalLabel").style.display = "block";

            // Ocultar o formulário editar do evento
            document.getElementById("editarEvento").style.display = "none";
            document.getElementById("editarModalLabel").style.display = "none";

            // Enviar para a janela modal os dados do evento
            document.getElementById("visualizar_id").innerText = info.event.id;
            document.getElementById("visualizar_title").innerText = info.event.title;
            document.getElementById("visualizar_obs").innerText = info.event.extendedProps.obs;
            document.getElementById("visualizar_start").innerText = info.event.start.toLocaleString();
            document.getElementById("visualizar_end").innerText = info.event.end !== null ? info.event.end.toLocaleString() : info.event.start.toLocaleString();
            document.getElementById("visualizar_servico").innerText = info.event.extendedProps.servico;

            // Enviar os dados do evento para o formulário editar
            document.getElementById("edit_id").value = info.event.id;
            document.getElementById("edit_title").value = info.event.title;
            document.getElementById("edit_obs").value = info.event.extendedProps.obs;
            document.getElementById("edit_start").value = converterData(info.event.start);
            document.getElementById("edit_end").value = info.event.end !== null ? converterData(info.event.end) : converterData(info.event.start);
            document.getElementById("edit_color").value = info.event.backgroundColor;
            document.getElementById("edit_servico").value = info.event.extendedProps.servico;

            // Abrir a janela modal visualizar
            visualizarModal.show();
        },

        // Abrir a janela modal cadastrar quando clicar sobre o dia no calendário
        select: function (info) {
            // Chamar a função para converter a data selecionada para ISO8601 e enviar para o formulário
            document.getElementById("cad_start").value = converterData(info.start);
            document.getElementById("cad_end").value = converterData(info.start);

            // Abrir a janela modal cadastrar
            cadastrarModal.show();
        }
    });

    // Função para remover a mensagem após 3 segundos
    function removerMsg() {
        setTimeout(() => {
            document.getElementById('msg').innerHTML = "";
        }, 3000);
    }

    // Renderizar o calendário
    calendar.render();

    // Converter a data
    function converterData(data) {
        const dataObj = new Date(data);
        const ano = dataObj.getFullYear();
        const mes = String(dataObj.getMonth() + 1).padStart(2, '0');
        const dia = String(dataObj.getDate()).padStart(2, '0');
        const hora = String(dataObj.getHours()).padStart(2, '0');
        const minuto = String(dataObj.getMinutes()).padStart(2, '0');
        return `${ano}-${mes}-${dia} ${hora}:${minuto}`;
    }

    // Receber o SELETOR do formulário cadastrar evento
    const formCadEvento = document.getElementById("formCadEvento");

    // Somente acessa o IF quando existir o SELETOR "formCadEvento"
    if (formCadEvento) {
        formCadEvento.addEventListener("submit", async (e) => {
            e.preventDefault();
            const dadosForm = new FormData(formCadEvento);
            const dados = await fetch("../php/agenda/cadastrar_evento.php", {
                method: "POST",
                body: dadosForm
            });
            const resposta = await dados.json();
            if (resposta['status']) {
                /* document.getElementById("msga").innerHTML = resposta['msg']; */
                msg.innerHTML = `<div class="alert alert-success" role="alert">${resposta['msg']}</div>`;
                document.getElementById("cad_id_cliente").value = "";
                document.getElementById("cad_title").value = "";
                document.getElementById("cad_servico").value = "";
                document.getElementById("cad_obs").value = "";
                document.getElementById("cad_start").value = "";
                document.getElementById("cad_end").value = "";
                document.getElementById("cad_color").value = "";
                document.getElementById("msgCadEvento").innerHTML = "";
                calendar.addEvent({
                    id: resposta['id'],
                    title: resposta['title'],
                    color: resposta['color'],
                    start: resposta['start'],
                    end: resposta['end'],
                    obs: resposta['obs'],
                    servico: resposta['servico'],
                    id_cliente: resposta['id_cliente']
                });
                cadastrarModal.hide();
            } else {
                msg.innerHTML = `<div class="alert alert-danger" role="alert">${resposta['msg']}</div>`;
            }

            removerMsg();

        });
    }

    // Receber o SELETOR ocultar detalhes do evento e apresentar o formulário editar evento
    const btnViewEditEvento = document.getElementById("btnViewEditEvento");

    if (btnViewEditEvento) {
        btnViewEditEvento.addEventListener("click", () => {
            document.getElementById("visualizarEvento").style.display = "none";
            document.getElementById("visualizarModalLabel").style.display = "none";
            document.getElementById("editarEvento").style.display = "block";
            document.getElementById("editarModalLabel").style.display = "block";
        });
    }

    // Receber o SELETOR ocultar formulário editar evento e apresentar o detalhes do evento
    const btnViewEvento = document.getElementById("btnViewEvento");

    if (btnViewEvento) {
        btnViewEvento.addEventListener("click", () => {
            document.getElementById("visualizarEvento").style.display = "block";
            document.getElementById("visualizarModalLabel").style.display = "block";
            document.getElementById("editarEvento").style.display = "none";
            document.getElementById("editarModalLabel").style.display = "none";
        });
    }

    // Adicione este script no seu arquivo HTML ou script.js
document.getElementById('formCadEvento').addEventListener('submit', function(e) {
    e.preventDefault(); // Previne o envio padrão do formulário

    // Aqui você faria a submissão via AJAX
    fetch('sua_url_de_processamento', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Fecha o modal se o cadastro for bem-sucedido
            var modal = bootstrap.Modal.getInstance(document.getElementById('cadastrarModal'));
            modal.hide();

            // Opcional: atualizar a página ou calendário
            location.reload(); // ou chamar uma função para atualizar o calendário
        } else {
            // Tratar erro, se necessário
            alert('Erro ao cadastrar o serviço');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao processar o cadastro');
    });
});

    // Receber o SELETOR do formulário editar evento
    const formEditEvento = document.getElementById("formEditEvento");

    const msgEditEvento = document.getElementById("msgEditEvento");
    const btnEditEvento = document.getElementById("btnEditEvento");

    if (formEditEvento) {
        formEditEvento.addEventListener("submit", async (e) => {
            e.preventDefault();
            btnEditEvento.value = "Salvando...";
            const dadosForm = new FormData(formEditEvento);
            const dados = await fetch("../php/agenda/editar_evento.php", {
                method: "POST",
                body: dadosForm
            });
            const resposta = await dados.json();
            if (!resposta['status']) {
                msgEditEvento.innerHTML = `<div class="alert alert-danger" role="alert">${resposta['msg']}</div>`;
            } else {
                msg.innerHTML = `<div class="alert alert-success" role="alert">${resposta['msg']}</div>`;
                msgEditEvento.innerHTML = "";
                formEditEvento.reset();
                const eventoExiste = calendar.getEventById(resposta['id']);
                if (eventoExiste) {
                    eventoExiste.setProp('title', resposta['title']);
                    eventoExiste.setProp('color', resposta['color']);
                    eventoExiste.setExtendedProp('obs', resposta['obs']);
                    eventoExiste.setExtendedProp('servico', resposta['servico']);
                    eventoExiste.setStart(resposta['start']);
                    eventoExiste.setEnd(resposta['end']);

                    eventoExiste.setEnd(resposta['end']);
                }

                // Chamar a função para remover a mensagem após 3 segundos
                removerMsg();

                // Fechar a janela modal
                visualizarModal.hide();
            }

            // Apresentar no botão o texto "Salvar"
            btnEditEvento.value = "Salvar";
        });
    }

    

    // Receber o SELETOR apagar evento
    const btnApagarEvento = document.getElementById("btnApagarEvento");

    if (btnApagarEvento) {
        // Aguardar o usuário clicar no botão apagar
        btnApagarEvento.addEventListener("click", async () => {
            // Exibir uma caixa de diálogo de confirmação
            const confirmacao = window.confirm("Tem certeza de que deseja apagar este serviço?");

            // Verificar se o usuário confirmou
            if (confirmacao) {
                // Receber o id do evento
                var idEvento = document.getElementById("visualizar_id").textContent;

                // Chamar o arquivo PHP responsável por apagar o evento
                const dados = await fetch("../php/agenda/apagar_evento.php?id=" + idEvento);

                // Realizar a leitura dos dados retornados pelo PHP
                const resposta = await dados.json();

                // Acessa o IF quando não apagar com sucesso
                if (!resposta['status']) {
                    msgViewEvento.innerHTML = `<div class="alert alert-danger" role="alert">${resposta['msg']}</div>`;
                } else {
                    msg.innerHTML = `<div class="alert alert-success" role="alert">${resposta['msg']}</div>`;
                    msgViewEvento.innerHTML = "";

                    // Recuperar o evento no FullCalendar
                    const eventoExisteRemover = calendar.getEventById(idEvento);

                    // Verificar se encontrou o evento no FullCalendar
                    if (eventoExisteRemover) {
                        // Remover o evento do calendário
                        eventoExisteRemover.remove();
                    }

                    // Chamar a função para remover a mensagem após 3 segundos
                    removerMsg();

                    // Fechar a janela modal
                    visualizarModal.hide();
                }
            }
        });
    }

});

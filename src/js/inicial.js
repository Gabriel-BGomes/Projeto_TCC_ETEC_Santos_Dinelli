document.addEventListener('DOMContentLoaded', function () {
    const dataHojeEl = document.getElementById('data-hoje');
    const listaEventosEl = document.getElementById('listaEventos');

    // Obter e formatar a data atual
    const formatarDataHoje = () => {
        const dataHoje = new Date().toLocaleDateString('pt-BR', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        return dataHoje.charAt(0).toUpperCase() + dataHoje.slice(1);
    };

    // Renderizar mensagem quando não houver eventos
    const renderizarSemEventos = (mensagem) => {
        listaEventosEl.innerHTML = `
            <div class="sem-eventos">
                <i class="fas fa-calendar-times fa-3x"></i>
                <p>${mensagem}</p>
            </div>`;
    };

    // Renderizar mensagem de erro
    const renderizarErro = () => {
        listaEventosEl.innerHTML = `
            <div class="sem-eventos">
                <i class="fas fa-exclamation-triangle fa-3x"></i>
                <p>Erro ao carregar serviços. Tente novamente mais tarde.</p>
            </div>`;
    };

    // Função para renderizar eventos
    const renderizarEventos = (eventos) => {
        let listaEventos = '';
        eventos.forEach(evento => {
            const dataInicio = new Date(evento.start);
            const dataFim = evento.end ? new Date(evento.end) : null;

            listaEventos += `
                <div class="list-group-item">
                    <div class="evento-titulo">
                        <i class="fas fa-bookmark"></i> ${evento.cliente_nome}
                    </div>
                    <div class="evento-detalhes">
                        <div class="servico-info">
                            <i class="fas fa-cog"></i>
                            <span>Serviço: ${evento.servico}</span>
                        </div>
                        <div class="servico-info">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Endereço: ${evento.cliente_endereco}</span>
                        </div>
                        <div class="tempo-info">
                            <i class="fas fa-clock"></i>
                            <span>
                                Início: ${dataInicio.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' })}
                                ${dataFim ? ` - Fim: ${dataFim.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' })}` : ''}
                            </span>
                        </div>
                    </div>
                </div>`;
        });

        listaEventosEl.innerHTML = listaEventos;
    };

    // Configurar a data no cabeçalho
    dataHojeEl.innerText = formatarDataHoje();

    // Buscar os eventos do dia
    fetch('../php/agenda/listar_eventos_dia.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === false) {
                renderizarSemEventos(data.msg);
            } else {
                renderizarEventos(data.data);
            }
        })
        .catch(error => {
            console.error('Erro ao carregar serviços:', error);
            renderizarErro();
        });
});

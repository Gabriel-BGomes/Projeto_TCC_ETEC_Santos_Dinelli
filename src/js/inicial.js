document.addEventListener('DOMContentLoaded', function () {
  fetch('../php/agenda/listar_eventos_dia.php')
  .then(response => response.json())
  .then(data => {
      const dataHoje = new Date().toLocaleDateString('pt-BR', { 
          weekday: 'long',
          year: 'numeric', 
          month: 'long', 
          day: 'numeric' 
      });
      document.getElementById('data-hoje').innerText = dataHoje.charAt(0).toUpperCase() + dataHoje.slice(1);

      if (data.status === false) {
          document.getElementById('listaEventos').innerHTML = `
              <div class="sem-eventos">
                  <i class="fas fa-calendar-times fa-3x"></i>
                  <p>${data.msg}</p>
              </div>`;
      } else {
          let listaEventos = '';
          data.forEach(evento => {
              const dataInicio = new Date(evento.start);
              const dataFim = evento.end ? new Date(evento.end) : null;
              
              listaEventos += `
                  <div class="list-group-item">
                      <div class="evento-titulo">
                          <i class="fas fa-bookmark"></i>
                          ${evento.cliente_nome}
                      </div>
                      <div class="evento-detalhes">

                          <div class="servico-info">
                              <i class="fas fa-cog"></i>
                              <span>Serviço: ${evento.servico}</span>
                          </div>

                          <div class="servico-info">
                              <i class="fas fa-cog"></i>
                              <span>Endereço: ${evento.cliente_endereco}</span>
                          </div>

                          <div class="tempo-info">
                              <i class="fas fa-clock"></i>
                              <span>
                                  Início: ${dataInicio.toLocaleTimeString('pt-BR', {hour: '2-digit', minute:'2-digit'})}
                                  ${dataFim ? ` - Fim: ${dataFim.toLocaleTimeString('pt-BR', {hour: '2-digit', minute:'2-digit'})}` : ''}
                              </span>
                          </div>
                      </div>
                  </div>`;
          });
          document.getElementById('listaEventos').innerHTML = listaEventos;
      }
  })
  .catch(error => {
      console.error('Erro ao carregar serviços:', error);
      document.getElementById('listaEventos').innerHTML = `
          <div class="sem-eventos">
              <i class="fas fa-exclamation-triangle fa-3x"></i>
              <p>Erro ao carregar serviços.</p>
          </div>`;
  });
});
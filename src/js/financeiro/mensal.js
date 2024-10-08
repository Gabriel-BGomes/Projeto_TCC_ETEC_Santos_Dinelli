const mensal = document.getElementById('mensal'); // é o id puxado do html para fazer tudo aconter
const monthSelector = document.getElementById("monthSelector");
const inserirValores = document.getElementById('inserirValores');
const editarValores = document.getElementById('editarValores');
const excluirValores = document.getElementById('excluirValores');
const atualizarGraph = document.getElementById('atualizarGraph');
const recebimentosInput = document.getElementById('recebimentos');
const despesasInput = document.getElementById('despesas');

const mesSelecionadoRecebimento = {
  'Janeiro': 0,
  'Fevereiro': 20,
  'Março': 0,
  'Abril': 0,
  'Maio': 0, 
  'Junho': 0,
  'Julho': 0,
  'Agosto': 0,
  'Setembro': 0,
  'Outubro': 0,
  'Novembro': 0,
  'Dezembro': 0
};

const mesSelecionadoDespesa = {
  'Janeiro': 0,
  'Fevereiro': 0,
  'Março': 0,
  'Abril': 0,
  'Maio': 0, 
  'Junho': 0,
  'Julho': 0,
  'Agosto': 0,
  'Setembro': 0,
  'Outubro': 0,
  'Novembro': 0,
  'Dezembro': 0
};

const meses = {
  0: 'Janeiro',
  1: 'Fevereiro',
  2: 'Março',
  3: 'Abril',
  4: 'Maio',
  5: 'Junho',
  6: 'Julho',
  7: 'Agosto',
  8: 'Setembro',
  9: 'Outubro',
  10: 'Novembro',
  11: 'Dezembro',
}


// aqui você pode declarar uma variável ou declarar no próprio chart as informações do gráfico.
var dataAnual = {
  labels: ['RESUMO'], // colunas
  datasets: [{
    label: 'RECEBIMENTOS', // nome da primeira coluna
    data: Object.values(mesSelecionadoRecebimento), // dados da primeira coluna
    backgroundColor: 'green' // cor da primeira coluna
  },

  {
    label: 'DESPESAS', // nome da segunda coluna
    data: Object.values(mesSelecionadoDespesa), // dados da segunda coluna
    backgroundColor: 'red' // cor da segunda coluna
  }
]
};

// da mesma forma como pode ser criada uma vaiável no data, você pode criar uma varíavel para definir o text de todas as fontes
var fonte = {
  family: 'Times New Roman',
  size: 55,
}

var options = {
  responsive: true, 
  maintainAspectRatio: false,
  animations: { // opções de animação caso o type for "line"
    tension: {
      duration: 500,
      easing: 'easeInOutBounce',
      from: 1,
      to: 0,
      loop: true
    }
    
  },

  scales: { // scales pelo que entendi irá mexer no nome dos índices
    x: {
      ticks: {
        color: 'black', // cor da legenda X
        font: {
          size: 16,
          weight: 'lighter'
          }
      }
    },

    y: { // defining min and max so hiding the d,ataset does not change scale range
      ticks: {
        color: 'black', // cor da legenda Y
        font: {
          size: 16,
          weight: 'lighter'
        }
      }
    }

  },

  plugins: { // para fazer mais configurações de estilo
    title: { // adicionar um estilo ao gráfico
      display: true,
      text: `RESUMO MENSAL DE ${monthSelector.value.toUpperCase()}`, // título
      font: fonte, // puxando a constante de fonte
      color: '#145400' // mudando a cor do título
    },

    tooltip: { // tooltip  é o que aparece quando o mouse fica em cima de cada coluna
      titleColor: '#f1e8e8', // mudando a cor do título da coluna
      bodyColor: 'white', // mudando a cor da legenda do pop-up
      backgroundColor: 'rgb(60, 66, 71)' // mudando o background do pop-up
    },

    legend: {
      labels: {
        color: 'black', // aqui irá mudar a cor das legendas de cada coluna (verificar se têm como mudar indiviudalmente cada coluna)
        weight: 'bold' 
      }
    }

  }
}

// definindo o background padrão
Chart.defaults.backgroundColor = 'pink';

var definingChart = {
  type: 'bar', // tipo do gráfico (linha, coluna)
  data: dataAnual, // puxando a constante data
  options: options
  };
  
// criando de fato o gráfico
const chartMensal = new Chart(mensal, definingChart);

// zerar os valores do recebimento e despesa após digitar os valores
function manterInputs() {
  recebimentosInput.addEventListener('click', function() {
    recebimentosInput.value = recebimentosInput.value
  })
  
  despesasInput.addEventListener('focus', function() {
  despesasInput.value = despesasInput.value
  })

};

function limparInputs() {
  recebimentosInput.value = '';
  despesasInput.value = '';
}

// Função para carregar os dados financeiros do PHP para o gráfico anual
function carregarDadosFinanceiros() {
  fetch('../php/financeiro/dados_finance.php') // Ajuste o caminho conforme necessário
    .then(response => response.json())
    .then(data => {
      
      // Resetar os dados
      Object.keys(mesSelecionadoRecebimento).forEach(mes => {
        mesSelecionadoRecebimento[mes] = 0;
        mesSelecionadoDespesa[mes] = 0;
      });

      // Atualizar os dados dos meses
      data.forEach(item => {
        
        mesSelecionadoRecebimento[item.mes] = item.recebimento;
        mesSelecionadoDespesa[item.mes] = item.despesa;

      });

      let monthSele = monthSelector.value

      // Atualizar o gráfico com os novos dados
      chartMensal.data.datasets[0].data = [mesSelecionadoRecebimento[monthSele]];
      chartMensal.data.datasets[1].data = [mesSelecionadoDespesa[monthSele]];

      chartMensal.update(); // Atualizar o gráfico

      

      redefinirInputs();

    })
    .catch(error => console.error('Erro ao carregar os dados anuais:', error));
}

// função para puxar a função de carregar os dados assim que entrar no financeiro.
carregarDadosFinanceiros();

// Atualizar o gráfico com base na seleção do mês
monthSelector.addEventListener("change", function() {
  let monthSele = monthSelector.value;

  chartMensal.data.datasets[0].data = [mesSelecionadoRecebimento[monthSele]];
  chartMensal.data.datasets[1].data = [mesSelecionadoDespesa[monthSele]];

  chartMensal.options.plugins.title.text = `RESUMO MENSAL DE ${monthSele.toUpperCase()}`;

  chartMensal.update();
});

inserirValores.addEventListener('click', function (event) {
  event.preventDefault(); // Impede o envio do formulário

  let month = monthSelector.value;
  let recebimentos = parseInt(recebimentosInput.value);
  let despesas = parseInt(despesasInput.value);

  // Envio dos dados via AJAX
  fetch('../php/financeiro/processaFinancas.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `action=insert&recebimento=${recebimentos}&despesa=${despesas}&mes=${month}`
  })
  
  .then(data => {
    console.log(data); // Exibe o resultado no console para debug
    carregarDadosFinanceiros(); // Chama a função para atualizar os dados do gráfico
  })
  .catch(error => {
      console.error('Erro ao carregar os dados:', error);
  });

  limparInputs();

});

editarValores.addEventListener('click', function (event) {
  event.preventDefault(); // Impede o envio do formulário

  let month = monthSelector.value;
  let recebimentos = parseInt(recebimentosInput.value);
  let despesas = parseInt(despesasInput.value);

  // Envio dos dados via AJAX
  fetch('../php/financeiro/processaFinancas.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `action=edit&recebimento=${recebimentos}&despesa=${despesas}&mes=${month}`
  })

  .then(data => {
    console.log(data); // Exibe o resultado no console para debug
    carregarDadosFinanceiros(); // Chama a função para atualizar os dados do gráfico
  })
  .catch(error => {
      console.error('Erro ao carregar os dados:', error);
  });

  limparInputs();
  
});

excluirValores.addEventListener('click', function (event) {
  event.preventDefault(); // Impede o envio do formulário

  let month = monthSelector.value;
  let recebimentos = parseInt(recebimentosInput.value);
  let despesas = parseInt(despesasInput.value);

  // Envio dos dados via AJAX para excluir (pode ser um método diferente se precisar)
  fetch('../php/financeiro/processaFinancas.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `action=remove&recebimento=${recebimentos}&despesa=${despesas}&mes=${month}`
  })
  
  .then(data => {
    console.log(data); // Exibe o resultado no console para debug
    carregarDadosFinanceiros(); // Chama a função para atualizar os dados do gráfico
  })
  .catch(error => {
      console.error('Erro ao carregar os dados:', error);
  });
  
  limparInputs()

});

atualizarGraph.addEventListener('click', function(event) {
  event.preventDefault();
  carregarDadosFinanceiros();
});


const anual = document.getElementById('anual'); // é o id puxado do html para fazer tudo aconter
const monthSelector = document.getElementById('monthSelector');

const mesSelecionadoRecebimento = {
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


// aqui você pode declarar uma variável ou declarar no próprio chart as informações do gráfico.
var dataMensal = {
  labels: ['RESUMO'], // colunas
  datasets: [{
    label: 'RECEBIMENTOS', // nome da primeira coluna
    data: mesSelecionadoRecebimento, // dados da primeira coluna
    backgroundColor: 'green' // cor da primeira coluna
  },

  {
    label: 'DESPESAS', // nome da segunda coluna
    data: mesSelecionadoDespesa, // dados da segunda coluna
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
      text: `RESUMO DE ${monthSelector.value.toUpperCase()}`, // título
      font: fonte, // puxando a constante de fonte
      color: '#145400' // mudando a cor do título
    },

    tooltip: { // tooltip  é o que aparece quando o mouse fica em cima de cada coluna
      titleColor: 'pink', // mudando a cor do título da coluna
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

var definingChart = {
  type: 'bar', // tipo do gráfico (linha, coluna)
  data: dataMensal, // puxando a constante data
  options: options
  };

// criando de fato o gráfico
const chartAnual = new Chart(anual, definingChart);

// Função para carregar os dados financeiros do PHP para o gráfico anual
function carregarDadosAnuais() {
  fetch('../../js/financeiro/php/dados_finance.php') // Ajuste o caminho conforme necessário
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

      // Atualizar o gráfico com os novos dados
      chartAnual.data.datasets[0].data = Object.values(mesSelecionadoRecebimento);
      chartAnual.data.datasets[1].data = Object.values(mesSelecionadoDespesa);
      chartAnual.update(); // Atualizar o gráfico
    })
    .catch(error => console.error('Erro ao carregar os dados anuais:', error));
}

// Chamar a função para carregar os dados anuais inicialmente
carregarDadosAnuais();


// Atualizar o gráfico com base na seleção do mês
monthSelector.addEventListener("change", function() {
  let monthSele = monthSelector.value;

  if (monthSele == 'Todos') {
    chartAnual.data.datasets[0].data = (mesSelecionadoRecebimento);
    chartAnual.data.datasets[1].data = (mesSelecionadoDespesa);
    chartAnual.options.plugins.title.text = `RESUMO ANUAL`;
  } else {
    chartAnual.data.datasets[0].data = [mesSelecionadoRecebimento[monthSele]];
    chartAnual.data.datasets[1].data = [mesSelecionadoDespesa[monthSele]];
    chartAnual.options.plugins.title.text = `RESUMO DE ${monthSele.toUpperCase()}`;
  };

  chartAnual.update();
  
});

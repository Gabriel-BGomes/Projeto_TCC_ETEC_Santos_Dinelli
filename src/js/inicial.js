const inicial = document.getElementById('inicial'); // é o id puxado do html para fazer tudo aconter
const monthSelector = document.getElementById('monthSelector');
const mesAtual = new Date().getMonth();

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
      text: `RESUMO MENSAL DE ${meses[mesAtual].toUpperCase()}`, // título
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
const chartInicial = new Chart(inicial, definingChart);

// Função para carregar os dados financeiros do PHP para o gráfico inicial
function carregarDadosAnuais() {
  fetch('../php/financeiro/dados_finance.php') // Ajuste o caminho conforme necessário
    .then(response => response.json())
    .then(data => {

      console.log("Dados recebidos do PHP:", data);

      // Resetar os dados
      Object.keys(mesSelecionadoRecebimento).forEach(mes => {
        mesSelecionadoRecebimento[mes] = 0;
        mesSelecionadoDespesa[mes] = 0;
      });

      // Atualizar os dados dos meses
      data.forEach(item => {
        mesSelecionadoRecebimento[item.mes] = parseFloat(item.recebimento); // Garantir que é um número
        mesSelecionadoDespesa[item.mes] = parseFloat(item.despesa); // Garantir que é um número
      });

      monthAtual = meses[mesAtual]
      console.log(mesSelecionadoDespesa[monthAtual]);


      // Atualizar o gráfico com todos os dados dos meses
      chartInicial.data.datasets[0].data = [mesSelecionadoRecebimento[monthAtual]]; // Recebimentos
      chartInicial.data.datasets[1].data = [mesSelecionadoDespesa[monthAtual]];

      chartInicial.update(); // Atualizar o gráfico

      
    })
    .catch(error => console.error('Erro ao carregar os dados anuais:', error));
}

// Chamar a função para carregar os dados anuais inicialmente
carregarDadosAnuais();

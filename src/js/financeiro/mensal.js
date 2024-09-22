const mensal = document.getElementById('mensal'); // é o id puxado do html para fazer tudo aconter
const monthSelector = document.getElementById("monthSelector");
const inserirValores = document.getElementById('inserirValores');
const editarValores = document.getElementById('editarValores');
const excluirValores = document.getElementById('excluirValores');
const recebimentosInput = document.getElementById('recebimentos');
const despesasInput = document.getElementById('despesas');

var mesSelecionadoRecebimento = {
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

var mesSelecionadoDespesa = {
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

var anual = {
  mesSelecionadoRecebimento,
  mesSelecionadoDespesa
}

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
      text: "RESUMO MENSAL", // título
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
const chartMensal = new Chart(mensal, definingChart);

inserirValores.addEventListener('click', function() {

  let month = monthSelector.value;
  console.log(month)

  let recebimentos = parseInt(recebimentosInput.value);
  let despesas = parseInt(despesasInput.value);

  mesSelecionadoRecebimento[month] += recebimentos;
  mesSelecionadoDespesa[month] += despesas;

  anual = {
    mesSelecionadoRecebimento,
    mesSelecionadoDespesa
  }
  
  chartMensal.data.labels = ['Mês de ' + month]
  chartMensal.data.datasets[0].data[month] = mesSelecionadoRecebimento[month]
  chartMensal.data.datasets[1].data[month] = mesSelecionadoDespesa[month]
  
  chartMensal.update();

  despesas = 0
  recebimentos = 0

});

editarValores.addEventListener('click', function() {

  let month = monthSelector.value;
  console.log(month)

  let recebimentos = parseInt(recebimentosInput.value);
  let despesas = parseInt(despesasInput.value);

  mesSelecionadoRecebimento[month] = recebimentos;
  mesSelecionadoDespesa[month] = despesas;

  anual = {
    mesSelecionadoRecebimento,
    mesSelecionadoDespesa
  }
  
  chartMensal.data.labels = ['Mês de ' + month]
  chartMensal.data.datasets[0].data[month] = recebimentos
  chartMensal.data.datasets[1].data[month] = despesas
  
  chartMensal.update();

});

excluirValores.addEventListener('click', function() {

  let month = monthSelector.value;
  console.log(month)

  let recebimentos = parseInt(recebimentosInput.value);
  let despesas = parseInt(despesasInput.value);

  mesSelecionadoRecebimento[month] -= recebimentos;
  mesSelecionadoDespesa[month] -= despesas;

  anual = {
    mesSelecionadoRecebimento,
    mesSelecionadoDespesa
  }
  
  chartMensal.data.labels = ['Mês de ' + month]
  chartMensal.data.datasets[0].data[month] = mesSelecionadoRecebimento[month]
  chartMensal.data.datasets[1].data[month] = mesSelecionadoDespesa[month]
  
  chartMensal.update();

  despesas = 0
  recebimentos = 0

});
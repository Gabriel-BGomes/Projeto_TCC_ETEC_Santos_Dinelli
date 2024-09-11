const mensal = document.getElementById('mensal'); // é o id puxado do html para fazer tudo aconter

let mesAtual = new Date().getMonth()+1

let meses = {
  1: ["JANEIRO"],
  2: ["FEVEREIRO"],
  3: ["MARÇO"],
  4: ["ABRIL"],
  5: ["MAIO"],
  6: ["JUNHO"],
  7: ["JULHO"],
  8: ["AGOSTO"],
  9: ["SETEMBRO"],
  10: ["OUTUBRO"],
  11: ["NOVEMBRO"],
  12: ["DEZEMBRO"],
}

// aqui você pode declarar uma variável ou declarar no próprio chart as informações do gráfico.
var dataMensal = {
  labels: ['RESUMO'], // colunas
  datasets: [{
    label: 'RECEBIMENTOS', // nome da primeira coluna
    data: [20], // dados da primeira coluna
    backgroundColor: 'green' // cor da primeira coluna
  },

  {
    label: 'DESPESAS', // nome da segunda coluna
    data: [10], // dados da segunda coluna
    backgroundColor: 'red' // cor da segunda coluna
  }
]
};


// da mesma forma como pode ser criada uma vaiável no data, você pode criar uma varíavel para definir o text de todas as fontes
var fonte = {
  family: 'Times New Roman',
  size: 55,
  color: 'black'
}

var options = {

  responsive: true,
  maintainAspectRadio: true,

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
      }
    },

    y: { // defining min and max so hiding the d,ataset does not change scale range
      ticks: {
        color: 'black' // cor da legenda Y
      }
    }

  },

  plugins: { // para fazer mais configurações de estilo
    title: { // adicionar um estilo ao gráfico
      display: true,
      text: `RESUMO MENSAL DE ${meses[mesAtual]}`, // título
      font: fonte, // puxando a constante de fonte
      color: 'purple' // mudando a cor do título
    },

    tooltip: { // tooltip é o que aparece quando o mouse fica em cima de cada coluna
      titleColor: 'pink', // mudando a cor do título da coluna
      bodyColor: 'white', // mudando a cor da legenda do pop-up
      backgroundColor: 'rgb(60, 66, 71)' // mudando o background do pop-up
    },

    legend: {
      labels: {
        color: 'red' // aqui irá mudar a cor das legendas de cada coluna (verificar se têm como mudar indiviudalmente cada coluna)
      }
    }

  }
}

// definindo o background padrão
Chart.defaults.backgroundColor = 'pink';

var definingChart = {
  type: 'bar', // tipo do gráfico (linha, coluna)
  data: dataMensal, // puxando a constante data
  options: options
  };

// criando de fato o gráfico
const chartMensal = new Chart(mensal, definingChart);

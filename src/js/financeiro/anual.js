const anual = document.getElementById('anual'); // é o id puxado do html para fazer tudo aconter
const monthSelectorAnual = document.getElementById('monthSelector');

window.alert('teste');

// aqui você pode declarar uma variável ou declarar no próprio chart as informações do gráfico.
var dataAnual = {
  labels: ['RESUMO'], // colunas
  datasets: [{
    label: 'RECEBIMENTOS', // nome da primeira coluna
    data: [1, 2, 3], // dados da primeira coluna
    backgroundColor: 'green' // cor da primeira coluna
  },

  {
    label: 'DESPESAS', // nome da segunda coluna
    data: [1, 2, 3], // dados da segunda coluna
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
      text: "RESUMO ANUAL", // título
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

// definindo o background padrão
Chart.defaults.backgroundColor = 'pink';

var definingChart = {
  type: 'bar', // tipo do gráfico (linha, coluna)
  data: dataAnual, // puxando a constante data
  options: options
  };
  
// criando de fato o gráfico
const chartAnual = new Chart(anual, definingChart);

monthSelectorAnual.addEventListener("change", function() {

    let monthSele = monthSelectorAnual.value;
    
    if (monthSele == 'Todos') {
      chartAnual.data.datasets[0].data = mesSelecionadoRecebimento;
      chartAnual.data.datasets[1].data = mesSelecionadoDespesa;
    } else {
      chartAnual.data.datasets[0].data = [mesSelecionadoRecebimento[monthSele]];
      chartAnual.data.datasets[1].data = [mesSelecionadoDespesa[monthSele]];
    };

    chartAnual.update();

});

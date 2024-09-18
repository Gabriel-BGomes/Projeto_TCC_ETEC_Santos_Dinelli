const mensal = document.getElementById('mensal'); // é o id puxado do html para fazer tudo aconter
const mesAtual = new Date().getMonth()


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
  'Setembro': 20,
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
  'Setembro': 30,
  'Outubro': 0,
  'Novembro': 0,
  'Dezembro': 0
};

const anual = {
  mesSelecionadoRecebimento,
  mesSelecionadoDespesa
}

const mesAtualString = meses[mesAtual]



// da mesma forma como pode ser criada uma vaiável no data, você pode criar uma varíavel para definir o text de todas as fontes
const fonte = {
  family: 'Times New Roman',
  size: 55,
}


// aqui você pode declarar uma variável ou declarar no próprio chart as informações do gráfico.
const dataMensal = {
  labels: ['RESUMO'], // colunas
  datasets: [{
    label: 'RECEBIMENTOS', // nome da primeira coluna
    data: [mesSelecionadoRecebimento[mesAtualString]], // dados da primeira coluna
    backgroundColor: 'green' // cor da primeira coluna
  },

  {
    label: 'DESPESAS', // nome da segunda coluna
    data: [mesSelecionadoDespesa[mesAtualString]], // dados da segunda coluna
    backgroundColor: 'red' // cor da segunda coluna
  }
]
};

const options = {
    responsive: true,
    maintainAspectRadio: false,
    responsive: true,
    scales: { // scales pelo que entendi irá mexer no nome dos índices
    x: {
      ticks: {
        color: 'black', // cor da legenda X
      },

    },

    y: { // defining min and max so hiding the d,ataset does not change scale range
      ticks: {
        color: 'black' // cor da legenda Y
      },

      

    }

  },

  plugins: { // para fazer mais configurações de estilo
    title: { // adicionar um estilo ao gráfico
      display: true,
      text: `RESUMO MENSAL DE ${meses[mesAtual].toUpperCase()}`, // título
      font: fonte, // puxando a constante de fonte
      color: '#145400' // mudando a cor do título
    },
    
    tooltip: { // tooltip é o que aparece quando o mouse fica em cima de cada coluna
      titleColor: 'pink', // mudando a cor do título da coluna
      bodyColor: 'white', // mudando a cor da legenda do pop-up
      backgroundColor: 'rgb(60, 66, 71)' // mudando o background do pop-up
    },

    // aqui irá mudar a cor das legendas de cada coluna (verificar se têm como mudar indiviudalmente cada coluna)

  }
}


const definingChart = {
  type: 'bar', // tipo do gráfico (linha, coluna)
  data: dataMensal, // puxando a constante data
  options: options
  };

// criando de fato o gráfico
const chartMensal = new Chart(mensal, definingChart);

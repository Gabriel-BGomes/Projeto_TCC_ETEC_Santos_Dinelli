<?php

session_start(); // Iniciar a sessão

ob_start(); // Limpar o buffer de saída

// Definir um fuso horario padrao
date_default_timezone_set('America/Sao_Paulo');

// Acessar o IF quando o usuário não estão logado e redireciona para página de login
if((!isset($_SESSION['id'])) and (!isset($_SESSION['usuario'])) and (!isset($_SESSION['codigo_autenticacao']))){
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário realizar o login para acessar a página!</p>";

    // Redirecionar o usuário
    header("Location: /project_Santos_Dinelli/src/pages/login/index.php");

    // Pausar o processamento
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financeiro</title>
    <link rel="stylesheet" href="../../style/layout-header.css">
    <link rel="stylesheet" href="../../style/financeiro/finance.css">
    
</head>

    <body>
        
        <header class="header"> <!-- começo menu fixo no topo -->
        
            <nav class="menu-lateral"> <!-- primeiro item do menu -->

                <input type="checkbox" class="fake-tres-linhas">
                <div><img class="tres-linhas" src="../../images/menu-tres-linhas.png" alt="menu de três linhas"></div>

                <ul>
                    <li><a href="../home.php">ÍNICIO</a></li>
                    <li><a href="../agenda/index.php">AGENDA</a></li>
                    <li><a href="../financeiro/finance.php">FINANCEIRO</a></li>
                    <li><a href="https://WA.me/+5511947295062/?text=Olá, preciso de ajuda com o software." target="_blank">SUPORTE</a></li>
                    <li><a href="../../../login/index.php">SAIR</a></li>
                </ul>

            </nav>

            <nav> <!-- começar com uma nav para definir os itens do menu-->

                <ul class="menu-fixo"> <!-- começo dos itens do menu-->

                    <li><a href="../home.php">ÍNICIO</a></li>
                    <li><a href="../agenda/index.php">AGENDA</a></li>
                    <li><a href="../financeiro/finance.php">FINANCEIRO</a></li>
                    <li><a href="https://WA.me/+5511947295062/?text=Olá, preciso de ajuda com o software." target="_blank">SUPORTE</a></li>

                </ul>

            </nav>

            <div> <!-- finalizar com a logo da empresa na direita-->

                <a href="https://www.santosedinelli.com.br/" target="_blank">
                <img class="logo" src="../../images/santos-dinelli.png"  alt="logo da empresa"></a>

            </div> <!-- final da div da logo-->

        </header> <!-- fim header fixo -->


        <section> <!-- começo da sessão-->

            <div class="container"> <!-- organizar as opções de seleção-->

                <div class="child child-1"> <!-- organizar cada filho -->

                    <h4>Mensal</h4>
                    <p>Inserir recebimentos ou despesas e visualizar<br> em gráficos o resumo mensal.</p>
                    <a class="btn btn-1" href="./mensal.php">VISUALIZAR</a>

                </div>

                <div class="child child-2"> <!-- organizar cada filho-->

                    <h4>Anual</h4>
                    <p>Visualizar comparação em gráficos dos<br> meses do ano de 2024.</p>
                    <a class="btn btn-2" href="./anual.php">VISUALIZAR</a>

                </div>

            </div> <!-- fim da organização de seleção de mês/anual-->

        </section>


    </body>

</html>
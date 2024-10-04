<?php

// não deixar a pessoa entrar sem antes ter logado no sistema
session_start(); // Iniciar a sessão

ob_start(); // Limpar o buffer de saída

// Definir um fuso horario padrao
date_default_timezone_set('America/Sao_Paulo');

// Acessar o IF quando o usuário não estão logado e redireciona para página de login
if((!isset($_SESSION['id'])) and (!isset($_SESSION['usuario'])) and (!isset($_SESSION['codigo_autenticacao']))) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário realizar o login para acessar a página!</p>";

    // Redirecionar o usuário
    header("Location: /project_Santos_Dinelli/login/index.php");

    // Pausar o processamento
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../style/layout-header.css">
    <link rel="stylesheet" href="../style/home.css">
    <link rel="shortcut icon" href="../images/icons/logo.ico" type="image/x-icon">

</head>

    <body>
        
        <header class="header adicionando uma palavra"> <!-- começo menu fixo no topo -->
        
            <nav class="menu-lateral"> <!-- primeiro item do menu -->

                <input type="checkbox" class="fake-tres-linhas">
                <div><img class="tres-linhas" src="../images/menu-tres-linhas.png" alt="menu de três linhas"></div>

                <ul>
                    <li><a class="link" href="./home.php">ÍNICIO</a></li>
                    <li><a class="link" href="./agenda.php">AGENDA</a></li>
                    <li><a class="link" href="./finance.php">FINANCEIRO</a></li>
                    <li><a class="link" href="./client.php">CLIENTES</a></li>
                    <li><a class="link" href="https://WA.me/+5511947295062/?text=Olá, preciso de ajuda com o software." target="_blank">SUPORTE</a></li>
                    <li><a class="link" href="../../login/sair.php">SAIR</a></li>
                </ul>

            </nav>

            <nav> <!-- começar com uma nav para definir os itens do menu-->

                <ul class="menu-fixo"> <!-- começo dos itens do menu-->

                    <li><a class="link" href="./agenda.php">AGENDA</a></li>
                    <li><a class="link" href="./finance.php">FINANCEIRO</a></li>
                    <li><a class="link" href="./client.php">CLIENTES</a></li>

                </ul>

            </nav>

            <nav> <!-- finalizar com a logo da empresa na direita-->

                <a href="https://www.santosedinelli.com.br/" target="_blank">
                <img class="logo" src="../images/santos-dinelli.png"  alt="logo da empresa"></a>
    
            </nav> <!-- final da div da logo-->

        </header> <!-- fim header fixo -->

        <section>
            <div class="canvas">
                <div class="chart">
                    <canvas id="inicial"></canvas>
                </div>
            </div>
        </section>


    </body>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="../js/inicial.js"></script>

</html>

<?php
session_start();

$host = "localhost";
$dbname = "santos_dinelli";
$user = "root";
$pass = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit;
}

    $stmt = $conn->prepare($query);
    
    // Adiciona o parâmetro de pesquisa com o "%" para procurar qualquer ocorrência
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
    
    // Executa a consulta
    $stmt->execute();
    
    // Retorna os resultados
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Inicializa o array de clientes e verifica se há uma consulta de pesquisa
$clientes = [];
$searchTerm = "";
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $clientes = searchClientes($conn, $searchTerm);
} else {
    $query = "SELECT * FROM clientes";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Filtra os clientes por tipo de pessoa
$clientes_filtrados = ['fisicos' => [], 'juridicos' => []];
foreach ($clientes as $cliente) {

    }
}

// Função para obter eventos de um cliente
function getClientEvents($conn, $id_cliente) {
    $query = "SELECT * FROM events WHERE id_cliente = :id_cliente";  // Alterado para "events"
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id_cliente', $id_cliente, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$query = "SELECT * FROM events WHERE id_cliente = :id_cliente";  // Alterado para "events"

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../style/clientes/pesquisar.css">
    <link rel="stylesheet" href="../../style/clientes/visualizar.css">
    <link rel="stylesheet" href="../../style/layout-header.css">
    <link rel="shortcut icon" href="../../images/icons/logo.ico" type="image/x-icon">
    <title>Visualizar Clientes</title>
    <style>
        .cliente-section {
            display: none;
        }
        .visible {
            display: block;
        }
    </style>
</head>
<body>

<header class="header"> <!-- começo menu fixo no topo -->
            
            <nav class="menu-lateral"> <!-- primeiro item do menu -->

                <input type="checkbox" class="fake-tres-linhas">
                <div><img class="tres-linhas" src="../../images/menu-tres-linhas.png" alt="menu de três linhas"></div>

                <ul>
                    <li><a class="link" href="../../pages/home.php">ÍNICIO</a></li>
                    <li><a class="link" href="../../pages/agenda.php">AGENDA</a></li>
                    <li><a class="link" href="../../pages/finance.php">FINANCEIRO</a></li>
                    <li><a class="link" href="../../pages/client.php">CLIENTES</a></li>
                    <li><a class="link" href="https://WA.me/+5511947295062/?text=Olá, preciso de ajuda com o software." target="_blank">SUPORTE</a></li>
                    <li><a class="link" href="../../../login/sair.php">SAIR</a></li>
                </ul>

            </nav>

            <nav> <!-- começar com uma nav para definir os itens do menu-->

                <ul class="menu-fixo"> <!-- começo dos itens do menu-->

                    <li><a class="link" href="../../pages/agenda.php">AGENDA</a></li>
                    <li><a class="link" href="../../pages/finance.php">FINANCEIRO</a></li>
                    <li><a class="link" href="../../pages/client.php">CLIENTES</a></li>

                </ul>

            </nav>

            <nav> <!-- finalizar com a logo da empresa na direita-->



            </nav> <!-- final da div da logo-->

        </header> <!-- fim header fixo -->

<div class="container-search-form">
    <form class="search-form" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label class="label-form" for="search">Pesquisar clientes:</label>
        <input type="text" id="search" name="search" placeholder="Nome, CPF, razão social, CNPJ" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit">Pesquisar</button>
    </form>
</div>

<div class="container-search-form">
   
    <div class="search-form" style="height: 94px; margin-top: -130px">
    
        <!-- Botões de alternância entre clientes físicos, jurídicos e ambos -->
        <button class="search-form" style="width: 170px" onclick="toggleClientes('fisicos')">Clientes Físicos</button>
        <button class="search-form" style="width: 170px" onclick="toggleClientes('juridicos')">Clientes Jurídicos</button>
        <button class="search-form" style="width: 170px" onclick="toggleClientes('ambos')">Mostrar Ambos</button>
      
    </div>    
</div>

</script>

</body>
</html>

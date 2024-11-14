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

// Função para pesquisar clientes
function searchClientes($conn, $searchTerm) {
    $query = "SELECT * FROM clientes WHERE 
              email_cliente LIKE :searchTerm 
              OR telefone LIKE :searchTerm
              OR cpf_cliente LIKE :searchTerm
              OR email_cliente_pj LIKE :searchTerm
              OR telefone_pj LIKE :searchTerm
              OR cnpj LIKE :searchTerm
              OR nome_cliente LIKE :searchTerm
              OR razao_social LIKE :searchTerm";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
    $stmt->execute();
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
    if ($cliente['tipo_pessoa'] == 1) {
        $clientes_filtrados['fisicos'][] = $cliente;
    } elseif ($cliente['tipo_pessoa'] == 2) {
        $clientes_filtrados['juridicos'][] = $cliente;
    }
}
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

                <a href="https://www.santosedinelli.com target="_blank">
                <img class="logo" src="../../images/santos-dinelli.png"  alt="logo da empresa"></a>

            </nav> <!-- final da div da logo-->

        </header> <!-- fim header fixo -->

<div class="container-search-form">
    <form class="search-form" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label class="label-form" for="search">Pesquisar clientes:</label>
        <input type="text" id="search" name="search" placeholder="Nome, email, CPF, razão social, CNPJ" value="<?php echo htmlspecialchars($searchTerm); ?>">
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

<!-- Seção de Clientes Físicos -->
<div id="clientes-fisicos" class="cliente-section" style="margin-top: -100px">
    <h2>Clientes Físicos</h2>
    <?php foreach ($clientes_filtrados['fisicos'] as $cliente): ?>
        <div class="cliente">
            <h3><?php echo htmlspecialchars($cliente['nome_cliente'] ?? ''); ?></h3>
            <p>Email: <?php echo htmlspecialchars($cliente['email_cliente'] ?? ''); ?></p>
            <p>Telefone: <?php echo htmlspecialchars($cliente['telefone'] ?? ''); ?></p>
            <p>CPF: <?php echo htmlspecialchars($cliente['cpf_cliente'] ?? ''); ?></p>
            <p>Endereço: <?php echo htmlspecialchars($cliente['endereco'] ?? ''); ?></p>
        </div>
    <?php endforeach; ?>
</div>

<!-- Seção de Clientes Jurídicos -->
<div id="clientes-juridicos" class="cliente-section" style="margin-top: -100px">
    <h2>Clientes Jurídicos</h2>
    <?php foreach ($clientes_filtrados['juridicos'] as $cliente): ?>
        <div class="cliente">
            <h3><?php echo htmlspecialchars($cliente['razao_social'] ?? ''); ?></h3>
            <p>Email: <?php echo htmlspecialchars($cliente['email_cliente_pj'] ?? ''); ?></p>
            <p>Telefone: <?php echo htmlspecialchars($cliente['telefone_pj'] ?? ''); ?></p>
            <p>CNPJ: <?php echo htmlspecialchars($cliente['cnpj'] ?? ''); ?></p>
            <p>Endereço: <?php echo htmlspecialchars($cliente['endereco_pj'] ?? ''); ?></p>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function toggleClientes(tipo) {
        const fisicos = document.getElementById('clientes-fisicos');
        const juridicos = document.getElementById('clientes-juridicos');

        if (tipo === 'fisicos') {
            fisicos.classList.add('visible');
            juridicos.classList.remove('visible');
        } else if (tipo === 'juridicos') {
            juridicos.classList.add('visible');
            fisicos.classList.remove('visible');
        } else if (tipo === 'ambos') {
            fisicos.classList.add('visible');
            juridicos.classList.add('visible');
        }
    }

    // Exibe os clientes físicos ao carregar a página
    toggleClientes('fisicos');
</script>

</body>
</html>

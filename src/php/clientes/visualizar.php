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

// Consultar os dados da tabela clientes
$query = "SELECT * FROM clientes";
$stmt = $conn->prepare($query);
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Função para pesquisar clientes
function searchClientes($conn, $searchTerm) {
    $query = "SELECT * FROM clientes WHERE 
              nome_cliente LIKE :searchTerm 
              OR razao_social LIKE :searchTerm
              OR cpf_cliente LIKE :searchTerm
              OR cnpj LIKE :searchTerm";
    
    // Prepare a consulta SQL
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
    // Verifica se a chave 'tipo_pessoa' existe
    if (isset($cliente['tipo_pessoa'])) {
        if ($cliente['tipo_pessoa'] == 1) {
            $clientes_filtrados['fisicos'][] = $cliente;
        } elseif ($cliente['tipo_pessoa'] == 2) {
            $clientes_filtrados['juridicos'][] = $cliente;
        }
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
</head>
<body>

<header class="header"> <!-- começo menu fixo no topo -->
        
    <nav class="menu-lateral"> <!-- primeiro item do menu -->

        <input type="checkbox" class="fake-tres-linhas">
        <div><img class="tres-linhas" src="../../images/menu-tres-linhas.png" alt="menu de três linhas"></div>

        <ul>
            <li><a class="link" href="../../pages/home.php">ÍNICIO</a></li>
            <li><a class="link" href="../../pages/agenda.php">AGENDA</a></li>
            <li><a class="link" href="../../pages/validar_codigo_financeiro.php">FINANCEIRO</a></li>
            <li><a class="link" href="../../pages/client.php">CLIENTES</a></li>
            <li><a class="link" href="https://WA.me/+5511947295062/?text=Olá, preciso de ajuda com o software." target="_blank">SUPORTE</a></li>
            <li><a class="link" href="../../../login/sair.php">SAIR</a></li>
        </ul>

    </nav>

    <nav> <!-- começar com uma nav para definir os itens do menu-->

        <ul class="menu-fixo"> <!-- começo dos itens do menu-->

            <li><a class="link" style="margin-left: 18px;" href="../../pages/agenda.php">AGENDA</a></li>
            <li><a class="link" href="../../pages/validar_codigo_financeiro.php">FINANCEIRO</a></li>
            <li><a class="link" href="../../pages/client.php">CLIENTES</a></li>

        </ul>

    </nav>

    <nav> <!-- finalizar com a logo da empresa na direita-->

                <a href="https://www.santosedinelli.com.br" target="_blank">
                <img class="logo" src="../../images/santos-dinelli.png"  alt="logo da empresa"></a>

    </nav> <!-- final da div da logo-->

</header> <!-- fim header fixo -->

<div class="container-search-form">
    <form class="search-form" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label class="label-form" for="search">Pesquisar clientes:</label>
        <input type="text" id="search" name="search" placeholder="Nome, CPF, razão social, CNPJ" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit">Pesquisar</button>
    </form>
</div>

<h2>Clientes Físicos</h2>

<?php foreach ($clientes_filtrados['fisicos'] as $cliente): ?>
    <div class="cliente">
        <h3><?php echo htmlspecialchars($cliente['nome_cliente'] ?? ''); ?></h3>
        <p>Email: <?php echo htmlspecialchars($cliente['email_cliente'] ?? ''); ?></p>
        <p>Telefone: <?php echo htmlspecialchars($cliente['telefone'] ?? ''); ?></p>
        <p>CPF: <?php echo htmlspecialchars($cliente['cpf_cliente'] ?? ''); ?></p>
        <p>Endereço: <?php echo htmlspecialchars($cliente['endereco'] ?? ''); ?></p>

        <h4>Serviços Agendados</h4>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Serviço</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $events = getClientEvents($conn, $cliente['id']);
                foreach ($events as $event): 
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['title']); ?></td>
                        <td><?php echo htmlspecialchars($event['start']); ?></td>
                        <td><?php echo htmlspecialchars($event['end']); ?></td>
                        <td><?php echo htmlspecialchars($event['servico']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>

<h2>Clientes Jurídicos</h2>
<?php foreach ($clientes_filtrados['juridicos'] as $cliente): ?>
    <div class="cliente">
        <h3><?php echo htmlspecialchars($cliente['razao_social'] ?? ''); ?></h3>
        <p>Email: <?php echo htmlspecialchars($cliente['email_cliente_pj'] ?? ''); ?></p>
        <p>Telefone: <?php echo htmlspecialchars($cliente['telefone_pj'] ?? ''); ?></p>
        <p>CNPJ: <?php echo htmlspecialchars($cliente['cnpj'] ?? ''); ?></p>
        <p>Endereço: <?php echo htmlspecialchars($cliente['endereco_pj'] ?? ''); ?></p>

        <h4>Serviços Agendados</h4>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Serviço</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $events = getClientEvents($conn, $cliente['id']);
                foreach ($events as $event): 
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['title']); ?></td>
                        <td><?php echo htmlspecialchars($event['start']); ?></td>
                        <td><?php echo htmlspecialchars($event['end']); ?></td>
                        <td><?php echo htmlspecialchars($event['servico']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>

<script>
    function toggleClientes(tipo) {
        // Função para alternar entre mostrar físicos, jurídicos ou ambos
    }
</script>

</body>
</html>

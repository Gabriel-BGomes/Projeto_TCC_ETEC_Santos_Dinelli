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

// Função para buscar eventos de um cliente
function getClientEvents($conn, $clientId) {
    $query = "SELECT * FROM events WHERE id_cliente = :id_cliente";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_cliente', $clientId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Nova função para pesquisar clientes
function searchClientes($conn, $searchTerm) {
    $query = "SELECT * FROM clientes WHERE nome_cliente LIKE :searchTerm OR email_cliente LIKE :searchTerm OR cpf_cliente LIKE :searchTerm OR razao_social LIKE :searchTerm OR email_cliente_pj LIKE :searchTerm OR cnpj LIKE :searchTerm";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Verificar se há uma consulta de pesquisa
$searchTerm = "";
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $clientes_filtrados = searchClientes($conn, $searchTerm);
} else {
    $clientes_filtrados = $clientes;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../style/clientes/pesquisar.css">
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
            <li><a class="link" href="../../pages/finance.php">FINANCEIRO</a></li>
            <li><a class="link" href="../../pages/client.php">CLIENTES</a></li>
            <li><a class="link" href="https://WA.me/+5511947295062/?text=Olá, preciso de ajuda com o software." target="_blank">SUPORTE</a></li>
            <li><a class="link" href="../../../login/sair.php">SAIR</a></li>
        </ul>

    </nav>

    <nav> <!-- começar com uma nav para definir os itens do menu-->

        <ul class="menu-fixo"> <!-- começo dos itens do menu-->

            <li><a class="link" style="margin-left: 18px;" href="../../pages/agenda.php">AGENDA</a></li>
            <li><a class="link" href="../../pages/finance.php">FINANCEIRO</a></li>
            <li><a class="link" href="../../pages/client.php">CLIENTES</a></li>

        </ul>

    </nav>

    <nav> <!-- finalizar com a logo da empresa na direita-->

        <a href="https://www.santosedinelli.com target="_blank">
        <img class="logo" src="../../images/santos-dinelli.png"  alt="logo da empresa"></a>

    </nav> <!-- final da div da logo-->

</header> <!-- fim header fixo -->

<!-- Formulário de pesquisa -->
<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="search">Pesquisar clientes:</label>
    <input type="text" id="search" name="search" placeholder="Nome, email, CPF, razão social, CNPJ..." value="<?php echo htmlspecialchars($searchTerm); ?>">
    <button type="submit">Pesquisar</button>
</form>

<h2>Clientes Físicos</h2>

<?php foreach ($clientes_filtrados as $cliente): ?>
    <?php if ($cliente['tipo_pessoa'] == 1): ?>
        <div class="cliente">
            <h3><?php echo htmlspecialchars($cliente['nome_cliente'] ?? ''); ?></h3>
            <p>Email: <?php echo htmlspecialchars($cliente['email_cliente'] ?? ''); ?></p>
            <p>CPF: <?php echo htmlspecialchars($cliente['cpf_cliente'] ?? ''); ?></p>
            <!-- Adicione outros campos conforme necessário -->

            <h4>Eventos Agendados</h4>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Data Início</th>
                        <th>Data Fim</th>
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
    <?php endif; ?>
<?php endforeach; ?>

<h2>Clientes Jurídicos</h2>
<?php foreach ($clientes_filtrados as $cliente): ?>
    <?php if ($cliente['tipo_pessoa'] == 2): ?>
        <div class="cliente">
            <h3><?php echo htmlspecialchars($cliente['razao_social'] ?? ''); ?></h3>
            <p>Email: <?php echo htmlspecialchars($cliente['email_cliente_pj'] ?? ''); ?></p>
            <p>CNPJ: <?php echo htmlspecialchars($cliente['cnpj'] ?? ''); ?></p>
            <!-- Adicione outros campos conforme necessário -->

            <h4>Eventos Agendados</h4>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Data Início</th>
                        <th>Data Fim</th>
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
    <?php endif; ?>
<?php endforeach; ?>
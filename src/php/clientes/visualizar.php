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
?>

<style>

    /* Estilos globais */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

header {
    background-color: #007bff;
    color: white;
    padding: 20px;
    text-align: center;
    margin-bottom: 20px;
}

h1, h2 {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

h1 {
    font-size: 2.5em;
}

h2 {
    color: #007bff;
    font-size: 2em;
    margin-top: 40px;
}

/* Estilos para a lista de clientes */
.cliente {
    background-color: white;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.cliente h3 {
    font-size: 1.8em;
    color: #333;
    margin-bottom: 10px;
}

.cliente p {
    font-size: 1.2em;
    color: #555;
    margin-bottom: 8px;
}

/* Estilos para a tabela de eventos */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    margin-bottom: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
    color: #333;
    font-weight: bold;
}

td {
    background-color: #fff;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Estilos para o rodapé de eventos */
h4 {
    color: #007bff;
    font-size: 1.5em;
    margin-top: 20px;
}

/* Adicionando um efeito hover */
table tr:hover {
    background-color: #f1f1f1;
}

</style>


<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
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

    <h2>Pessoas Físicas</h2>
    <?php foreach ($clientes as $cliente): ?>
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

    <h2>Pessoas Jurídicas</h2>
    <?php foreach ($clientes as $cliente): ?>
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
</body>
</html>
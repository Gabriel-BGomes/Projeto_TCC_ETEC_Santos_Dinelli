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

// Função para formatar a data para o padrão brasileiro
function formatarData($data) {
    return date('d/m/Y H:i', strtotime($data));
}
?>


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

                <li><a class="link" style="margin-left: 10px;" href="../../pages/agenda.php">AGENDA</a></li>
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

                <h4>Serviços Agendados</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Serviço</th>
                            <th>Data Início</th>
                            <th>Data Fim</th>
                            <th>Tipo Serviço</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $events = getClientEvents($conn, $cliente['id']);
                        foreach ($events as $event): 
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event['title']); ?></td>
                                <td><?php echo formatarData($event['start']); ?></td>
                                <td><?php echo formatarData($event['end']); ?></td>
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

                <h4>Serviçost Agendados</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Serviço</th>
                            <th>Data Início</th>
                            <th>Data Fim</th>
                            <th>Tipo Serviço</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $events = getClientEvents($conn, $cliente['id']);
                        foreach ($events as $event): 
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event['title']); ?></td>
                                <td><?php echo formatarData($event['start']); ?></td>
                                <td><?php echo formatarData($event['end']); ?></td>
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
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

<?php

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

// Função para buscar eventos do cliente
function getClientEvents($conn, $id_cliente) {
    try {
        $query = "SELECT * FROM events WHERE id_cliente = :id_cliente ORDER BY start ASC";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// Função para pesquisar clientes
function searchClientes($conn, $searchTerm) {
    $query = "SELECT * FROM clientes WHERE 
              nome_cliente LIKE :searchTerm 
              OR razao_social LIKE :searchTerm
              OR cpf_cliente LIKE :searchTerm
              OR cnpj LIKE :searchTerm";
    
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para excluir cliente
function deleteCliente($conn, $id) {
    try {
        // Primeiro exclui os eventos relacionados
        $queryEvents = "DELETE FROM events WHERE id_cliente = :id";
        $stmtEvents = $conn->prepare($queryEvents);
        $stmtEvents->bindValue(':id', $id, PDO::PARAM_INT);
        $stmtEvents->execute();

        // Depois exclui o cliente
        $queryCliente = "DELETE FROM clientes WHERE id = :id";
        $stmtCliente = $conn->prepare($queryCliente);
        $stmtCliente->bindValue(':id', $id, PDO::PARAM_INT);
        $stmtCliente->execute();
        
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// Processar exclusão se solicitado
if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    if (deleteCliente($conn, $_POST['id'])) {
        header("Location: /project_Santos_Dinelli/src/php/clientes/visualizar.php?msg=success");
    } else {
        header("Location: /project_Santos_Dinelli/src/php/clientes/visualizar.php?msg=success");
    }
    exit; // Para garantir que o script não continua após o redirecionamento
}

if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'success') {
        echo "<script>alert('Cliente excluído com sucesso!');</script>";
    } elseif ($_GET['msg'] == 'error') {
        echo "<script>alert('Erro ao excluir o cliente.');</script>";
    }
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
    if (isset($cliente['tipo_pessoa'])) {
        if ($cliente['tipo_pessoa'] == 1) {
            $clientes_filtrados['fisicos'][] = $cliente;
        } elseif ($cliente['tipo_pessoa'] == 2) {
            $clientes_filtrados['juridicos'][] = $cliente;
        }
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
        .acoes {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        .btn-editar, .btn-excluir {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            text-transform: uppercase;
            font-size: 0.9em;
            transition: all 0.3s ease;
            display: inline-block;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .btn-editar {
            background-color: #4CAF50;
            color: white;
        }

        .btn-editar:hover {
            background-color: #45a049;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

        .btn-excluir {
            background-color: #f44336;
            color: white;
        }

        .btn-excluir:hover {
            background-color: #d32f2f;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

        /* New styles for filter buttons */
        .filter-buttons {
            display: flex;
            justify-content: center;
            margin: 20px 0;
            gap: 10px;

        }

        .filter-btn {
            width: 200px;
            height: 60px;
            padding: 10px 20px;
            background-color: #228d02;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 15px;
            transition: background-color 0.3s ease;
            font-size: 15px;
            background-color: #45a528;
        }

        .filter-btn:hover {
            background-color: #228d02;
        }

        .filter-btn.active {
            background-color: #145400;;
        }

        .msg {
            width: 95vw;
            text-align: center;
        }

    </style>
</head>
<body>

<header class="header">
    <nav class="menu-lateral">
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

    <nav>
        <ul class="menu-fixo">
            <li><a class="link" style="margin-left: 18px;" href="../../pages/agenda.php">AGENDA</a></li>
            <li><a class="link" href="../../pages/validar_codigo_financeiro.php">FINANCEIRO</a></li>
            <li><a class="link" href="../../pages/client.php">CLIENTES</a></li>
        </ul>
    </nav>

    <nav>
        <a href="https://www.santosedinelli.com.br" target="_blank">
        <img class="logo" src="../../images/santos-dinelli.png" alt="logo da empresa"></a>
    </nav>
</header>

<span id="msg" class="msg"></span>

<div class="container-search-form">
    <form class="search-form" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label class="label-form" for="search">Pesquisar clientes:</label>
        <input type="text" id="search" name="search" placeholder="Nome, CPF, razão social, CNPJ" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit">Pesquisar</button>
    </form>
</div>

<!-- New filter buttons -->
<div class="filter-buttons">
    <button class="filter-btn" data-filter="all" onclick="filterClients('all')">Todos os Clientes</button>
    <button class="filter-btn" data-filter="fisicos" onclick="filterClients('fisicos')">Clientes Físicos</button>
    <button class="filter-btn" data-filter="juridicos" onclick="filterClients('juridicos')">Clientes Jurídicos</button>
</div>


<h2 id="h2-fisicos">Clientes Físicos</h2>

<?php foreach ($clientes_filtrados['fisicos'] as $cliente): ?>
    <div class="cliente cliente-fisico">
        <h3><?php echo htmlspecialchars($cliente['nome_cliente'] ?? ''); ?></h3>
        <p>Email: <?php echo htmlspecialchars($cliente['email_cliente'] ?? ''); ?></p>
        <p>Telefone: <?php echo htmlspecialchars($cliente['telefone'] ?? ''); ?></p>
        <p>CPF: <?php echo htmlspecialchars($cliente['cpf_cliente'] ?? ''); ?></p>
        <p>Endereço: <?php echo htmlspecialchars($cliente['endereco'] ?? ''); ?></p>
        <p>Número: <?php echo htmlspecialchars($cliente['numero'] ?? ''); ?></p>
        
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
        
        <div class="acoes">
            <a href="../clientes/editar.php?id=<?php echo $cliente['id']; ?>" class="btn-editar">Editar</a>
            <form method="post" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
                <button type="submit" class="btn-excluir">Excluir</button>
            </form>
        </div>
    </div>
<?php endforeach; ?>

<h2 id="h2-juridicos">Clientes Jurídicos</h2>
<?php foreach ($clientes_filtrados['juridicos'] as $cliente): ?>
    <div class="cliente cliente-juridico">
        <h3><?php echo htmlspecialchars($cliente['razao_social'] ?? ''); ?></h3>
        <p>Email: <?php echo htmlspecialchars($cliente['email_cliente_pj'] ?? ''); ?></p>
        <p>Telefone: <?php echo htmlspecialchars($cliente['telefone_pj'] ?? ''); ?></p>
        <p>CNPJ: <?php echo htmlspecialchars($cliente['cnpj'] ?? ''); ?></p>
        <p>Endereço: <?php echo htmlspecialchars($cliente['endereco_pj'] ?? ''); ?></p>
        <p>Número: <?php echo htmlspecialchars($cliente['numero_pj'] ?? ''); ?></p>

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
        
        <div class="acoes">
            <a href="../clientes/editar.php?id=<?php echo $cliente['id']; ?>" class="btn-editar">Editar</a>
            <form method="post" style="display: inline;" id="confirm" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
                <button type="submit" class="btn-excluir">Excluir</button>
            </form>
        </div>
    </div>
<?php endforeach; ?>

<script>
function filterClients(filter) {
    // Remove active class from all buttons
    const buttons = document.querySelectorAll('.filter-btn');
    buttons.forEach(btn => btn.classList.remove('active'));

    // Add active class to clicked button
    const activeButton = document.querySelector(`.filter-btn[data-filter="${filter}"]`);
    if (activeButton) activeButton.classList.add('active');

    // Get all client divs
    const fisicos = document.querySelectorAll('.cliente-fisico');
    const juridicos = document.querySelectorAll('.cliente-juridico');
    const h2Fisicos = document.getElementById('h2-fisicos');
        const h2Juridicos = document.getElementById('h2-juridicos');

        if (filter === 'all') {
            fisicos.forEach(client => client.style.display = 'block');
            juridicos.forEach(client => client.style.display = 'block');
            h2Fisicos.style.display = 'block';
            h2Juridicos.style.display = 'block';
        } else if (filter === 'fisicos') {
            fisicos.forEach(client => client.style.display = 'block');
            juridicos.forEach(client => client.style.display = 'none');
            h2Fisicos.style.display = 'block';
            h2Juridicos.style.display = 'none';
        } else if (filter === 'juridicos') {
            fisicos.forEach(client => client.style.display = 'none');
            juridicos.forEach(client => client.style.display = 'block');
            h2Fisicos.style.display = 'none';
            h2Juridicos.style.display = 'block';
        }
    }

    // Opcional: Definir o estado inicial com base na URL ou padrão
    document.addEventListener('DOMContentLoaded', () => {
        // Verifica se há um filtro definido na URL
        const urlParams = new URLSearchParams(window.location.search);
        const filter = urlParams.get('filter') || 'all';
        filterClients(filter);
    });

    // Função para remover a mensagem após 3 segundos
    function removerMsg() {
        setTimeout(() => {
            document.getElementById('msg').innerHTML = "";
        }, 3000);
    }

    const confirmacao = window.getElementById('confirm');
    msgView = document.getElementById('msg').innerHTML = "";

    if (confirmacao) {
        msgView = document.getElementById('msg').innerHTML = `<div class="alert alert-success" role="alert">Cliente Excluído</div>`;
        removerMsg();
    } 

    

    </script>

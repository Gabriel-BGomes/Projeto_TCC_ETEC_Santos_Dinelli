<?php
// Exibir erros (útil para depuração)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configurações de conexão com o banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "santos_dinelli";
$port = 3306;

try {
    // Conectar ao banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Retornar erro de conexão em formato JSON
    http_response_code(500);
    echo json_encode([
        'status' => false,
        'msg' => "Erro: Conexão com o banco de dados não realizada. Erro: " . $e->getMessage()
    ]);
    exit;
}

// Definir o timezone e obter a data de hoje
date_default_timezone_set('America/Sao_Paulo');
$dataHoje = date('Y-m-d');

try {
    // Query para buscar os eventos do dia
    $query = $pdo->prepare("
        SELECT 
            e.id, 
            e.title, 
            e.start, 
            e.end, 
            e.servico,
            COALESCE(c.nome_cliente, c.razao_social) AS cliente_nome, 
            COALESCE(c.endereco, c.endereco_pj) AS cliente_endereco
        FROM events e
        INNER JOIN clientes c ON e.id_cliente = c.id
        WHERE DATE(e.start) = :dataHoje
    ");
    $query->bindParam(':dataHoje', $dataHoje);
    $query->execute();

    // Obter os resultados
    $eventos = $query->fetchAll(PDO::FETCH_ASSOC);

    // Verificar e retornar os eventos em formato JSON
    if (empty($eventos)) {
        echo json_encode([
            'status' => false,
            'msg' => 'Nenhum serviço encontrado para hoje.'
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => true,
            'msg' => 'Serviços encontrados.',
            'data' => $eventos
        ]);
    }
} catch (PDOException $e) {
    // Retornar erro em formato JSON
    http_response_code(500);
    echo json_encode([
        'status' => false,
        'msg' => 'Erro ao buscar serviços: ' . $e->getMessage()
    ]);
}

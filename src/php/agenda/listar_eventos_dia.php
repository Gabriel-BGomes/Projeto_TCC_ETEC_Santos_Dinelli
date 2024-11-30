<?php
// Exibir erros (útil para depuração)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar ao banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "santos_dinelli";
$port = 3306;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['status' => false, 'msg' => "Erro: Conexão com banco de dados não realizada. Erro: " . $e->getMessage()]));
}

// Pegar a data de hoje
date_default_timezone_set('America/Sao_Paulo');
$dataHoje = date('Y-m-d');

// Buscar os eventos do dia no banco de dados
try {
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

    $eventos = $query->fetchAll(PDO::FETCH_ASSOC);

    // Verificar se há eventos e retornar a resposta
    if (!$eventos) {
        echo json_encode([
            'status' => false,
            'msg' => 'Nenhum serviço encontrado para hoje.'
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode($eventos);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => false, 'msg' => 'Erro ao buscar serviço: ' . $e->getMessage()]);
}



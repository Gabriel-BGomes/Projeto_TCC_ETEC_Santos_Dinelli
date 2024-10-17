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
$dataHoje = date('Y-m-d');

// Buscar os eventos do dia no banco de dados
try {
    $query = $pdo->prepare("SELECT id, title, start, end, servico FROM events WHERE DATE(start) = :dataHoje");
    $query->bindParam(':dataHoje', $dataHoje);
    $query->execute();

    $eventos = $query->fetchAll(PDO::FETCH_ASSOC);

    // Verificar se há eventos e retornar a resposta
    if (!$eventos) {
        echo json_encode(['status' => false, 'msg' => 'Nenhum evento encontrado para hoje.']);
    } else {
        header('Content-Type: application/json');
        echo json_encode($eventos);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => false, 'msg' => 'Erro ao buscar eventos: ' . $e->getMessage()]);
}


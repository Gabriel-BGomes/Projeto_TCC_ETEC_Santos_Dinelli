<?php
// Configuração do banco de dados
$servername = "localhost"; // Ou o IP do servidor
$username = "root"; // Nome de usuário do banco de dados
$password = ""; // Senha do banco de dados
$dbname = "santos_dinelli"; // Nome do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consultar os dados da tabela financas
$sql = "SELECT mes, recebimento, despesa FROM financas";
$result = $conn->query($sql);

// Preparar um array para armazenar os dados
$dados = array();

if ($result->num_rows > 0) {
    // Buscar cada linha de dados
    while ($row = $result->fetch_assoc()) {
        $dados[] = $row;
    }
}

// Definir o cabeçalho para JSON
header('Content-Type: application/json');

// Retornar os dados como JSON
echo json_encode($dados);

// Fechar conexão
$conn->close();
?>
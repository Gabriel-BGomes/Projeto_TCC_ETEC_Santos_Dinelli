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

// Recebe os dados do POST
$recebimento = isset($_POST['recebimento']) ? intval($_POST['recebimento']) : 0;
$despesa = isset($_POST['despesa']) ? intval($_POST['despesa']) : 0;
$mes = isset($_POST['mes']) ? $conn->real_escape_string($_POST['mes']) : '';
$action = isset($_POST['action']) ? ($_POST['action']) : 0;

// Verifica se já existe um registro para o mês
$sql = "SELECT * FROM financas WHERE mes = '$mes'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Se já existe, atualiza os valores
    $row = $result->fetch_assoc();

    echo $action;

    if ($action == 'insert') {

        $novo_recebimento = intval($row['recebimento']) + $recebimento;
        $nova_despesa = intval($row['despesa']) + $despesa;

        $update_sql = "UPDATE financas SET recebimento = $novo_recebimento, despesa = $nova_despesa WHERE mes = '$mes'";
        if ($conn->query($update_sql) === TRUE) {
            echo "\nValores somados com sucesso.";
        } else {
            echo "Erro ao atualizar: " . $conn->error;
        }

    } else if ($action == 'edit') {

        $update_sql = "UPDATE financas SET recebimento = $recebimento, despesa = $despesa WHERE mes = '$mes'";
        if ($conn->query($update_sql) === TRUE) {
            echo "\nValores editados com sucesso.";
        } else {
            echo "Erro ao atualizar: " . $conn->error;
        }

    } else if ($action == 'remove') {

        // Evitar valores negativos ao subtrair
        $novo_recebimento = intval($row['recebimento']) - $recebimento;
        $nova_despesa = intval($row['despesa']) - $despesa;

        $update_sql = "UPDATE financas SET recebimento = $novo_recebimento, despesa = $nova_despesa WHERE mes = '$mes'";
        if ($conn->query($update_sql) === TRUE) {
            echo "\nValores removidos com sucesso.";
        } else {
            echo "Erro ao atualizar: " . $conn->error;
        }
    }

} else {
    // Se não existe, insere um novo registro
    $insert_sql = "INSERT INTO financas (mes, recebimento, despesa) VALUES ('$mes', $recebimento, $despesa)";
    if ($conn->query($insert_sql) === TRUE) {
        echo "Novo registro criado com sucesso.";
    } else {
        echo "Erro ao inserir: " . $conn->error;
    }
}


// Fechar conexão
$conn->close();
?>
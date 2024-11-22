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

$cliente = null;
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM clientes WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $tipo_pessoa = $_POST['tipo_pessoa'];
    
    if ($tipo_pessoa == 1) { // Pessoa Física
        $query = "UPDATE clientes SET 
                  nome_cliente = :nome,
                  email_cliente = :email,
                  cpf_cliente = :cpf,
                  data_nascimento = :data_nascimento,
                  telefone = :telefone,
                  endereco = :endereco,
                  bairro = :bairro,
                  cep = :cep,
                  cidade = :cidade,
                  complemento = :complemento
                  WHERE id = :id";
        
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':nome', $_POST['nome_cliente']);
        $stmt->bindValue(':email', $_POST['email_cliente']);
        $stmt->bindValue(':cpf', $_POST['cpf_cliente']);
        $stmt->bindValue(':data_nascimento', $_POST['data_nascimento']);
        $stmt->bindValue(':telefone', $_POST['telefone']);
        $stmt->bindValue(':endereco', $_POST['endereco']);
        $stmt->bindValue(':bairro', $_POST['bairro']);
        $stmt->bindValue(':cep', $_POST['cep']);
        $stmt->bindValue(':cidade', $_POST['cidade']);
        $stmt->bindValue(':complemento', $_POST['complemento']);
        
    } else { // Pessoa Jurídica
        $query = "UPDATE clientes SET 
                  razao_social = :razao_social,
                  email_cliente_pj = :email_pj,
                  cnpj = :cnpj,
                  telefone_pj = :telefone_pj,
                  endereco_pj = :endereco_pj,
                  bairro_pj = :bairro_pj,
                  cep_pj = :cep_pj,
                  cidade_pj = :cidade_pj,
                  complemento_pj = :complemento_pj,
                  forma_pagamento_pj = :forma_pagamento_pj
                  WHERE id = :id";
        
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':razao_social', $_POST['razao_social']);
        $stmt->bindValue(':email_pj', $_POST['email_cliente_pj']);
        $stmt->bindValue(':cnpj', $_POST['cnpj']);
        $stmt->bindValue(':telefone_pj', $_POST['telefone_pj']);
        $stmt->bindValue(':endereco_pj', $_POST['endereco_pj']);
        $stmt->bindValue(':bairro_pj', $_POST['bairro_pj']);
        $stmt->bindValue(':cep_pj', $_POST['cep_pj']);
        $stmt->bindValue(':cidade_pj', $_POST['cidade_pj']);
        $stmt->bindValue(':complemento_pj', $_POST['complemento_pj']);
        $stmt->bindValue(':forma_pagamento_pj', $_POST['forma_pagamento_pj']);
    }
    
    $stmt->bindValue(':id', $id);
    
    try {
        $stmt->execute();
        $mensagem = "Cliente atualizado com sucesso!";
        header("Location: visualizar.php");
        exit;
    } catch (PDOException $e) {
        $mensagem = "Erro ao atualizar cliente: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="../../style/layout-header.css">
    <style>
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .mensagem {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .sucesso {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .erro {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h2>Editar Cliente</h2>
        
        <?php if ($mensagem): ?>
            <div class="mensagem <?php echo strpos($mensagem, 'sucesso') !== false ? 'sucesso' : 'erro'; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <?php if ($cliente): ?>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
                <input type="hidden" name="tipo_pessoa" value="<?php echo $cliente['tipo_pessoa']; ?>">
                
                <?php if ($cliente['tipo_pessoa'] == 1): ?>
                    <!-- Formulário Pessoa Física -->
                    <div class="form-group">
                        <label>Nome:</label>
                        <input type="text" name="nome_cliente" value="<?php echo htmlspecialchars($cliente['nome_cliente']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email_cliente" value="<?php echo htmlspecialchars($cliente['email_cliente']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>CPF:</label>
                        <input type="text" name="cpf_cliente" value="<?php echo htmlspecialchars($cliente['cpf_cliente']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Data de Nascimento:</label>
                        <input type="date" name="data_nascimento" value="<?php echo $cliente['data_nascimento']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Telefone:</label>
                        <input type="text" name="telefone" value="<?php echo htmlspecialchars($cliente['telefone']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Endereço:</label>
                        <input type="text" name="endereco" value="<?php echo htmlspecialchars($cliente['endereco']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Bairro:</label>
                        <input type="text" name="bairro" value="<?php echo htmlspecialchars($cliente['bairro']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>CEP:</label>
                        <input type="text" name="cep" value="<?php echo htmlspecialchars($cliente['cep']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Cidade:</label>
                        <input type="text" name="cidade" value="<?php echo htmlspecialchars($cliente['cidade']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Complemento:</label>
                        <input type="text" name="complemento" value="<?php echo htmlspecialchars($cliente['complemento']); ?>">
                    </div>
                    
                <?php else: ?>
                    <!-- Formulário Pessoa Jurídica -->
                    <div class="form-group">
                        <label>Razão Social:</label>
                        <input type="text" name="razao_social" value="<?php echo htmlspecialchars($cliente['razao_social']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email_cliente_pj" value="<?php echo htmlspecialchars($cliente['email_cliente_pj']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>CNPJ:</label>
                        <input type="text" name="cnpj" value="<?php echo htmlspecialchars($cliente['cnpj']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Telefone:</label>
                        <input type="text" name="telefone_pj" value="<?php echo htmlspecialchars($cliente['telefone_pj']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Endereço:</label>
                        <input type="text" name="endereco_pj" value="<?php echo htmlspecialchars($cliente['endereco_pj']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Bairro:</label>
                        <input type="text" name="bairro_pj" value="<?php echo htmlspecialchars($cliente['bairro_pj']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>CEP:</label>
                        <input type="text" name="cep_pj" value="<?php echo htmlspecialchars($cliente['cep_pj']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Cidade:</label>
                        <input type="text" name="cidade_pj" value="<?php echo htmlspecialchars($cliente['cidade_pj']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Complemento:</label>
                        <input type="text" name="complemento_pj" value="<?php echo htmlspecialchars($cliente['complemento_pj']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Forma de Pagamento:</label>
                        <input type="text" name="forma_pagamento_pj" value="<?php echo htmlspecialchars($cliente['forma_pagamento_pj']); ?>">
                    </div>
                <?php endif; ?>
                
                <button type="submit" class="btn">Atualizar Cliente</button>
                <a href="visualizar_clientes.php" class="btn" style="background-color: #666;">Cancelar</a>
            </form>
        <?php else: ?>
            <p>Cliente não encontrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>
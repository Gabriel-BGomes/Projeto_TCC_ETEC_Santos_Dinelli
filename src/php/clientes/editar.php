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
                  numero = :numero,
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
        $stmt->bindValue(':numero', $_POST['numero']);
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
                  numero_pj = :numero_pj,
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
        $stmt->bindValue(':numero_pj', $_POST['numero_pj']);
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
        :root {
    --cor-primaria: #228d02;
    --cor-secundaria: #2eab04;
    --cor-cancelar1: #FF0000;
    --cor-cancelar2: #8b0000;
    --cor-texto-escuro: #1e2249;
    --cor-fundo: #f5f7ff;
    --cor-borda: #c2e0c2;
    --sombra-suave: 0 10px 30px rgba(34, 141, 2, 0.1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

body {
    background-color: var(--cor-fundo);
    color: var(--cor-texto-escuro);
    line-height: 1.6;
}

.container {
    width: 100%;
    max-width: 900px;
    margin: 40px auto;
    background-color: white;
    border-radius: 16px;
    box-shadow: var(--sombra-suave);
    padding: 50px;
    border: 1px solid var(--cor-borda);
}

h2 {
    text-align: center;
    color: var(--cor-primaria);
    margin-bottom: 40px;
    font-size: 2.2rem;
    position: relative;
    font-weight: 700;
}

h2::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: linear-gradient(to right, var(--cor-primaria), var(--cor-secundaria));
    border-radius: 2px;
}

/* Estilos de Formulário */
.form-group {
    margin-bottom: 25px;
    position: relative;
}

label {
    display: block;
    margin-bottom: 10px;
    color: black;
    font-weight: 600;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

input[type="text"],
input[type="email"],
input[type="date"] {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid var(--cor-borda);
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    outline: none;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="date"]:focus {
    border-color: var(--cor-primaria);
    box-shadow: 0 0 0 4px rgba(34, 141, 2, 0.1);
}

/* butao atualizar */
.btn {
    display: inline-block;
    padding: 15px 30px;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
}

.btn:first-of-type {
    background: linear-gradient(135deg, var(--cor-primaria), var(--cor-secundaria));
    color: white;
    box-shadow: 0 10px 20px rgba(34, 141, 2, 0.3);
}

.btn:first-of-type:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 25px rgba(34, 141, 2, 0.4);
}

.btn:last-of-type {
    background-color: #f1f9f1;
    color: var(--cor-texto-escuro);
    margin-left: 15px;
}

.btn:last-of-type:hover {
    background-color: #e6f4e6;
}

/* butao cancelar */
.btnCancelar {
    display: inline-block;
    padding: 15px 30px;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    
}

.btnCancelar:first-of-type {
    background: linear-gradient(135deg, var(--cor-cancelar1), var(--cor-cancelar2));
    color: white;
    box-shadow: 0 10px 20px rgba(200, 34, 34, 0.3);
}

.btnCancelar:first-of-type:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 25px rgba(200, 34, 34, 0.4);
}

.btnCancelar:last-of-type {
    background-color: #f1f9f1;
    color: black;
    margin-left: 15px;
}

.btnCancelar:last-of-type:hover {
    background-color: #e6f4e6;
}

/* Estilos de Mensagem */
.mensagem {
    padding: 15px;
    margin-bottom: 30px;
    border-radius: 10px;
    text-align: center;
    font-weight: 500;
}

.sucesso {
    background-color: #e7f5f0;
    color: #1a6b3f;
    border: 1px solid #228d02;
}

.erro {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Ajustes Responsivos */
@media (max-width: 768px) {
    .container {
        width: 95%;
        padding: 30px 20px;
        margin: 20px auto;
    }

    .btn {
        display: block;
        width: 100%;
        margin-bottom: 15px;
    }

    .btn:last-of-type {
        margin-left: 0;
    }
}

/* Animações Sutis */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-group {
    animation: fadeIn 0.5s ease forwards;
    opacity: 0;
    animation-delay: calc(var(--delay) * 0.1s);
}

/* Estado de Validação */
input:required:invalid {
    border-color: #ff6b6b;
}

input:valid {
    border-color: #228d02;
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
                        <label>Número:</label>
                        <input type="text" name="numero" value="<?php echo htmlspecialchars($cliente['numero']); ?>" required>
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
                        <label>Número:</label>
                        <input type="text" name="numero_pj" value="<?php echo htmlspecialchars($cliente['numero_pj']); ?>" required>
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
                
                <button style="color: white;" type="submit" class="btn">Atualizar Cliente</button>
                <a style="color: white; text-decoration: none;" href="visualizar.php" class="btnCancelar" style="background-color: #666;">Cancelar</a>
            </form>
        <?php else: ?>
            <p>Cliente não encontrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
session_start();
ob_start();

// Verificar se é logout por timeout
$timeout = isset($_GET['timeout']) && $_GET['timeout'] === 'true';

// Limpar o cookie remember_token se existir
if (isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    
    // Limpar token no banco de dados
    $query_clear = "UPDATE usuarios SET 
                    remember_token = NULL,
                    token_expiracao = NULL 
                    WHERE remember_token = :token";
    
    include_once "./conexao.php";
    $result_clear = $conn->prepare($query_clear);
    $result_clear->bindParam(':token', $token);
    $result_clear->execute();
    
    // Remover cookie
    setcookie('remember_token', '', [
        'expires' => time() - 3600,
        'path' => '/',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
}

// Destruir todas as variáveis de sessão
unset($_SESSION['id'], $_SESSION['nome'], $_SESSION['usuario'], $_SESSION['codigo_autenticacao']);

if((!isset($_SESSION['id'])) && (!isset($_SESSION['usuario'])) && (!isset($_SESSION['codigo_autenticacao']))){
    if($timeout) {
        $_SESSION['msg'] = "<p style='color: #f00;'>Você foi desconectado por inatividade!</p>";
    } else {
        $_SESSION['msg'] = "<p style='color: green;'>Deslogado com sucesso!</p>";
    }
    
    // Se for uma requisição AJAX
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        http_response_code(200);
        exit();
    }
    
    // Redirecionar mantendo o parâmetro timeout
    if($timeout) {
        header("Location: ./index.php?timeout=true");
    } else {
        header("Location: ./index.php");
    }
    exit();
}
?>
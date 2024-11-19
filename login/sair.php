<?php
session_start();
ob_start();

// Verificar se é logout por timeout
$timeout = isset($_GET['timeout']) && $_GET['timeout'] === 'true';

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
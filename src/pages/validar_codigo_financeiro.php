<?php
session_start();
ob_start();
date_default_timezone_set('America/Sao_Paulo');
include_once "..//../login/conexao.php";

// Verificar se usuário está logado
if (!isset($_SESSION['id']) || !isset($_SESSION['usuario'])) {
    header("Location: ../../login/index.php");
    exit();
}

// Function to send JSON response
function sendJsonResponse($success, $message) {
    header('Content-Type: application/json');
    echo json_encode(['success' => $success, 'message' => $message]);
    exit();
}

// Check if it's an AJAX request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($dados['pin_financeiro'])) {
            // Busca o PIN do usuário logado
            $query_usuario = "SELECT pin_financeiro 
                            FROM usuarios 
                            WHERE id = :id 
                            LIMIT 1";

            $result_usuario = $conn->prepare($query_usuario);
            $result_usuario->bindParam(':id', $_SESSION['id']);
            $result_usuario->execute();

            if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
                $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
                
                // Verifica se o PIN digitado corresponde ao hash armazenado
                // Se o hash estiver vazio ou nulo, nega o acesso
                if (!empty($row_usuario['pin_financeiro']) && password_verify($dados['pin_financeiro'], $row_usuario['pin_financeiro'])) {
                    $_SESSION['acesso_financeiro'] = true;
                    sendJsonResponse(true, 'PIN correto! Redirecionando...');
                } else {
                    sendJsonResponse(false, 'Erro: PIN inválido ou não configurado!');
                }
            } else {
                sendJsonResponse(false, 'Erro: Usuário não encontrado.');
            }
        } else {
            sendJsonResponse(false, 'Erro: PIN não fornecido.');
        }
    } else {
        sendJsonResponse(false, 'Método de requisição inválido.');
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação PIN - Financeiro</title>
    <link rel="stylesheet" href="../style/login/validar_codigo.css">
    <link rel="stylesheet" href="../style/layout-header.css">
    <link rel="shortcut icon" href="../images/icons/logo.ico" type="image/x-icon"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>     
</head>
<body>
    <header class="header"> 
        <!-- Seu código do header permanece o mesmo -->
    </header>
    
    <div class="container-geral" style="height: calc(100vh - 70px);">
        <div class="auth-container">
            <div class="auth-header">
                <h2 style="margin-top: 15px">Digite o PIN de acesso</h2>
            </div>
        
            <div id="message" class="message"></div>
        
            <form method="POST" action="" class="auth-form" id="auth-form">
                <div class="loading-overlay" id="loadingOverlay">
                    <div class="loading-spinner"></div>
                    <div class="loading-text" id="loadingText">Validando...</div>
                </div>
                
                <div class="input-group">
                    <input type="password" name="pin_financeiro" id="verification-code" required maxlength="6">
                    <span class="highlight"></span>
                    <label for="verification-code">PIN</label>
                </div>
            
                <input type="submit" class="auth-button" name="ValPin" value="Validar" id="botaoTransicao">
            </form>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#auth-form').submit(function(e) {
            e.preventDefault();
            $('#loadingText').text('Validando...');
            $('#loadingOverlay').css('display', 'flex');
            
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    $('#loadingOverlay').css('display', 'none');
                    if (response.success) {
                        $('#loadingText').text('Redirecionando...');
                        $('#loadingOverlay').css('display', 'flex');
                        setTimeout(function() {
                            window.location.href = '../pages/finance.php';
                        }, 2000);
                    } else {
                        $('#message').text(response.message)
                                   .removeClass('success-message')
                                   .addClass('error-message')
                                   .show();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#loadingOverlay').css('display', 'none');
                    $('#message').text('Erro ao processar a solicitação. Tente novamente.')
                               .removeClass('success-message')
                               .addClass('error-message')
                               .show();
                }
            });
        });
    });
    </script>
</body>
</html>
<?php
ob_end_flush();
?>
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

// Se ainda não enviou o código, envia primeiro
if (!isset($_SESSION['codigo_enviado_financeiro'])) {
    header("Location: enviar_codigo_financeiro.php");
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
        
        if (!empty($dados['codigo_autenticacao'])) {
            $query_usuario = "SELECT id, nome, usuario, senha_usuario 
                            FROM usuarios
                            WHERE id =:id
                            AND usuario =:usuario
                            AND codigo_autenticacao =:codigo_autenticacao
                            LIMIT 1";

            $result_usuario = $conn->prepare($query_usuario);
            $result_usuario->bindParam(':id', $_SESSION['id']);
            $result_usuario->bindParam(':usuario', $_SESSION['usuario']);
            $result_usuario->bindParam(':codigo_autenticacao', $dados['codigo_autenticacao']);
            $result_usuario->execute();

            if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
                $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);

                $query_up_usuario = "UPDATE usuarios SET
                        codigo_autenticacao = NULL,
                        data_codigo_autenticacao = NULL
                        WHERE id =:id
                        LIMIT 1";

                $result_up_usuario = $conn->prepare($query_up_usuario);
                $result_up_usuario->bindParam(':id', $_SESSION['id']);
                $result_up_usuario->execute();

                $_SESSION['nome'] = $row_usuario['nome'];
                $_SESSION['codigo_autenticacao'] = true;     
                $_SESSION['acesso_financeiro'] = true;       

                sendJsonResponse(true, 'Código válido. Redirecionando...');
            } else {
                sendJsonResponse(false, 'Erro: Código inválido!');
            }
        } else {
            sendJsonResponse(false, 'Erro: Código de autenticação não fornecido.');
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
    <title>Verificação de Duas Etapas - Financeiro</title>
    <link rel="stylesheet" href="../style/login/validar_codigo.css">
    <link rel="stylesheet" href="../style/layout-header.css">
    <link rel="shortcut icon" href="../images/icons/logo.ico" type="image/x-icon"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>     
</head>
<body>

    <header class="header"> 
        <nav class="menu-lateral">
            <input type="checkbox" class="fake-tres-linhas">
            <div><img class="tres-linhas" src="../images/menu-tres-linhas.png" alt="menu de três linhas"></div>

            <ul>
                <li><a class="link" href="./home.php">ÍNICIO</a></li>
                <li><a class="link" href="./agenda.php">AGENDA</a></li>
                <li><a class="link" href="./validar_codigo_financeiro.php">FINANCEIRO</a></li>
                <li><a class="link" href="./client.php">CLIENTES</a></li>
                <li><a class="link" href="https://WA.me/+5511947295062/?text=Olá, preciso de ajuda com o software." target="_blank">SUPORTE</a></li>
                <li><a class="link" href="../../login/sair.php">SAIR</a></li>
            </ul>
        </nav>

        <nav>
            <ul class="menu-fixo">
                <li><a class="link" href="./agenda.php">AGENDA</a></li>
                <li><a class="link" href="./validar_codigo_financeiro.php">FINANCEIRO</a></li>
                <li><a class="link" href="./client.php">CLIENTES</a></li>
            </ul>
        </nav>

        <nav>
            <a href="https://www.santosedinelli.com.br/" target="_blank">
                <img class="logo" src="../images/santos-dinelli.png" alt="logo da empresa">
            </a>
        </nav>
    </header>
    
    <div class="container-geral" style="height: calc(100vh - 70px);">
        <div class="auth-container">
            <div class="auth-header">
                <h2>Digite o código enviado no E-mail cadastrado</h2>
            </div>
        
            <div id="message" class="message"></div>
        
            <form method="POST" action="" class="auth-form" id="auth-form">
                <div class="loading-overlay" id="loadingOverlay">
                    <div class="loading-spinner"></div>
                    <div class="loading-text" id="loadingText">Validando...</div>
                </div>
                
                <div class="input-group">
                    <input type="text" name="codigo_autenticacao" id="verification-code" required maxlength="6">
                    <span class="highlight"></span>
                    <label for="verification-code">Código de Verificação</label>
                </div>
            
                <input type="submit" class="auth-button" name="ValCodigo" value="Validar" id="botaoTransicao">
            
                <div class="reenviar">
                    <a href="#" id="reenviar-codigo">Reenviar Código</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#reenviar-codigo').click(function(e) {
            e.preventDefault();
            $('#loadingText').text('Reenviando código...');
            $('#loadingOverlay').css('display', 'flex');
            $.ajax({
                url: 'enviar_codigo_financeiro.php',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    $('#loadingOverlay').css('display', 'none');
                    if (response.success) {
                        $('#message').text('Novo código enviado para o seu e-mail.').removeClass('error-message').addClass('success-message').show();
                    } else {
                        $('#message').text('Erro ao enviar novo código: ' + response.message).removeClass('success-message').addClass('error-message').show();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#loadingOverlay').css('display', 'none');
                    $('#message').text('Erro ao processar a solicitação. Tente novamente.').removeClass('success-message').addClass('error-message').show();
                }
            });
        });

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
                        $('#message').text(response.message).removeClass('success-message').addClass('error-message').show();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#loadingOverlay').css('display', 'none');
                    $('#message').text('Erro ao processar a solicitação. Tente novamente.').removeClass('success-message').addClass('error-message').show();
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

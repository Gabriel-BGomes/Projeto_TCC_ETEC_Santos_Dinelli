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

// Gerar token CSRF se não existir
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Função para enviar resposta JSON com registro de erro detalhado
function sendJsonResponse($success, $message, $additionalInfo = null) {
    header('Content-Type: application/json');
    $response = [
        'success' => $success, 
        'message' => $message,
        'csrf_token' => $_SESSION['csrf_token'] // Enviar novo token a cada requisição
    ];
    
    if ($additionalInfo) {
        $response['debug'] = $additionalInfo;
    }
    
    error_log(json_encode($response)); // Registrar resposta completa para depuração
    echo json_encode($response);
    exit();
}

// Verificar se é uma requisição AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validar token CSRF
        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
            sendJsonResponse(false, 'Token de segurança inválido.');
        }

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        // Validar entrada do PIN
        $pin_input = preg_replace('/[^0-9]/', '', $dados['pin_financeiro'] ?? '');
        
        if (strlen($pin_input) < 4 || strlen($pin_input) > 6) {
            sendJsonResponse(false, 'PIN deve conter entre 4 e 6 dígitos.');
        }

        if (!empty($pin_input)) {
            try {
                // Buscar PIN do usuário logado
                $query_usuario = "SELECT pin_financeiro, id 
                                FROM usuarios 
                                WHERE id = :id 
                                LIMIT 1";

                $result_usuario = $conn->prepare($query_usuario);
                $result_usuario->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
                $result_usuario->execute();

                if ($result_usuario->rowCount() > 0) {
                    $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
                    
                    if (password_verify($pin_input, $row_usuario['pin_financeiro'])) {
                        $_SESSION['acesso_financeiro'] = true;
                        sendJsonResponse(true, 'PIN correto! Redirecionando...');
                    } else {
                        // Verificar se o PIN armazenado foi criptografado com um algoritmo diferente
                        if (substr($row_usuario['pin_financeiro'], 0, 4) === '$2y$') {
                            if (password_verify($pin_input, $row_usuario['pin_financeiro'])) {
                                $_SESSION['acesso_financeiro'] = true;
                                sendJsonResponse(true, 'PIN correto! Redirecionando...');
                            } else {
                                sendJsonResponse(false, 'Erro: PIN inválido!');
                            }
                        } else {
                            sendJsonResponse(false, 'Erro: PIN inválido!');
                        }
                    }
                } else {
                    sendJsonResponse(false, 'Erro: Usuário não encontrado.');
                }
            } catch(PDOException $e) {
                sendJsonResponse(false, 'Erro de banco de dados: ' . $e->getMessage());
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
        <?php 
        // Verificar se o usuário já possui PIN configurado
        $query_verificar_pin = "SELECT pin_financeiro FROM usuarios WHERE id = :id";
        $stmt_verificar_pin = $conn->prepare($query_verificar_pin);
        $stmt_verificar_pin->bindParam(':id', $_SESSION['id']);
        $stmt_verificar_pin->execute();
        $tem_pin = $stmt_verificar_pin->fetchColumn();
        ?>

        <nav class="menu-lateral"> <!-- primeiro item do menu -->

        <input type="checkbox" class="fake-tres-linhas">
        <div><img class="tres-linhas" src="../images/menu-tres-linhas.png" alt="menu de três linhas"></div>

        <ul>
            <li><a class="link" href="./home.php">ÍNICIO</a></li>
            <li><a class="link" href="./agenda.php">AGENDA</a></li>
            <li><a class="link" href="./finance.php">FINANCEIRO</a></li>
            <li><a class="link" href="./client.php">CLIENTES</a></li>
            <li><a class="link" href="https://WA.me/+5511947295062/?text=Olá, preciso de ajuda com o software." target="_blank">SUPORTE</a></li>
            <li><a class="link" href="../../login/sair.php">SAIR</a></li>
        </ul>

        </nav>

        <nav> <!-- começar com uma nav para definir os itens do menu-->

        <ul class="menu-fixo"> <!-- começo dos itens do menu-->
            <li><a class="link" href="./agenda.php">AGENDA</a></li>
            <li><a class="link" href="./finance.php">FINANCEIRO</a></li>
            <li><a class="link" href="./client.php">CLIENTES</a></li>
        </ul>

        </nav>

        <div> <!-- finalizar com a logo da empresa na direita-->
        <a href="https://www.santosedinelli.com.br/" target="_blank">
        <img class="logo" src="../images/santos-dinelli.png"  alt="logo da empresa"></a>
        </div> <!-- final da div da logo-->

    </header>
    
    <div class="container-geral" style="height: calc(100vh - 70px);">
        <div class="auth-container">
            <div class="auth-header">
                <h2 style="margin-top: 15px">
                    <?php echo $tem_pin ? 'Digite o PIN de acesso' : 'Configure seu PIN de acesso'; ?>
                </h2>
            </div>
        
            <div id="message" class="message"></div>
        
            <form method="POST" action="" class="auth-form" id="auth-form">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div class="loading-overlay" id="loadingOverlay">
                    <div class="loading-spinner"></div>
                    <div class="loading-text" id="loadingText">Validando...</div>
                </div>
                
                <div class="input-group">
                    <input type="password" name="pin_financeiro" id="verification-code" required maxlength="6">
                    <span class="highlight"></span>
                    <label for="verification-code">PIN</label>
                </div>
            
                <input type="submit" class="auth-button" name="ValPin" 
                       value="<?php echo $tem_pin ? 'Validar' : 'Configurar'; ?>" 
                       id="botaoTransicao">
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
                    console.log(response); // Log de resposta para debugging
                    
                    // Atualizar token CSRF
                    if (response.csrf_token) {
                        $('input[name="csrf_token"]').val(response.csrf_token);
                    }
                    
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
                        console.error(response); // Log de erro para debugging
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#loadingOverlay').css('display', 'none');
                    console.error(jqXHR, textStatus, errorThrown); // Log de erro detalhado
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
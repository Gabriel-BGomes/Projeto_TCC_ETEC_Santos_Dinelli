<?php
// enviar_codigo_financeiro.php
session_start();
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('America/Sao_Paulo');
include_once "..//../login/conexao.php";

// Importar classes do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Log function for debugging
function logError($message) {
    error_log(date('Y-m-d H:i:s') . " - " . $message . "\n", 3, "debug.log");
}

// Verificar se usuário está logado
if (!isset($_SESSION['id']) || !isset($_SESSION['usuario'])) {
    logError("Usuário não está logado - ID: " . (isset($_SESSION['id']) ? $_SESSION['id'] : 'não definido'));
    header("Location: ../../login/index.php");
    exit();
}

// Function to send JSON response
function sendJsonResponse($success, $message) {
    header('Content-Type: application/json');
    echo json_encode(['success' => $success, 'message' => $message]);
    exit();
}

try {
    // Gerar novo código de verificação
    $codigo_autenticacao = mt_rand(100000, 999999);
    $data = date('Y-m-d H:i:s');
    
    logError("Tentando gerar código para usuário ID: " . $_SESSION['id'] . " - Email: " . $_SESSION['usuario']);

    // Atualizar código no banco de dados
    $query_up_usuario = "UPDATE usuarios SET
                        codigo_autenticacao = :codigo_autenticacao,
                        data_codigo_autenticacao = :data_codigo_autenticacao
                        WHERE id = :id
                        LIMIT 1";

    $result_up_usuario = $conn->prepare($query_up_usuario);
    $result_up_usuario->bindParam(':codigo_autenticacao', $codigo_autenticacao);
    $result_up_usuario->bindParam(':data_codigo_autenticacao', $data);
    $result_up_usuario->bindParam(':id', $_SESSION['id']);

    if (!$result_up_usuario->execute()) {
        throw new Exception("Erro ao atualizar código no banco de dados");
    }

    // Incluir o Composer
    require '../../login/lib/vendor/autoload.php';

    // Criar instância do PHPMailer
    $mail = new PHPMailer(true);

    // Configurações de debug do SMTP
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->Debugoutput = function($str, $level) {
        logError("PHPMailer Debug: $str");
    };

    // Configuração do PHPMailer
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'testesdogabrielb@gmail.com';
    $mail->Password = 'mjpp ijhi nrkb dkoy';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Remetente e destinatário
    $mail->setFrom('testesdogabrielb@gmail.com', 'Santos & Dinelli Climatização');
    $mail->addAddress($_SESSION['usuario']);

    // Conteúdo do email
    $mail->isHTML(true);
    $mail->Subject = 'Código de Verificação para Acesso ao Financeiro';

    // Template do email
    $mail->Body = "
    <html>

    <body style=' 
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif';
                line-height: 1.6;
                color: #333;
                background-color: #f0f0f0;
                margin: 0;
                padding: 0;
                >
        
            <div class='container' style='
                max-width: 600px;
                margin: 20px auto;
                background-color: #ffffff;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);'
                >

                <div class='header' style='
                background-color: #228d02;
                color: white;
                padding: 30px;
                text-align: center;'
                >

                    <h1 style='margin: 0;
                    font-size: 28px;
                    font-weight: 300;'>
                    Autenticação Multifator
                    </h1>

                </div>

                <div class='content' style='padding: 30px;'>

                    <p>Olá!</p>
                    <p>Seu código de verificação de 6 dígitos é:</p>

                    <div class='code-container' style='
                    background-color: rgb(175, 221, 134);
                    border: 2px dashed rgb(175, 221, 134);
                    border-radius: 8px;
                    padding: 20px;
                    text-align: center;
                    margin: 20px 0;'
                    >
                    
                        <span class='code' style='
                        font-size: 36px;
                        font-weight: bold;
                        color: rgb(72, 140, 15, 1);
                        letter-spacing: 5px;'
                        >{$codigo_autenticacao}</span>

                    </div>

                    <div class='instructions' style='
                    background-color: #f9f9f9;
                    border-left: 4px solid #145400;
                    padding: 15px;
                    margin: 20px 0;'
                    >

                        <p><strong>Instruções:</strong></p>
                        <p>Este código foi enviado para verificar seu login. Por favor, insira-o na página de verificação para continuar.</p>
                    </div>

                    <p class='warning' style='
                    color: #e74c3c;
                    font-style: italic;'
                    >Se você não solicitou este código, por favor ignore este E-mail.</p>

                    <a href='localhost/project_Santos_Dinelli/src/pages/validar_codigo_financeiro.php'' class='btn' style='color: white !important;'>Ir para a página de verificação</a>

                </div>

                <div class='footer' style='
                background-color: #228d02;
                color: white;
                text-align: center;
                padding: 15px;
                font-size: 12px;'
                >
                    <p>Esta é uma mensagem automática. Por favor, não responda a este E-mail.</p>
                    <p>&copy; 2024 Santos & Dinelli Climatização. Todos os direitos reservados.</p>
                </div>

            </div>

        </body>

    </html>";

    $mail->AltBody = "Seu código de verificação para acesso ao financeiro é: {$codigo_autenticacao}";

    if (!$mail->send()) {
        throw new Exception("Erro ao enviar email: " . $mail->ErrorInfo);
    }

    // Marcar que o código foi enviado
    $_SESSION['codigo_enviado_financeiro'] = true;
    logError("Código enviado com sucesso para: " . $_SESSION['usuario']);

    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        sendJsonResponse(true, 'Código enviado com sucesso');
    } else {
        header('Location: validar_codigo_financeiro.php');
    }

} catch (Exception $e) {
    logError("Erro: " . $e->getMessage());
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        sendJsonResponse(false, "Erro: " . $e->getMessage());
    } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: " . $e->getMessage() . "</p>";
        header('Location: validar_codigo_financeiro.php');
    }
}
?>
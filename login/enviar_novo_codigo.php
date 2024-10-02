<?php
session_start();
include('conexao.php');

// Incluir o Composer
require './lib/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Função para gerar um novo código de 6 dígitos
function gerarNovoCodigo() {
    return str_pad(mt_rand(100000, 999999), 6, '0', STR_PAD_LEFT);
}

// Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não está logado.']);
    exit;
}

// Gerar novo código
$novo_codigo = gerarNovoCodigo();

$_SESSION['codigo_enviado'] = $novo_codigo;

// Recuperar a data atual
$data = date('Y-m-d H:i:s');

// QUERY para atualizar o código no banco de dados
$query_up_usuario = "UPDATE usuarios SET
                    codigo_autenticacao = :codigo_autenticacao,
                    data_codigo_autenticacao = :data_codigo_autenticacao
                    WHERE id = :id
                    LIMIT 1";

// Preparar a QUERY
$result_up_usuario = $conn->prepare($query_up_usuario);

// Substituir os parâmetros da QUERY pelos valores
$result_up_usuario->bindParam(':codigo_autenticacao', $novo_codigo);
$result_up_usuario->bindParam(':data_codigo_autenticacao', $data);
$result_up_usuario->bindParam(':id', $_SESSION['id']);

// Executar a QUERY
$result_up_usuario->execute();

// Recuperar os dados do usuário
$query_usuario = "SELECT nome, usuario FROM usuarios WHERE id = :id LIMIT 1";
$result_usuario = $conn->prepare($query_usuario);
$result_usuario->bindParam(':id', $_SESSION['id']);
$result_usuario->execute();
$row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);

// Criar o objeto e instanciar a classe do PHPMailer
$mail = new PHPMailer(true);

try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'testesdogabrielb@gmail.com';
    $mail->Password   = 'mjpp ijhi nrkb dkoy';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';

    // Configurações do e-mail
    $mail->setFrom('testesdogabrielb@gmail.com', 'NaoRespondaEsseEmail');
    $mail->addAddress($row_usuario['usuario'], $row_usuario['nome']);
    $mail->isHTML(true);
    $mail->Subject = 'Novo Código de Verificação para Autenticação Multifator';

    // Conteúdo do e-mail em formato HTML
    ob_start();
    include __DIR__ . '/email_novo_codigo_template.php';
    $mail->Body = ob_get_clean();

    // Conteúdo do e-mail em formato texto
    $mail->AltBody = "Olá {$row_usuario['nome']}!\n\n" .
                     "Seu novo código de verificação de 6 dígitos é: {$novo_codigo}\n\n" .
                     "Este código foi enviado para verificar seu login. Por favor, insira-o na página de verificação para continuar.\n\n" .
                     "Se você não solicitou este código, por favor ignore este email.\n\n" .
                     "Esta é uma mensagem automática. Por favor, não responda a este email.";

    // Enviar e-mail
    $mail->send();

    echo json_encode(['success' => true, 'message' => 'Novo código enviado com sucesso.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => "Erro ao enviar o e-mail: {$mail->ErrorInfo}"]);
}
?>
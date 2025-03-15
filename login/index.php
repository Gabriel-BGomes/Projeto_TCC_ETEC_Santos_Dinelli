<?php
session_start();

// Verificar se veio do timeout
if(isset($_GET['timeout']) && $_GET['timeout'] === 'true') {
    $_SESSION['msg'] = "<p style='color: #f00;'>Você foi desconectado por inatividade!</p>";
}

ob_start();

// Importar as classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Definir um fuso horario padrao
date_default_timezone_set('America/Sao_Paulo');

// Incluir o arquivo com a conexão com banco de dados
include_once "./conexao.php";

// Verificar remember me cookie
if (!isset($_SESSION['id']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    
    // Verificar o token no banco de dados
    $query_remember = "SELECT id, usuario, token_expiracao 
                      FROM usuarios 
                      WHERE remember_token = :token 
                      AND token_expiracao > NOW()
                      LIMIT 1";
    
    $result_remember = $conn->prepare($query_remember);
    $result_remember->bindParam(':token', $token);
    $result_remember->execute();
    
    if ($result_remember->rowCount() != 0) {
        $usuario = $result_remember->fetch(PDO::FETCH_ASSOC);
        
        // Renovar a sessão
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['usuario'] = $usuario['usuario'];
        
        // Renovar o token
        $novo_token = bin2hex(random_bytes(32));
        $nova_expiracao = date('Y-m-d H:i:s', strtotime('+30 days'));
        
        // Atualizar token no banco
        $query_update_token = "UPDATE usuarios SET 
                              remember_token = :novo_token,
                              token_expiracao = :nova_expiracao 
                              WHERE id = :id";
        
        $result_update = $conn->prepare($query_update_token);
        $result_update->bindParam(':novo_token', $novo_token);
        $result_update->bindParam(':nova_expiracao', $nova_expiracao);
        $result_update->bindParam(':id', $usuario['id']);
        $result_update->execute();
        
        // Atualizar cookie
        setcookie('remember_token', $novo_token, [
            'expires' => time() + (86400 * 30),
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);

        // Redirecionar para a página inicial após autologin
        header("Location: ../src/pages/home.php");
        exit();
    }
}

// Receber os dados do formulário
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// Acessar o IF quando o usuário clicar no botão acessar do formulário
if (!empty($dados['SendLogin'])) {
    // Recuperar os dados do usuário no banco de dados
    $query_usuario = "SELECT id, nome, usuario, senha_usuario 
                        FROM usuarios
                        WHERE usuario =:usuario
                        LIMIT 1";

    // Preparar a QUERY
    $result_usuario = $conn->prepare($query_usuario);

    // Substituir o link da query pelo valor que vem do formulário
    $result_usuario->bindParam(':usuario', $dados['usuario']);

    // Executar a QUERY
    $result_usuario->execute();

    // Acessar o IF quando encontrar usuário no banco de dados
    if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
        // Ler os registros retorando do banco de dados
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);

        // Acessar o IF quando a senha é válida
        if (password_verify($dados['senha_usuario'], $row_usuario['senha_usuario'])) {
            // Salvar os dados do usuário na sessão
            $_SESSION['id'] = $row_usuario['id'];
            $_SESSION['usuario'] = $row_usuario['usuario'];

            // Verificar se o usuário marcou a opção "Lembrar-me"
            if (isset($dados['manterlogin']) && $dados['manterlogin'] === 'manterlogin') {
                // Gerar um token único
                $token = bin2hex(random_bytes(32));
                
                // Data de expiração (30 dias)
                $expiracao = date('Y-m-d H:i:s', strtotime('+30 days'));
                
                // Salvar o token no banco de dados
                $query_token = "UPDATE usuarios SET 
                                remember_token = :token,
                                token_expiracao = :expiracao 
                                WHERE id = :id";
                
                $result_token = $conn->prepare($query_token);
                $result_token->bindParam(':token', $token);
                $result_token->bindParam(':expiracao', $expiracao);
                $result_token->bindParam(':id', $row_usuario['id']);
                $result_token->execute();
                
                // Criar cookie seguro
                setcookie('remember_token', $token, [
                    'expires' => time() + (86400 * 30), // 30 dias
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);
            }

            // Recuperar a data atual
            $data = date('Y-m-d H:i:s');

            // Gerar número randômico entre 100000 e 999999
            $codigo_autenticacao = mt_rand(100000, 999999);

            // QUERY para salvar no banco de dados o código e a data gerada
            $query_up_usuario = "UPDATE usuarios SET
                            codigo_autenticacao =:codigo_autenticacao,
                            data_codigo_autenticacao =:data_codigo_autenticacao
                            WHERE id =:id
                            LIMIT 1";

            // Preparar a QUERY
            $result_up_usuario = $conn->prepare($query_up_usuario);

            // Substituir o link da QUERY pelo valores
            $result_up_usuario->bindParam(':codigo_autenticacao', $codigo_autenticacao);
            $result_up_usuario->bindParam(':data_codigo_autenticacao', $data);
            $result_up_usuario->bindParam(':id', $row_usuario['id']);

            // Executar a QUERY
            $result_up_usuario->execute();

            // Incluir o Composer
            require './lib/vendor/autoload.php';

            // Criar o objeto e instanciar a classe do PHPMailer
            $mail = new PHPMailer(true);

            try {
                $mail->CharSet = 'UTF-8';
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'testesdogabrielb@gmail.com';
                $mail->Password = 'mjpp ijhi nrkb dkoy';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('testesdogabrielb@gmail.com', 'Santos Dinelli Climatização');
                $mail->addAddress($row_usuario['usuario'], $row_usuario['nome']);
                $mail->isHTML(true);
                $mail->Subject = 'Código de Verificação para Autenticação Multifator';

                ob_start();
                include __DIR__ . '/email_template.php';
                $mail->Body = ob_get_clean();

                $mail->AltBody = "Olá {$row_usuario['nome']}!\n\n" .
                                "Seu código de verificação de 6 dígitos é: {$codigo_autenticacao}\n\n" .
                                "Este código foi enviado para verificar seu login. Por favor, insira-o na página de verificação para continuar.\n\n" .
                                "Se você não solicitou este código, por favor ignore este email.\n\n" .
                                "Esta é uma mensagem automática. Por favor, não responda a este email.";

                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ]
                ];

                // Enviar e-mail
                $mail->send();

                // Redirecionar o usuário
                header('Location: validar_codigo.php');
                                

            } catch (Exception $e) {
                echo "E-mail não enviado com sucesso. Erro: {$mail->ErrorInfo}";
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: E-mail não enviado com sucesso!</p>";
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou senha inválida!</p>";
        }
    } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou senha inválida!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../src/style/login/index.css">
    <link rel="shortcut icon" href="../src/images/icons/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>    
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Bem-vindo de volta</h2>
            <p>faça seu login</p>
        </div>

        <?php if (isset($_SESSION['msg'])): ?>
            <div class="error-message">
                <?php 
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
                ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="" class="login-form" id="auth-form">

            <div class="loading-overlay" id="loadingOverlay">
                <div class="loading-spinner"></div>
                <div class="loading-text" id="loadingText">Validando...</div>
            </div>

            <div class="input-group">
                <input type="text" name="usuario" placeholder="Digite o usuário" id="email">
                <span class="highlight"></span>
                <label for="email">E-mail</label>
            </div>

            <div class="input-group">
                <input type="password" name="senha_usuario" id="password" placeholder="Digite a senha">
                <span class="highlight"></span>
                <label for="password">Senha</label>
                <span class="password-toggle" onclick="togglePassword()">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            
            <div class="lembrar-me">
                <input type="checkbox" name="manterlogin" value="manterlogin" class="lembrar-checkbox">
                <label for="manterlogin" class="lembrar-label">Lembrar-me</label>
            </div>

            <input type="submit" name="SendLogin" value="Acessar" class="login-button" id="botaoEnviar">    
            <div class="forgot-password">
                <a href="enviarcodigo.php" id="enviar">Esqueceu a senha?</a>
            </div>

        </form>
        
    </div>    

    <script>    

        document.getElementById('auth-form').addEventListener('submit', function(e) {
            // Show the loading overlay
            document.getElementById('loadingOverlay').style.display = 'flex';
        });

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

    </script>
</body>
</html>
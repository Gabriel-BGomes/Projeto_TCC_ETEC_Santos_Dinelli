<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verificar Código</title>
        <link rel="stylesheet" href="../src/style/login/verificar.css">
    </head>

    <body>
        
        <div class="auth-container">
                <div class="auth-header">
                    <h2>Digite o código enviado no e-mail cadastrado</h2>
                </div>

        <?php
        // Incluindo a conexão com o banco de dados
        include('conexao.php');

        // Iniciando a sessão
        session_start();

        // Verificando se o formulário foi enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtendo o código digitado pelo usuário
            $codigo_digitado = $_POST['codigo'];

            // Obtendo o código enviado por e-mail armazenado na sessão ou no banco de dados
            if (isset($_SESSION['codigo_enviado'])) {
                $codigo_enviado = $_SESSION['codigo_enviado'];

                // Verificando se os códigos coincidem
                if ($codigo_digitado == $codigo_enviado) {
                    // Redirecionando para a página de redefinir senha
                    header("Location: redefinir.php");
                    exit();
                } else {
                    // Exibindo mensagem de erro se o código for incorreto
                    echo "O código está incorreto. Tente novamente.";
                }
            } else {
                echo "Código não encontrado. Solicite novamente o envio.";
            }
        }
        ?>


        <form method="POST" action="" class="auth-form" id="auth-form">

            <div class="input-group">
                <input type="text" name="codigo" id="verification-code" required maxlength="6">
                <span class="highlight"></span>
                <label for="codigo">Código de Verificação</label>
            </div>

            <input type="submit" class="auth-button" name="ValCodigo" value="Validar" id="botaoTransicao">

        </form>

    </body>

</html>
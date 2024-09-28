<?php

session_start(); // Iniciar a sessão

ob_start(); // Limpar o buffer de saída

// Definir um fuso horario padrao
date_default_timezone_set('America/Sao_Paulo');

// Incluir o arquivo com a conexão com banco de dados
include_once "./conexao.php";

?>

<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verificação de Duas Etapas</title>
        <link rel="stylesheet" href="../src/style/login/validar_codigo.css">
        <link rel="shortcut icon" href="../src/images/icons/logo.ico" type="image/x-icon">      

    </head>

    <body>

        <div class="auth-container">
            <div class="auth-header">
                <h2>Digite o código enviado no e-mail cadastrado</h2>
            </div>
        
            <?php
                // Receber os dados do formulário
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                // Acessar o IF quando o usuário clicar no botão acessar do formulário
                if (!empty($dados['ValCodigo'])) {
                    //var_dump($dados);
                    //var_dump($_SESSION['id']);
                    //var_dump($_SESSION['usuario']);

                    // Recuperar os dados do usuário no banco de dados
                    $query_usuario = "SELECT id, nome, usuario, senha_usuario 
                                FROM usuarios
                                WHERE id =:id
                                AND usuario =:usuario
                                AND codigo_autenticacao =:codigo_autenticacao
                                LIMIT 1";

                    // Preparar a QUERY
                    $result_usuario = $conn->prepare($query_usuario);

                    // Substituir o link da query pelo valor que vem do formulário
                    $result_usuario->bindParam(':id', $_SESSION['id']);
                    $result_usuario->bindParam(':usuario', $_SESSION['usuario']);
                    $result_usuario->bindParam(':codigo_autenticacao', $dados['codigo_autenticacao']);

                    // Executar a QUERY
                    $result_usuario->execute();

                    // Acessar o IF quando encontrar usuário no banco de dados
                    if (($result_usuario) and ($result_usuario->rowCount() != 0)) {

                        // Ler os registros retorando do banco de dados
                        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);

                        // QUERY para salvar no banco de dados o código e a data gerada
                        $query_up_usuario = "UPDATE usuarios SET
                                codigo_autenticacao = NULL,
                                data_codigo_autenticacao = NULL
                                WHERE id =:id
                                LIMIT 1";

                        // Preparar a QUERY
                        $result_up_usuario = $conn->prepare($query_up_usuario);

                        // Substituir o link da QUERY pelo valores
                        $result_up_usuario->bindParam(':id', $_SESSION['id']);

                        // Executar a QUERY
                        $result_up_usuario->execute();

                        // Salvar os dados do usuário na sessão
                        $_SESSION['nome'] = $row_usuario['nome'];
                        $_SESSION['codigo_autenticacao'] = true;            

                        // Redirecionar o usuário
                        header('Location: ../src/pages/home.php');
                    }else{
                        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Código inválido!</p>";
                    }
                }
                ?>
                
                    <?php if (isset($_SESSION['msg'])): ?>

                <div class="error-message">
                    <?php 
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                    ?>
                </div>

            <?php endif; ?>

                <!-- Inicio do formulário validar código -->
                <form method="POST" action="" class="auth-form" id="auth-form">
                    <div class="input-group">
                        <input type="text" name="codigo_autenticacao" id="verification-code" required maxlength="6">
                        <span class="highlight"></span>
                        <label for="verification-code">Código de Verificação</label>
                    </div>
                    <input type="submit" class="auth-button" name="ValCodigo" value="Validar" id="botaoTransicao">
                </form> <!-- Fim do formulário validar código -->

        </div>

    </body>

</html>
<?php
session_start();
include_once "./conexao.php";

// Redirect if user is not authenticated
if (!isset($_SESSION['id'])) {
    header("Location: enviarcodigo.php");
    exit();
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nova_senha = $_POST['nova_senha'];
    $confirma_senha = $_POST['confirma_senha'];

    if ($nova_senha === $confirma_senha) {
        $id = $_SESSION['id'];
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

        $query_update = "UPDATE usuarios SET senha_usuario = :senha WHERE id = :id";
        $stmt = $conn->prepare($query_update);
        $stmt->bindParam(':senha', $senha_hash);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $msg = "<p style='color: green;'>Senha atualizada com sucesso!</p>";
            header("Location: index.php");
            // Clear session variables
            unset($_SESSION['id']);
            unset($_SESSION['email']);
            unset($_SESSION['codigo_enviado']);
        } else {
            $msg = "<p style='color: red;'>Erro ao atualizar a senha.</p>";
        }
    } else {
        $msg = "<p style='color: red;'>As senhas não coincidem.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Redefinir Senha</title>
        <link rel="stylesheet" href="../src/style/login/redefinir.css">

    </head>

    <body>

        <div class="reset-container">

            <div class="reset-header">
                <h2>Redefinição de Senha</h2>
                <p>Digite sua nova senha abaixo</p>
            </div>

            <form action="" method="post" class="reset-form" id="reset-form">

                <div class="input-group">
                    <input type="password" id="new-password" name="nova_senha" required>
                    <span class="highlight"></span>
                    <label for="new-password">Nova Senha</label>
                </div>

                <div class="input-group">
                    <input type="password" id="confirm-password" name="confirma_senha" required>
                    <span class="highlight"></span>
                    <label for="confirm-password">Confirmar Senha</label>
                </div>

                <input type="submit" value="Redefinir Senha" class="reset-button">

            </form>

        </div>

    </body>

</html>
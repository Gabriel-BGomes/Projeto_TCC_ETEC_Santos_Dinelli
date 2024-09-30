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

    // Verifica se a nova senha tem no mínimo 8 caracteres
    if (strlen($nova_senha) < 8) {
        $msg = "<p style='color: red;'>A senha deve ter no mínimo 8 caracteres.</p>";
    } else if ($nova_senha !== $confirma_senha) {
        $msg = "<p style='color: red;'>As senhas não coincidem.</p>";
    } else {
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
            exit();  // Para garantir que a execução seja interrompida após o redirecionamento
        } else {
            $msg = "<p style='color: red;'>Erro ao atualizar a senha.</p>";
        }
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
        <link rel="shortcut icon" href="../src/images/icons/logo.ico" type="image/x-icon">

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
            <div class="password-strength">
                <div class="password-strength-meter"></div>
            </div>

                <div class="password-requirements" id="password-requirements">
                    <p id="length" class="invalid">Mínimo de 8 caracteres</p>
                    <p id="uppercase" class="invalid">Letras maiúsculas</p>
                    <p id="number" class="invalid">Números</p>
                    <p id="special" class="invalid">Símbolos especiais ($@#&!)</p>
                </div>

                <div class="input-group">
                    <input type="password" id="confirm-password" name="confirma_senha" required>
                    <span class="highlight"></span>
                    <label for="confirm-password">Confirmar Senha</label>
                </div>
                <div class="password-strength">
                    <div class="password-strength-meter"></div>
                </div>
                
                <div class="same-password" id="same-password">
                    <p id="same" class="invalid">As senhas devem ser idênticas</p>
                </div>

                <input type="submit" value="Redefinir Senha" class="reset-button">

            </form>

        </div>

    </body>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const newPassword = document.getElementById('new-password');
            const confirmPassword = document.getElementById('confirm-password');
            const passwordStrengthMeters = document.querySelectorAll('.password-strength-meter');
            const requirements = {
                length: document.querySelector('#password-requirements #length'),
                uppercase: document.querySelector('#password-requirements #uppercase'),
                number: document.querySelector('#password-requirements #number'),
                special: document.querySelector('#password-requirements #special'),
                same: document.querySelector('#same-password #same')
            };

            newPassword.addEventListener('input', function() {
                const strength = calculatePasswordStrength(this.value);
                updatePasswordStrength(passwordStrengthMeters[0], strength);
                checkPasswordRequirements(this.value, confirmPassword.value);
            });

            confirmPassword.addEventListener('input', function() {
                const strength = calculatePasswordStrength(this.value);
                updatePasswordStrength(passwordStrengthMeters[1], strength);
                checkPasswordRequirements(newPassword.value, this.value);
            });

            function calculatePasswordStrength(password) {
                let strength = 0;
                if (password.length >= 8) strength += 25;
                if (password.match(/[A-Z]/)) strength += 25;
                if (password.match(/[0-9]/)) strength += 25;
                if (password.match(/[$@#&!]/)) strength += 25;
                return strength;
            }

            function getStrengthColor(strength) {
                if (strength < 50) return '#ff4d4d';
                if (strength < 75) return '#ffa64d';
                return '#5cd65c';
            }

            function updatePasswordStrength(meter, strength) {
                meter.style.width = `${strength}%`;
                meter.style.backgroundColor = getStrengthColor(strength);
            }

            function checkPasswordRequirements(password, confirmPwd) {
                updateRequirement(requirements.length, password.length >= 8);
                updateRequirement(requirements.uppercase, password.match(/[A-Z]/));
                updateRequirement(requirements.number, password.match(/[0-9]/));
                updateRequirement(requirements.special, password.match(/[$@#&!]/));
                updateRequirement(requirements.same, password === confirmPwd && password !== '');
            }

            function updateRequirement(element, isValid) {
                if (isValid) {
                    element.classList.add('valid');
                    element.classList.remove('invalid');
                } else {
                    element.classList.add('invalid');
                    element.classList.remove('valid');
                }
            }
        });

    </script>

</html>
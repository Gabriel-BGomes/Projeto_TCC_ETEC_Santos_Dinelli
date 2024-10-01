<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Autenticação Multifator</title>

        <style>

            
        body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                line-height: 1.6;
                color: #333;
                background-color: #f0f0f0;
                margin: 0;
                padding: 0;
            }

            .container {
                max-width: 600px;
                margin: 20px auto;
                background-color: #ffffff;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            }

            .header {
                background-color: #228d02;
                color: white;
                padding: 30px;
                text-align: center;
            }

            h1 {
                margin: 0;
                font-size: 28px;
                font-weight: 300;
            }

            .content {
                padding: 30px;
            }

            .code-container {
                background-color: rgb(175, 221, 134);
                border: 2px dashed rgb(175, 221, 134);
                border-radius: 8px;
                padding: 20px;
                text-align: center;
                margin: 20px 0;
            }

            .code {
                font-size: 36px;
                font-weight: bold;
                color: rgb(72, 140, 15, 1);
                letter-spacing: 5px;
            }

            .instructions {
                background-color: #f9f9f9;
                border-left: 4px solid #145400;
                padding: 15px;
                margin: 20px 0;
            }

            .warning {
                color: #e74c3c;
                font-style: italic;
            }

            .footer {
                background-color: #228d02;
                color: white;
                text-align: center;
                padding: 15px;
                font-size: 12px;
            }

            .btn {
                display: inline-block;
                background-color: #228d02;
                color: white;
                text-decoration: none;
                padding: 10px 20px;
                border-radius: 5px;
                margin-top: 20px;
                transition: background-color 0.5s;
            }

            .btn:hover {
                background-color: #145400;
                transition: 0.5s;
            }


        </style>

    </head>

    <body>
        
        <div class="container">

            <div class="header">
                <h1>Autenticação Multifator</h1>
            </div>

            <div class="content">

                <p>Olá <?php echo htmlspecialchars($row_usuario['nome']); ?>!</p>
                <p>Seu código de verificação de 6 dígitos é:</p>

                <div class="code-container">
                    <span class="code"><?php echo htmlspecialchars($novo_codigo); ?></span>
                </div>

                <div class="instructions">
                    <p><strong>Instruções:</strong></p>
                    <p>Este código foi enviado para verificar seu login. Por favor, insira-o na página de verificação para continuar.</p>
                </div>

                <p class="warning">Se você não solicitou este código, por favor ignore este E-mail.</p>
                <a href="localhost/project_Santos_Dinelli/login/validar_codigo.php" class="btn" style="color: white !important;">Ir para a página de verificação</a>

            </div>

            <div class="footer">
                <p>Esta é uma mensagem automática. Por favor, não responda a este E-mail.</p>
                <p>&copy; 2024 Santos & Dinelli Climatização. Todos os direitos reservados.</p>
            </div>

        </div>

    </body>

</html>
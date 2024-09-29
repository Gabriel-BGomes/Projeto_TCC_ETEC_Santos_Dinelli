<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../style/clientes/clientes.css">
    <link rel="stylesheet" href="../../style/layout-header.css">
    <link rel="shortcut icon" href="../images/icons/logo.ico" type="image/x-icon">
    <title>Cadastro</title>
</head>

<body>
    <!-- Voltar legal -->
    <button onclick="history.back()" style="margin-bottom: 20px;">Voltar</button>


    <?php    
    // Configurações do banco de dados
    $host = "localhost";
    $dbname = "santos_dinelli"; // Substitua pelo nome do seu banco de dados
    $user = "root"; // Substitua pelo seu usuário do banco de dados
    $pass = ""; // Substitua pela sua senha do banco de dados

    try {
        // Criar a conexão com o banco de dados usando PDO
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        // Definir o modo de erro do PDO como exceção
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erro na conexão: " . $e->getMessage();
        exit;
    }

    // Receber dados do formulário com PHP
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    // Verificar se o usuário clicou no botão cadastrar
    if (!empty($dados['SendCad'])) {
        // Acessa o IF quando o tipo de pessoa é física
        if ($dados['tipo_pessoa'] == 1) {
            // Verificação se campos obrigatórios estão preenchidos
            if (empty($dados['email_cliente']) || empty($dados['telefone']) || empty($dados['endereco']) || empty($dados['nome_cliente'])) {
                echo "<p style='color: red;'>Por favor, preencha todos os campos obrigatórios!</p>";
            } else {
                // QUERY para cadastrar pessoa física no banco de dados
                $query_pessoa = "INSERT INTO clientes (tipo_pessoa, nome_cliente, email_cliente, cpf_cliente, data_nascimento, telefone, endereco, bairro, cep, cidade, complemento, forma_pagamento) 
                                VALUES (:tipo_pessoa, :nome_cliente, :email_cliente, :cpf_cliente, :data_nascimento, :telefone, :endereco, :bairro, :cep, :cidade, :complemento, :forma_pagamento)";

                // Preparar a QUERY com PDO
                $cad_pessoa = $conn->prepare($query_pessoa);

                // Substituir os valores da QUERY pelos valores que vem do formulário
                $cad_pessoa->bindParam(':tipo_pessoa', $dados['tipo_pessoa']);
                $cad_pessoa->bindParam(':nome_cliente', $dados['nome_cliente']);
                $cad_pessoa->bindParam(':email_cliente', $dados['email_cliente']);
                $cad_pessoa->bindParam(':cpf_cliente', $dados['cpf_cliente']);
                $cad_pessoa->bindParam(':data_nascimento', $dados['data_nascimento']);
                $cad_pessoa->bindParam(':telefone', $dados['telefone']);
                $cad_pessoa->bindParam(':endereco', $dados['endereco']);
                $cad_pessoa->bindParam(':bairro', $dados['bairro']);
                $cad_pessoa->bindParam(':cep', $dados['cep']);
                $cad_pessoa->bindParam(':cidade', $dados['cidade']);
                $cad_pessoa->bindParam(':complemento', $dados['complemento']);
                $cad_pessoa->bindParam(':forma_pagamento', $dados['forma_pagamento']);
                
               // Executar a QUERY com PDO
                try {
                    $cad_pessoa->execute();
                    if ($cad_pessoa->rowCount()) {
                        echo "<p style='color: green;'>Cliente cadastrado com sucesso!</p>";
                    } else {
                        echo "<p style='color: #f00;'>Erro: Cliente não cadastrado com sucesso!</p>";
                    }

                    
                } catch (PDOException $e) {
                    echo "Erro ao cadastrar: " . $e->getMessage();
                }
            }
        } elseif ($dados['tipo_pessoa'] == 2) { 
            // Acessa o ELSEIF quando o tipo de pessoa é jurídica
            if (empty($dados['email_cliente_pj']) || empty($dados['telefone_pj']) || empty($dados['endereco_pj']) || empty($dados['razao_social'])) {
                echo "<p style='color: red;'>Por favor, preencha todos os campos obrigatórios!</p>";
            } else {
                // QUERY para cadastrar pessoa jurídica no banco de dados
                $query_pessoa = "INSERT INTO clientes (tipo_pessoa, razao_social, email_cliente_pj, cnpj, telefone_pj, endereco_pj, cep_pj, referencia_pj) 
                                 VALUES (:tipo_pessoa, :razao_social, :email_cliente_pj, :cnpj, :telefone_pj, :endereco_pj, :cep_pj, :referencia_pj)";

                // Preparar a QUERY com PDO
                $cad_pessoa = $conn->prepare($query_pessoa);

                // Substituir os valores da QUERY pelos valores que vem do formulário
                $cad_pessoa->bindParam(':tipo_pessoa', $dados['tipo_pessoa']);
                $cad_pessoa->bindParam(':razao_social', $dados['razao_social']);
                $cad_pessoa->bindParam(':email_cliente_pj', $dados['email_cliente_pj']);
                $cad_pessoa->bindParam(':cnpj', $dados['cnpj']);
                $cad_pessoa->bindParam(':telefone_pj', $dados['telefone_pj']); // Verifique se este nome está correto
                $cad_pessoa->bindParam(':endereco_pj', $dados['endereco_pj']);
                $cad_pessoa->bindParam(':cep_pj', $dados['cep_pj']); // Verifique se o nome do campo está correto
                $cad_pessoa->bindParam(':referencia_pj', $dados['referencia_pj']);
                
                // Executar a QUERY com PDO
                try {
                    $cad_pessoa->execute();
                    if ($cad_pessoa->rowCount()) {
                        echo "<p style='color: green;'>Cliente cadastrado com sucesso!</p>";
                    } else {
                        echo "<p style='color: #f00;'>Erro: Cliente não cadastrado com sucesso!</p>";
                    }
                } catch (PDOException $e) {
                    echo "Erro ao cadastrar: " . $e->getMessage();
                    
                }
            }
        }
    }
    ?>

    <h1 style="display: flex;">
        Cadastrar cliente:&nbsp;
        <span id="titulo-pessoa-fisica" style="display: none;">Pessoa física</span>
        <span id="titulo-pessoa-juridica" style="display: none;">Pessoa jurídica</span>
    </h1>

    <form method="POST" action="">
        <input type="radio" name="tipo_pessoa" id="tipo_pessoa_fisica" value="1" onchange="formPessoaFisica();">Pessoa Física
        <input type="radio" name="tipo_pessoa" id="tipo_pessoa_juridica" value="2" onchange="formPessoaJuridica();">Pessoa Jurídica<br><br>

        <div id="form-pessoa-fisica" style="display: none;">
            <label>Nome</label>
            <input type="text" name="nome_cliente" placeholder="Nome completo"><br><br>

            <label>E-mail</label>
            <input type="email" name="email_cliente" placeholder="E-mail"><br><br>

            <label>CPF</label>
            <input type="text" name="cpf_cliente" placeholder="CPF"><br><br>

            <label>Data de Nascimento</label>
            <input type="date" name="data_nascimento" placeholder="Data de nascimento"><br><br>

            <label>Telefone</label>
            <input type="text" name="telefone" placeholder="Telefone"><br><br>

            <label>Endereço completo da entrega</label>
            <input type="text" name="endereco" placeholder="Endereço completo"><br><br>

            <label>Bairro</label>
            <input type="text" name="bairro" placeholder="Bairro"><br><br>

            <label>CEP</label>
            <input type="text" name="cep" placeholder="CEP"><br><br>

            <label>Cidade</label>
            <input type="text"

            <input type="text" name="cidade" placeholder="Cidade"><br><br>

<label>Complemento</label>
<input type="text" name="complemento" placeholder="Complemento"><br><br>

<label>Forma de Pagamento</label>
<input type="text" name="forma_pagamento" placeholder="Forma de pagamento"><br><br>
</div>

<div id="form-pessoa-juridica" style="display: none;">
<label>Razão Social</label>
<input type="text" name="razao_social" placeholder="Razão social"><br><br>

<label>E-mail</label>
<input type="email" name="email_cliente_pj" placeholder="E-mail"><br><br>

<label>CNPJ</label>
<input type="text" name="cnpj" placeholder="CNPJ"><br><br>

<label>Telefone(s)</label>
<input type="text" name="telefone_pj" placeholder="Telefone(s)"><br><br>

<label>Endereço completo</label>
<input type="text" name="endereco_pj" placeholder="Endereço completo"><br><br>

<label>CEP</label>
<input type="text" name="cep_pj" placeholder="CEP"><br><br>

<label>Ponto de referência</label>
<input type="text" name="referencia_pj" placeholder="Ponto de referência"><br><br>
</div>

<div id="form-btn-cadastrar" style="display: none;">
<input type="submit" name="SendCad" value="Cadastrar"><br><br>
</div>

</form>
<!-- Fim formulário cadastrar pessoa física ou pessoa jurídica -->

<script>
// Função para carregar os campos para cadastrar pessoa física
function formPessoaFisica() {
// Apresentar o título cadastrar pessoa física
document.getElementById("titulo-pessoa-fisica").style.display = 'block';
document.getElementById("titulo-pessoa-juridica").style.display = 'none';

// Apresentar o formulário cadastrar pessoa física
document.getElementById("form-pessoa-fisica").style.display = 'block';
document.getElementById("form-pessoa-juridica").style.display = 'none';

// Carregar o botão cadastrar após o usuário selecionar o tipo de formulário pessoa física ou jurídica
document.getElementById("form-btn-cadastrar").style.display = 'block';
}

// Função para carregar os campos para cadastrar pessoa jurídica
function formPessoaJuridica() {
// Apresentar o título cadastrar pessoa jurídica
document.getElementById("titulo-pessoa-juridica").style.display = 'block';
document.getElementById("titulo-pessoa-fisica").style.display = 'none';

// Apresentar o formulário cadastrar pessoa jurídica
document.getElementById("form-pessoa-fisica").style.display = 'none';
document.getElementById("form-pessoa-juridica").style.display = 'block';

// Carregar o botão cadastrar após o usuário selecionar o tipo de formulário pessoa física ou jurídica
document.getElementById("form-btn-cadastrar").style.display = 'block';
}
</script>

</body>
</html>

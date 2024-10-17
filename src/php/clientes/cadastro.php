<!-- <?php

session_start(); // Iniciar a sessão

ob_start(); // Limpar o buffer de saída

// Definir um fuso horario padrao
date_default_timezone_set('America/Sao_Paulo');

// Acessar o IF quando o usuário não estão logado e redireciona para página de login
if((!isset($_SESSION['id'])) and (!isset($_SESSION['usuario'])) and (!isset($_SESSION['codigo_autenticacao']))){
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário realizar o login para acessar a página!</p>";

    // Redirecionar o usuário
    header("Location: /project_Santos_Dinelli/login/index.php");

    // Pausar o processamento
    exit();
}

?> -->

<!DOCTYPE html>
<html lang="pt">

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../style/clientes/cadastrar.css">
        <link rel="stylesheet" href="../../style/layout-header.css">
        <link rel="shortcut icon" href="../../images/icons/logo.ico" type="image/x-icon">
        <title>Cadastro</title>
    </head>

    <body>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Adicionando a biblioteca Inputmask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.7/jquery.inputmask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>

    <header class="header"> <!-- começo menu fixo no topo -->
            
            <nav class="menu-lateral"> <!-- primeiro item do menu -->

                <input type="checkbox" class="fake-tres-linhas">
                <div><img class="tres-linhas" src="../../images/menu-tres-linhas.png" alt="menu de três linhas"></div>

                <ul>
                    <li><a class="link" href="../../pages/home.php">ÍNICIO</a></li>
                    <li><a class="link" href="../../pages/agenda.php">AGENDA</a></li>
                    <li><a class="link" href="../../pages/finance.php">FINANCEIRO</a></li>
                    <li><a class="link" href="../../pages/client.php">CLIENTES</a></li>
                    <li><a class="link" href="https://WA.me/+5511947295062/?text=Olá, preciso de ajuda com o software." target="_blank">SUPORTE</a></li>
                    <li><a class="link" href="../../../login/sair.php">SAIR</a></li>
                </ul>

            </nav>

            <nav> <!-- começar com uma nav para definir os itens do menu-->

                <ul class="menu-fixo"> <!-- começo dos itens do menu-->

                    <li><a class="link" href="../../pages/agenda.php">AGENDA</a></li>
                    <li><a class="link" href="../../pages/finance.php">FINANCEIRO</a></li>
                    <li><a class="link" href="../../pages/client.php">CLIENTES</a></li>

                </ul>

            </nav>

            <nav> <!-- finalizar com a logo da empresa na direita-->

                <a href="https://www.santosedinelli.com target="_blank">
                <img class="logo" src="../../images/santos-dinelli.png"  alt="logo da empresa"></a>

            </nav> <!-- final da div da logo-->

        </header> <!-- fim header fixo -->

        <!--  botao voltar legal do leo
        <button onclick="history.back()" style="margin-bottom: 20px;">Voltar</button> -->


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
                    echo "<p class='error-message' style='color: red;'>Por favor, preencha todos os campos obrigatórios!</p>";

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
                            echo "<p id='successMessage' class='success-message'>Cliente cadastrado com sucesso!</p>";
                        } else {
                            echo "<p id='errorMessage' class='error-message'>Erro: Cliente não cadastrado com sucesso!</p>";
                        }
                        
                    } catch (PDOException $e) {
                        echo "<p id='errorMessage' class='error-message'>Erro ao cadastrar: " . $e->getMessage() . "</p>";
                    }
                }

            } elseif ($dados['tipo_pessoa'] == 2) { 

                // Acessa o ELSEIF quando o tipo de pessoa é jurídica
                if (empty($dados['email_cliente_pj']) || empty($dados['telefone_pj']) || empty($dados['endereco_pj']) || empty($dados['razao_social'])) {
                    echo "<p class='error-message' style='color: red;'>Por favor, preencha todos os campos obrigatórios!</p>";
                } else {
                    // QUERY para cadastrar pessoa jurídica no banco de dados
                    $query_pessoa = "INSERT INTO clientes (tipo_pessoa, razao_social, email_cliente_pj, cnpj, telefone_pj, endereco_pj, cep_pj, referencia_pj, bairro_pj, cidade_pj, complemento_pj, forma_pagamento_pj) 
                    VALUES 
                    (:tipo_pessoa, :razao_social, :email_cliente_pj, :cnpj, :telefone_pj, :endereco_pj, :cep_pj, :referencia_pj, :bairro_pj, :cidade_pj, :complemento_pj, :forma_pagamento_pj)";

                    // Preparar a QUERY com PDO
                    $cad_pessoa = $conn->prepare($query_pessoa);

                  // Substituir os valores da QUERY pelos valores que vem do formulário
                    $cad_pessoa->bindParam(':tipo_pessoa', $dados['tipo_pessoa']);
                    $cad_pessoa->bindParam(':razao_social', $dados['razao_social']);
                    $cad_pessoa->bindParam(':email_cliente_pj', $dados['email_cliente_pj']);
                    $cad_pessoa->bindParam(':cnpj', $dados['cnpj']);
                    $cad_pessoa->bindParam(':telefone_pj', $dados['telefone_pj']);  
                    $cad_pessoa->bindParam(':endereco_pj', $dados['endereco_pj']);
                    $cad_pessoa->bindParam(':cep_pj', $dados['cep_pj']); 
                    $cad_pessoa->bindParam(':bairro_pj', $dados['bairro_pj']); 
                    $cad_pessoa->bindParam(':cidade_pj', $dados['cidade_pj']); 
                    $cad_pessoa->bindParam(':complemento_pj', $dados['complemento_pj']);
                    $cad_pessoa->bindParam(':referencia_pj', $dados['referencia_pj']);
                    $cad_pessoa->bindParam(':forma_pagamento_pj', $dados['forma_pagamento_pj']);

                    // Executar a QUERY com PDO
                    try {
                        $cad_pessoa->execute();
                        if ($cad_pessoa->rowCount()) {
                            echo "<p class='success-message'>Cliente cadastrado com sucesso!</p>";
                        } else {
                            echo "<p class='error-message'>Erro: Cliente não cadastrado com sucesso!</p>";
                        }
                    } catch (PDOException $e) {
                        echo "Erro ao cadastrar: " . $e->getMessage();
                        
                    }
                }
            }
        }
        ?>

        <div class="container">
           
            <form method="POST" action="" class="form" id="form">
            
                <div class="tipo-pessoa" id="tipo-pessoa">

                    <h1 style="display: flex;" id="titulo">
                        Cadastrar cliente:&nbsp;
                        <span id="titulo-pessoa-fisica" style="display: none;">Pessoa física</span>
                        <span id="titulo-pessoa-juridica" style="display: none;">Pessoa jurídica</span>
                    </h1>

                    <div class="radio">
                        <input type="radio" name="tipo_pessoa"  id="tipo_pessoa_fisica" class="radin" value="1" onchange="mostrarFormulario();">
                        <p class="input-radio" id="radio">Pessoa Física</p>
                        <input type="radio" name="tipo_pessoa"  id="tipo_pessoa_juridica" class="radin" value="2" onchange="mostrarFormulario();">
                        <p class="input-radio" id="radio">Pessoa Jurídica</p>
                    </div>

                </div>  <!-- fechamento tipo-pesso -->

                <div id="form-pessoa-fisica" style="display: none;">
                    
                    <div class="separar">
                        
                        <div class="input-group">
                            <input type="text" name="nome_cliente" placeholder="Nome completo"> 
                            <span class="highlight"></span>
                            <label>Nome</label>
                        </div>

                        <div class="input-group">
                            <input type="email" name="email_cliente" placeholder="E-mail">
                            <span class="highlight"></span>
                            <label>E-mail</label>
                        </div>

                        <div class="input-group">
                            <input type="text" name="cpf_cliente" id="cpf" placeholder="CPF">
                            <span class="highlight"></span>
                            <label>CPF</label>
                        </div>

                        <div class="input-group">
                            <input type="date" name="data_nascimento" placeholder="Data de nascimento">
                            <span class="highlight"></span>
                            <label>Data de Nascimento</label>
                        </div>

                        <div class="input-group">
                            <input type="text" name="telefone" id="telefoneFisica" placeholder="Telefone">
                            <span class="highlight"></span>
                            <label>Telefone</label>
                        </div>
                   
                    </div>

                    <div class="separar">

                        <div class="input-group">
                            <input type="text" name="cep" id="cepFisica" placeholder="CEP">
                            <span class="highlight"></span>
                            <label>CEP</label> 
                        </div>   
                        
                        <div class="input-group">
                            <input type="text" name="endereco" id="ruaFisica" placeholder="Ex: rua abacaxi listrado 112">
                            <span class="highlight"></span>
                            <label>Endereço Completo</label>
                        </div>

                        <div class="input-group">
                            <input type="text" name="bairro" id="bairroFisica" placeholder="Bairro">
                            <span class="highlight"></span>
                            <label>Bairro</label>
                        </div>

                        <div class="input-group">
                            <input type="text" name="cidade" id="cidadeFisica" placeholder="Cidade">
                            <span class="highlight"></span>
                            <label>Cidade</label>
                        </div>

                        <div class="input-group">
                            <input type="text" name="complemento" placeholder="Complemento">
                            <span class="highlight"></span>
                            <label>Complemento</label>
                        </div>

                    </div>

                    <div class="campo especial">
                        <label class="label-especial">Forma de Pagamento</label>

                        <select name="forma_pagamento">
                            <option value="">Selecione</option>
                            <option value="Débito">Débito</option>
                            <option value="Crédito">Crédito</option>
                            <option value="Boleto">Boleto</option>
                            <option value="Pix">Pix</option>
                            <option value="Dinheiro">Dinheiro</option>
                        </select>

                
                    </div>  

                </div> <!-- fim do form para pessoa fisica -->

                <div id="form-pessoa-juridica" style="display: none;">


                    <div class="separar">

                        <div class="input-group slide-down">
                            <input type="text" name="razao_social" placeholder="Razão social">
                            <span class="highlight"></span>
                            <label>Razão Social</label>
                        </div>  

                        <div class="input-group">
                            <input type="email" name="email_cliente_pj" placeholder="E-mail">
                            <span class="highlight"></span>
                            <label>E-mail</label>
                        </div>

                        <div class="input-group">
                            <input type="text" name="cnpj" id="cnpj" placeholder="CNPJ">
                            <span class="highlight"></span>
                            <label>CNPJ</label>  
                        </div>

                        <div class="input-group">
                            <input type="text" name="telefone_pj" id="telefoneJuridica" maxlength="12" placeholder="Telefone">
                            <span class="highlight"></span>
                            <label>Telefone</label>
                        </div>

                          <div class="input-group">
                            <input type="text" name="cep_pj" id="cepJuridica" placeholder="CEP">
                            <span class="highlight"></span>
                            <label>CEP</label>
                        </div>   

                    </div>

                    <div class="separar">

                        <div class="input-group">
                            <input type="text" name="endereco_pj" id="ruaJuridica" placeholder="Ex: rua abacaxi listrado 112">
                            <span class="highlight"></span>
                            <label>Endereço completo</label>
                        </div>

                        <div class="input-group">
                            <input type="text" name="bairro_pj" id="bairroJuridica" placeholder="Bairro">
                            <span class="highlight"></span>
                            <label>Bairro</label>
                        </div>

                        <div class="input-group">
                            <input type="text" name="cidade_pj" id="cidadeJuridica" placeholder="Cidade">
                            <span class="highlight"></span>
                            <label>Cidade</label>
                        </div>

                        <div class="input-group">
                            <input type="text" name="complemento_pj" placeholder="Complemento">
                            <span class="highlight"></span>
                            <label>Complemento</label>
                        </div>

                        <div class="input-group">
                            <input type="text" name="referencia_pj" placeholder="Referência">
                            <span class="highlight"></span>
                            <label>Ponto de referência</label>
                            
                        </div>

                        </div>

                        <div class="campo especial">
                        <label class="label-especial">Forma de Pagamento</label>

                        <select name="forma_pagamento_pj">
                            <option value="">Selecione</option>
                            <option value="Débito">Débito</option>
                            <option value="Crédito">Crédito</option>
                            <option value="Boleto">Boleto</option>
                            <option value="Pix">Pix</option>
                            <option value="Dinheiro">Dinheiro</option>
                        </select>


                        </div>  
                
                </div> <!-- fim do form para pessoa juridica -->

                <div id="form-btn-cadastrar" style="display: none;">
                    <input type="submit" name="SendCad" class="btn-cadastrar" value="Cadastrar"></div>
                </div>

            </form> <!-- Fim formulário cadastrar pessoa física ou pessoa jurídica -->
            
        </div> <!-- fim container -->

    <script src="../../js/clientes/cadastrar.js"></script>

    </body>
</html>

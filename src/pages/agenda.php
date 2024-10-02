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
<html lang="pt-br">

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="../style/layout-header.css" rel="stylesheet">
    <link href="../style/agenda.css" rel="stylesheet">

    <link rel="shortcut icon" href="../images/icons/logo.ico" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <title>Calendario</title>
    
</head>

<body>

    <header class="header"> <!-- começo menu fixo no topo -->
    
        <nav class="menu-lateral"> <!-- primeiro item do menu -->

            <input type="checkbox" class="fake-tres-linhas">
            <div><img class="tres-linhas" src="../images/menu-tres-linhas.png" alt="menu de três linhas"></div>

            <ul class="ul">
                <li><a class="link" href="./home.php">ÍNICIO</a></li>
                <li><a class="link" href="./agenda.php">AGENDA</a></li>
                <li><a class="link" href="./finance.php">FINANCEIRO</a></li>
                <li><a class="link" href="./client.php">CLIENTE</a></li>
                <li><a class="link" href="https://WA.me/+5511947295062/?text=Olá, preciso de ajuda com o software." target="_blank">SUPORTE</a></li>
                <li><a class="link" href="../../login/sair.php">SAIR</a></li>
            </ul>

        </nav>

        <nav> <!-- começar com uma nav para definir os itens do menu-->

            <ul class="menu-fixo" style="margin: 0; margin-left: 104px;"> <!-- começo dos itens do menu-->

                <li><a class="link" href="./home.php">ÍNICIO</a></li>
                <li><a class="link" href="./agenda.php">AGENDA</a></li>
                <li><a class="link" href="./finance.php">FINANCEIRO</a></li>
                <li><a class="link" href="./client.php">CLIENTE</a></li>
                <li><a class="link" href="https://WA.me/+5511947295062/?text=Olá, preciso de ajuda com o software." target="_blank">SUPORTE</a></li>

            </ul>

        </nav>

        <div> <!-- finalizar com a logo da empresa na direita-->

            <a class="link" href="https://www.santosedinelli.com.br/" target="_blank">
            <img class="logo" src="../images/santos-dinelli.png"  alt="logo da empresa"></a>

        </div> <!-- final da div da logo-->

    </header> <!-- fim header fixo -->

    <div class="container">

        <span id="msg" class="msg"></span>

        <div id='calendar' class="calendario"></div>

    </div>

    <!-- janela vizu -->
<div class="modal fade calendario" id="visualizarModal" tabindex="-1" aria-labelledby="visualizarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="visualizarModalLabel">Visualizar o Evento</h1>
                <h1 class="modal-title fs-5" id="editarModalLabel" style="display: none;">Editar o Evento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span id="msgViewEvento"></span>
                <div id="visualizarEvento">
                    <dl class="row">
                        <dt class="col-sm-3">ID: </dt>
                        <dd class="col-sm-9" id="visualizar_id">1</dd>      
                        <dt class="col-sm-3">Nome: </dt>
                        <dd class="col-sm-9" id="visualizar_title"></dd>
                        <dt class="col-sm-3">Serviço: </dt>
                        <dd class="col-sm-9" id="visualizar_servico"></dd>
                        <dt class="col-sm-3">Observação: </dt>
                        <dd class="col-sm-9" id="visualizar_obs"></dd>
                        <dt class="col-sm-3">Início: </dt>
                        <dd class="col-sm-9" id="visualizar_start"></dd>
                        <dt class="col-sm-3">Fim: </dt>
                        <dd class="col-sm-9" id="visualizar_end"></dd>
                    </dl>
                    <button type="button" class="btn btn-warning" id="btnViewEditEvento">Editar</button>
                    <button type="button" class="btn btn-danger" id="btnApagarEvento">Apagar</button>
                </div>
                <div id="editarEvento" style="display: none;">
                    <span id="msgEditEvento"></span>
                    <form method="POST" id="formEditEvento">
                        <input type="hidden" name="edit_id" id="edit_id">
                        <div class="row mb-3">
                            <label for="edit_title" class="col-sm-2 col-form-label">Nome</label>
                            <div class="col-sm-10">
                                <input type="text" name="edit_title" class="form-control" id="edit_title" placeholder="Título do evento">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="edit_servico" class="col-sm-2 col-form-label">Serviço</label>
                            <div class="col-sm-10">
                                <select name="edit_servico" class="form-control" id="edit_servico">
                                    <option value="">Selecione</option>
                                    <option value="Venda">Venda</option>
                                    <option value="Instalação">Instalação</option>
                                    <option value="Desinstalação">Desinstalação</option>
                                    <option value="Visita">Visita</option>
                                    <option value="Higienização">Higienização</option>
                                    <option value="Manutenção preventiva">Manutenção preventiva</option>
                                    <option value="Manutenção Corretiva">Manutenção Corretiva</option>
                                    <option value="Laudos">Laudos</option>
                                    <option value="PMOC">PMOC</option>
                                    <option value="Contrato de manutenção preventiva e corretiva">Contrato de manutenção preventiva e corretiva</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="edit_obs" class="col-sm-2 col-form-label">Observação</label>
                            <div class="col-sm-10">
                                <input type="text" name="edit_obs" class="form-control" id="edit_obs" placeholder="Observação do evento">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="edit_start" class="col-sm-2 col-form-label">Início</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" name="edit_start" class="form-control" id="edit_start">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="edit_end" class="col-sm-2 col-form-label">Fim</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" name="edit_end" class="form-control" id="edit_end">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="edit_color" class="col-sm-2 col-form-label">Cor</label>
                            <div class="col-sm-10">
                                <select name="edit_color" class="form-control" id="edit_color">
                                    <option value="">Selecione</option>
                                    <option style="color:#FFD700;" value="#FFD700">Amarelo</option>
                                    <option style="color:#0071c5;" value="#0071c5">Azul Turquesa</option>
                                    <option style="color:#FF4500;" value="#FF4500">Laranja</option>
                                    <option style="color:#8B4513;" value="#8B4513">Marrom</option>
                                    <option style="color:#1C1C1C;" value="#1C1C1C">Preto</option>
                                    <option style="color:#436EEE;" value="#436EEE">Royal Blue</option>
                                    <option style="color:#A020F0;" value="#A020F0">Roxo</option>
                                    <option style="color:#40E0D0;" value="#40E0D0">Turquesa</option>
                                    <option style="color:#228B22;" value="#228B22">Verde</option>
                                    <option style="color:#8B0000;" value="#8B0000">Vermelho</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" name="btnViewEvento" class="btn btn-primary" id="btnViewEvento">Cancelar</button>
                        <button type="submit" name="btnEditEvento" class="btn btn-warning" id="btnEditEvento">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- janela cadastra -->
    <div class="modal fade" id="cadastrarModal" tabindex="-1" aria-labelledby="cadastrarModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="cadastrarModalLabel">Cadastrar o Serviço</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <span id="msgCadEvento"></span>

                    <form method="POST" id="formCadEvento">

                        <div class="row mb-3">

                            <label for="cad_title" class="col-sm-2 col-form-label">Cliente</label>

                            <div class="col-sm-10">
                                <input type="text" name="cad_title" class="form-control" id="cad_title" placeholder="Nome do Cliente" required>
                            </div>

                        </div>

                        <div class="row mb-3">

                            <label for="cad_servico" class="col-sm-2 col-form-label">Serviço</label>

                            <div class="col-sm-10">

                                <select name="cad_servico" class="form-control" id="cad_servico">
                                    <option  value="">Selecione</option>
                                    <option  value="Venda">Venda</option>
                                    <option  value="Instalação">Instalação</option>
                                    <option  value="Desinstalação">Desinstalação</option>
                                    <option  value="Visita">Visita</option>
                                    <option  value="Higienização">Higienização</option>
                                    <option  value="Manutenção preventiva">Manutenção preventiva</option>
                                    <option  value="Manutenção Corretiva">Manutenção Corretiva</option>
                                    <option  value="Laudos">Laudos</option>
                                    <option  value="PMOC">PMOC</option>
                                    <option  value="Contrato de manutenção preventiva e corretiva">Contrato de manutenção preventiva e corretiva</option>
                                </select>

                            </div>

                        </div>

                        <div class="row mb-3">

                            <label for="cad_obs" class="col-sm-2 col-form-label">Observação</label>

                            <div class="col-sm-10">
                                <input type="text" name="cad_obs" class="form-control" id="cad_obs" placeholder="Observação do Serviço" required>
                            </div>

                            

                        </div>

                        <div class="row mb-3">

                            <label for="cad_start" class="col-sm-2 col-form-label">Início</label>

                            <div class="col-sm-10">
                                <input type="datetime-local" name="cad_start" class="form-control" id="cad_start" required>
                            </div>

                        </div>

                        <div class="row mb-3">

                            <label for="cad_end" class="col-sm-2 col-form-label">Fim</label>

                            <div class="col-sm-10">
                                <input type="datetime-local" name="cad_end" class="form-control" id="cad_end" required>
                            </div>

                        </div>

                        <div class="row mb-3">

                            <label for="cad_color" class="col-sm-2 col-form-label">Cor</label>

                            <div class="col-sm-10">

                                <select name="cad_color" class="form-control" id="cad_color" required>
                                    <option value="">Selecione</option>
                                    <option style="color:#FFD700;" value="#FFD700">Amarelo</option>
                                    <option style="color:#0071c5;" value="#0071c5">Azul Turquesa</option>
                                    <option style="color:#FF4500;" value="#FF4500">Laranja</option>
                                    <option style="color:#8B4513;" value="#8B4513">Marrom</option>
                                    <option style="color:#1C1C1C;" value="#1C1C1C">Preto</option>
                                    <option style="color:#436EEE;" value="#436EEE">Royal Blue</option>
                                    <option style="color:#A020F0;" value="#A020F0">Roxo</option>
                                    <option style="color:#40E0D0;" value="#40E0D0">Turquesa</option>
                                    <option style="color:#228B22;" value="#228B22">Verde</option>
                                    <option style="color:#8B0000;" value="#8B0000">Vermelho</option>
                                </select>

                            </div>

                        </div>

                        <button type="submit" name="btnCadEvento" class="btn btn-success" id="btnCadEvento">Cadastrar</button>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src='../js/index.global.min.js'></script>
    <script src="../js/bootstrap5/index.global.min.js"></script>
    <script src='../js/core/locales-all.global.min.js'></script>
    <script src='../js/custom.js'></script>


</body>

</html>
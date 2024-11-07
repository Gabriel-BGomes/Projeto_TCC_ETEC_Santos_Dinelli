<?php

// Incluir o arquivo com a conexão com banco de dados
include_once './conexao.php';

// Habilitar relatório de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Receber os dados enviados
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// Validar os dados recebidos
$dados = array_map('trim', $dados);

// Query para editar o evento no banco de dados
$query_event = "UPDATE events SET title=:title, color=:color, start=:start, end=:end, obs=:obs, servico=:servico WHERE id=:id";

// Preparar a query
$edit_event = $conn->prepare($query_event);

// Substituir os links pelos valores
$edit_event->bindParam(':title', $dados['edit_title']);
$edit_event->bindParam(':color', $dados['edit_color']);
$edit_event->bindParam(':start', $dados['edit_start']);
$edit_event->bindParam(':end', $dados['edit_end']);
$edit_event->bindParam(':obs', $dados['edit_obs']);
$edit_event->bindParam(':servico', $dados['edit_servico']);
$edit_event->bindParam(':id', $dados['edit_id']);

// Executar a query
if ($edit_event->execute()) {
    $retorna = [
        'status' => true, 
        'msg' => 'Serviço editado com sucesso!',
        'id' => $dados['edit_id'],
        'title' => $dados['edit_title'],
        'color' => $dados['edit_color'],
        'start' => $dados['edit_start'],
        'end' => $dados['edit_end'],
        'obs' => $dados['edit_obs'],
        'servico' => $dados['edit_servico']
    ];
} else {
    $retorna = ['status' => false, 'msg' => 'Erro: Serviço não editado!'];
}

// Retornar os dados para o JavaScript
echo json_encode($retorna);
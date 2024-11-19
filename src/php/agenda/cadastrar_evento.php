<?php
include_once './conexao.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$query_cad_event = "INSERT INTO events (title, color, start, end, obs, servico, id_cliente) VALUES (:title, :color, :start, :end, :obs, :servico, :id_cliente)";

$cad_event = $conn->prepare($query_cad_event);

$cad_event->bindParam(':title', $dados['cad_title']);
$cad_event->bindParam(':color', $dados['cad_color']);
$cad_event->bindParam(':start', $dados['cad_start']);
$cad_event->bindParam(':end', $dados['cad_end']);
$cad_event->bindParam(':obs', $dados['cad_obs']);
$cad_event->bindParam(':servico', $dados['cad_servico']);
$cad_event->bindParam(':id_cliente', $dados['cad_id_cliente']);

if ($cad_event->execute()) {
    $retorna = [
        'status' => true,
        'msg' => 'Serviço cadastrado com sucesso!',
        'id' => $conn->lastInsertId(),
        'title' => $dados['cad_title'],
        'color' => $dados['cad_color'],
        'start' => $dados['cad_start'],
        'end' => $dados['cad_end'],
        'obs' => $dados['cad_obs'],
        'servico' => $dados['cad_servico'],
        'id_cliente' => $dados['cad_id_cliente']
    ];
} else {
    $retorna = ['status' => false, 'msg' => 'Erro: Serviço não cadastrado!'];
}

echo json_encode($retorna);
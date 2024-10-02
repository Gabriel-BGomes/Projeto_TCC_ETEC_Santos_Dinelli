<?php

// conexao banco coco
include_once './conexao.php';

// receber os dados enviado pelo JavaScript
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// query cadastrar no banco
$query_cad_event = "INSERT INTO events (title, color, start, end, obs) VALUES (:title, :color, :start, :end, :obs)";

// prepara a QUERY
$cad_event = $conn->prepare($query_cad_event);

// substituir o link pelo valor
$cad_event->bindParam(':title', $dados['cad_title']);
$cad_event->bindParam(':color', $dados['cad_color']);
$cad_event->bindParam(':start', $dados['cad_start']);
$cad_event->bindParam(':end', $dados['cad_end']);
$cad_event->bindParam(':obs', $dados['cad_obs']);

// verificar se consegui cadastrar corretamente
if ($cad_event->execute()) {
    $retorna = ['status' => true, 'msg' => 'Evento cadastrado com sucesso!', 'id' => $conn->lastInsertId(), 'title' => $dados['cad_title'], 'color' => $dados['cad_color'], 'start' => $dados['cad_start'], 'end' => $dados['cad_end'], 'obs' => $dados['cad_obs']];
} else {
    $retorna = ['status' => false, 'msg' => 'Erro: Evento não cadastrado!'];
}

// converter o array em objeto e retornar para o JavaScript
echo json_encode($retorna);
<?php

// conexao banco coco
include_once './conexao.php';

// receber o id enviado pelo JavaScript
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Acessa o IF quando exite o id do evento
if (!empty($id)) {

    // query apagao 
    $query_apagar_event = "DELETE FROM events WHERE id=:id";

    // repara a QUERY
    $apagar_event = $conn->prepare($query_apagar_event);

    // substituir o link pelo valor
    $apagar_event->bindParam(':id', $id);

    // verificar se consegui apagar corretamente
    if($apagar_event->execute()){
        $retorna = ['status' => true, 'msg' => 'Serviço apagado com sucesso!'];
    }else{
        $retorna = ['status' => false, 'msg' => 'Erro: Serviço não apagado!'];
    }

} else { // acessa o ELSE quando o id está vazio
    $retorna = ['status' => false, 'msg' => 'Erro: Necessário enviar o id do serviço!'];
}

// converter o array em objeto e retornar para o JavaScript
echo json_encode($retorna);
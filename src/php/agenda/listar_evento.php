<?php

// Incluir o arquivo com a conexão com banco de dados
include_once './conexao.php';

// QUERY para recuperar os eventos
$query_events = "SELECT id, title, color, start, end, obs, servico FROM events";

// Preparar a QUERY
$result_events = $conn->prepare($query_events);

// Executar a QUERY
$result_events->execute();

// Criar o array que recebe os eventos
$eventos = [];

// Percorrer a lista de registros retornados do banco de dados
while($row_events = $result_events->fetch(PDO::FETCH_ASSOC)){
    // Extrair o array
    extract($row_events);

    $eventos[] = [
        'id' => $id,
        'title' => $title,
        'color' => $color,
        'start' => $start,
        'end' => $end,
        'extendedProps' => [
            'obs' => $obs,
            'servico' => $servico
        ]
    ];
}

// Converter o array em objeto JSON e retornar para o JavaScript
echo json_encode($eventos);
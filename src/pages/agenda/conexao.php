<?php

// conexao legal
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "teste2";
$port = 3306;

try {
    // conexão com a porta
    //$conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $pass);

    //conexão sem a porta
    $conn = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);
    //=echo "Conexão com banco de dados realizado com sucesso.";
} catch (PDOException $err) {
    die("Erro: Conexão com banco de dados não realizado com sucesso. Erro gerado " . $err->getMessage());
}
    // fim da conexão com o banco de dados utilizando PDO

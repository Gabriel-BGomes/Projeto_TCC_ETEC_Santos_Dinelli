<?php 

// Criptografando a senha usando bcrypt
$senhaCriptografada = password_hash('123456', PASSWORD_BCRYPT);

// Exibe a senha criptografada
echo "Senha criptografada: " . $senhaCriptografada;

?>
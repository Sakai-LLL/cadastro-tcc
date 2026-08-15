<?php

// Importa a classe Usuario
require "Usuario.class.php";

// Cria o objeto
$usuario = new Usuario();

// Conecta ao banco
$usuario->conecta();


// Pega os dados enviados pelo formulário
$id = $_POST['id'];
$cnpj = $_POST['cnpj'];
$email = $_POST['email'];
$senha = $_POST['senha'];


// Altera os dados do usuário
$usuario->alterarUsuarios($id, $cnpj, $email, $senha);


// Volta para a tabela
header("Location: tabela.php");
exit();

?>
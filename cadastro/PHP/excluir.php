<?php

// Importa a classe Usuario
require "Usuario.class.php";

// Cria o objeto
$usuario = new Usuario();

// Conecta ao banco
$usuario->conecta();


// Verifica se o ID foi informado
if(isset($_GET['id'])){

    // Pega o ID
    $id = $_GET['id'];

} else {

    // Mostra erro
    echo "ID não informado. Impossível excluir o usuário";
    exit();
}


// Exclui o usuário
$usuario->excluirUsuario($id);


// Volta para a tabela
header("Location: tabela.php");
exit();

?>
<?php

// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if(isset($_SESSION['cnpj'])){

    // Já está logado, vai direto pra home
    header("Location: home.php");
    exit;

} else {

    // Não está logado, vai pro login
    header("Location: login.php");
    exit;
}

?>

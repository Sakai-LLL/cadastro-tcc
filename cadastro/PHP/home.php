<?php

// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if(isset($_SESSION['cnpj'])){

    // Pega o CNPJ da sessão
    $cnpj = $_SESSION['cnpj'];

    // Mostra uma mensagem
    echo "Olá, CNPJ: ", $cnpj;

} else {

    // Usuário não está logado
    echo "Você precisa estar logado!!!";
}
?>
<?php

// Inicia a sessão
session_start();

// Importa a classe Usuario
require "Usuario.class.php";

// Verifica se os campos foram enviados
if(isset($_POST['cnpj'], $_POST['email'], $_POST['senha'])){

    // Pega os dados do formulário
    $cnpj = $_POST['cnpj'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Cria o objeto
    $usuario = new Usuario();

    // Conecta ao banco
    $usuario->conecta();


    // Verifica se o usuário existe
    if($usuario->checkUser($email)){

        // Verifica a senha
        if($usuario->checkPass($email, $senha)){

            // Salva o CNPJ na sessão
            $_SESSION['cnpj'] = $cnpj;

            // Vai para a página inicial
            header("Location: home.php");
            exit;

        } else {

            // Senha incorreta
            echo "Senha incorreta!";
        }

    } else {

        // Usuário não cadastrado
        echo "Usuário não cadastrado!";
    }

} else {

    // Campos não preenchidos
    echo "Preencha todos os campos!";
}

?>
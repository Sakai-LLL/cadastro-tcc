```php
<?php

// Inicia a sessão
session_start();

// Importa a classe Usuario
require "Usuario.class.php";

// Cria um objeto Usuario
$usuario = new Usuario();

// Verifica se os campos foram enviados
if(isset($_POST['cnpj'], $_POST['email'], $_POST['senha'])){

    // Pega os dados do formulário
    $cnpj  = $_POST['cnpj'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Conecta ao banco
    $conn = $usuario->conecta();
    
    // Verifica se conectou
    if($conn){

        // Verifica se o usuário já existe
        $user = $usuario->checkUser($email);

        // Se não existir, cadastra
        if(!$user){

            // Insere o usuário no banco
            $user = $usuario->inserirUsuario($cnpj, $email, $senha);

            // Verifica se cadastrou
            if($user){

                // Salva o CNPJ na sessão
                $_SESSION['cnpj'] = $cnpj;

                // Vai para a página inicial
                header("Location: home.php");
                exit;

            } else {

                // Mostra erro no cadastro
                echo "Erro ao cadastrar o usuário";
            }

        } else {

            // Usuário já existe
            echo "Usuário já cadastrado. Faça login";
            exit();
        }

    } else {

        // Erro na conexão
        echo "Banco indisponível, tente mais tarde!";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Configura os caracteres -->
    <meta charset="UTF-8">

    <!-- Adapta a página para celular -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Nome da página -->
    <title>Cadastrar Usuario</title>

</head>

<body>

    <!-- Título -->
    <h2>Cadastro de Usuario</h2>

    <!-- Formulário -->
    <form action="" method="post">

        <!-- Campo CNPJ -->
        <input type="text" name="cnpj" placeholder="CNPJ:" required>
        <br>

        <!-- Campo email -->
        <input type="email" name="email" placeholder="Email:" required>
        <br>

        <!-- Campo senha -->
        <input type="password" name="senha" placeholder="Senha:" required>
        <br>

        <!-- Botão cadastrar -->
        <input type="submit" name="botao" value="Cadastrar">

    </form> 
    
</body>
</html>
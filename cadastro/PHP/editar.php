```php
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

    // Mostra erro se não tiver ID
    echo "ID não informado. Impossível editar o usuário";
    exit();
}


// Busca os dados do usuário
$dados = $usuario->localizarUsuario($id);

?>

<!DOCTYPE html>
<html>

<head>

    <!-- Configura os caracteres -->
    <meta charset="UTF-8">

    <!-- Título da página -->
    <title>Alteração de Usuário</title>

</head>

<body>

    <!-- Título -->
    <h2>Alteração de Usuário</h2>


    <!-- Formulário de alteração -->
    <form action="editar_submit.php" method="post">

        <!-- Guarda o ID do usuário -->
        <input type="hidden" name="id" value="<?=$dados['id']?>">


        <!-- Campo CNPJ -->
        <input type="text"
               name="cnpj"
               value="<?=$dados['cnpj']?>"
               placeholder="Informe o CNPJ"
               required>
        <br>


        <!-- Campo email -->
        <input type="email"
               name="email"
               value="<?=$dados['email']?>"
               placeholder="Informe o email"
               required>
        <br>


        <!-- Campo senha -->
        <input type="password"
               name="senha"
               value="<?=$dados['senha']?>"
               placeholder="Informe sua senha"
               required>
        <br>


        <!-- Botão de alterar -->
        <input type="submit" value="Alterar">

    </form>

</body>
</html>
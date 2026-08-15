<?php

// Inicia a sessão
session_start();

// Importa a classe Usuario
require "Usuario.class.php";

// Mensagem de erro para mostrar na tela
$erro = "";

// Verifica se os campos foram enviados
if(isset($_POST['email'], $_POST['senha'])){

    // Pega os dados do formulário
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

            // Busca os dados completos do usuário pra pegar o CNPJ
            $dados = $usuario->localizarPorEmail($email);

            // Salva o CNPJ e o email na sessão
            $_SESSION['cnpj']  = $dados['cnpj'];
            $_SESSION['email'] = $email;

            // Vai para a página inicial
            header("Location: home.php");
            exit;

        } else {

            // Senha incorreta
            $erro = "Senha incorreta!";
        }

    } else {

        // Usuário não cadastrado
        $erro = "Usuário não cadastrado!";
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
    <title>GestMax - Login</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #a9c6e8;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .card {
            background: #ffffff;
            width: 360px;
            border-radius: 20px;
            box-shadow: 0 6px 24px rgba(0,0,0,0.15);
            overflow: hidden;
            padding: 24px;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .brand {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .brand-icon {
            height: 40px;
            width: auto;
            display: block;
        }

        .brand-name {
            font-weight: 700;
            font-size: 13px;
            color: #0a2540;
            margin-top: 2px;
        }
        .brand-name span { color: #2196c9; }

        h1.titulo {
            font-size: 20px;
            color: #222;
            margin: 0;
        }

        .campo {
            margin-bottom: 14px;
        }

        .campo label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .campo input {
            width: 100%;
            padding: 9px 10px;
            border: 1px solid #bbb;
            border-radius: 20px;
            font-size: 13px;
        }
        .campo input:focus {
            outline: none;
            border-color: #2980b9;
            box-shadow: 0 0 0 2px rgba(41,128,185,0.15);
        }

        .esqueci-senha {
            display: block;
            text-align: center;
            font-size: 13px;
            color: #2980b9;
            margin: 22px 0;
            text-decoration: underline;
        }
        .esqueci-senha:hover { color: #1c5d85; }

        .entrar-btn {
            width: 100%;
            padding: 10px 0;
            border: 1px solid #999;
            border-radius: 20px;
            background: #f5f5f5;
            font-size: 14px;
            font-weight: 600;
            color: #222;
            cursor: pointer;
        }
        .entrar-btn:hover { background: #ececec; }

        .msg-erro {
            background: #fdecea;
            color: #b71c1c;
            border: 1px solid #f5c6cb;
            padding: 8px 10px;
            border-radius: 4px;
            font-size: 12px;
            margin-bottom: 14px;
        }
    </style>

</head>

<body>

    <div class="card">

        <!-- Cabeçalho com logo e título -->
        <div class="card-header">
            <div class="brand">
                <img src="logo-icon.png" alt="GestMax" class="brand-icon">
                <div class="brand-name">Gest<span>Max</span></div>
            </div>
            <h1 class="titulo">Login</h1>
        </div>

        <!-- Mensagem de erro, se houver -->
        <?php if ($erro): ?>
            <div class="msg-erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <!-- Formulário -->
        <form action="" method="post">

            <!-- Campo email -->
            <div class="campo">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="seuemail@empresa.com" required>
            </div>

            <!-- Campo senha -->
            <div class="campo">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            <!-- Esqueci minha senha -->
            <a class="esqueci-senha" href="esqueci_senha.php">Esqueci Minha Senha</a>

            <!-- Botão entrar -->
            <input type="submit" name="botao" value="Entrar" class="entrar-btn">

        </form>

    </div>

</body>
</html>

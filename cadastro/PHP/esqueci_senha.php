<?php

// Importa a classe Usuario
require "Usuario.class.php";

// Mensagem de erro/sucesso pra mostrar na tela
$erro = "";
$sucesso = "";

// Verifica se os campos foram enviados
if(isset($_POST['cnpj'], $_POST['email'], $_POST['nova_senha'], $_POST['confirmar_senha'])){

    // Pega os dados do formulário
    $cnpj            = $_POST['cnpj'];
    $email           = $_POST['email'];
    $novaSenha       = $_POST['nova_senha'];
    $confirmarSenha  = $_POST['confirmar_senha'];

    // Verifica se as duas senhas digitadas são iguais
    if($novaSenha !== $confirmarSenha){

        $erro = "As senhas digitadas não conferem.";

    } else {

        // Cria o objeto
        $usuario = new Usuario();

        // Conecta ao banco
        $conn = $usuario->conecta();

        if($conn){

            // Busca o usuário pelo email
            $dados = $usuario->localizarPorEmail($email);

            // Verifica se encontrou o usuário e se o CNPJ confere
            if($dados && $dados['cnpj'] === $cnpj){

                // Atualiza a senha (mantendo cnpj e email como estavam)
                $alterou = $usuario->alterarUsuarios($dados['id'], $cnpj, $email, $novaSenha);

                if($alterou){
                    $sucesso = "Senha alterada com sucesso! Você já pode fazer login.";
                } else {
                    $erro = "Não foi possível alterar a senha. Tente novamente.";
                }

            } else {

                // Email ou CNPJ não batem com nenhum cadastro
                $erro = "Email ou CNPJ não encontrados.";
            }

        } else {

            $erro = "Banco indisponível, tente mais tarde!";
        }
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
    <title>GestMax - Esqueci Minha Senha</title>

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
            margin-bottom: 6px;
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
            font-size: 17px;
            color: #222;
            margin: 0;
        }

        .subtitulo {
            font-size: 12px;
            color: #666;
            margin: 0 0 18px 0;
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

        .voltar-login {
            display: block;
            text-align: center;
            font-size: 13px;
            color: #2980b9;
            margin: 18px 0 0 0;
            text-decoration: underline;
        }
        .voltar-login:hover { color: #1c5d85; }

        .confirmar-btn {
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
        .confirmar-btn:hover { background: #ececec; }

        .msg-erro {
            background: #fdecea;
            color: #b71c1c;
            border: 1px solid #f5c6cb;
            padding: 8px 10px;
            border-radius: 4px;
            font-size: 12px;
            margin-bottom: 14px;
        }

        .msg-sucesso {
            background: #eafaf0;
            color: #1e7e34;
            border: 1px solid #c3e6cb;
            padding: 8px 10px;
            border-radius: 20px;
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
            <h1 class="titulo">Esqueci Minha Senha</h1>
        </div>
        <p class="subtitulo">Confirme seus dados para cadastrar uma nova senha.</p>

        <!-- Mensagem de erro, se houver -->
        <?php if ($erro): ?>
            <div class="msg-erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <!-- Mensagem de sucesso, se houver -->
        <?php if ($sucesso): ?>
            <div class="msg-sucesso"><?= htmlspecialchars($sucesso) ?></div>
        <?php endif; ?>

        <!-- Só mostra o formulário se ainda não deu certo -->
        <?php if (!$sucesso): ?>
        <form action="" method="post">

            <!-- Campo CNPJ -->
            <div class="campo">
                <label for="cnpj">CNPJ:</label>
                <input type="text" id="cnpj" name="cnpj" placeholder="00.000.000/0000-00" required>
            </div>

            <!-- Campo email -->
            <div class="campo">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="seuemail@empresa.com" required>
            </div>

            <!-- Nova senha -->
            <div class="campo">
                <label for="nova_senha">Nova senha:</label>
                <input type="password" id="nova_senha" name="nova_senha" required>
            </div>

            <!-- Confirmar nova senha -->
            <div class="campo">
                <label for="confirmar_senha">Confirmar nova senha:</label>
                <input type="password" id="confirmar_senha" name="confirmar_senha" required>
            </div>

            <!-- Botão confirmar -->
            <input type="submit" name="botao" value="Alterar Senha" class="confirmar-btn">

        </form>
        <?php endif; ?>

        <!-- Voltar pro login -->
        <a class="voltar-login" href="login.php">Voltar para o login</a>

    </div>

</body>
</html>

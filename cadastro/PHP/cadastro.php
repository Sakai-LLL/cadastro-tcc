<?php
 
// Inicia a sessão
session_start();
 
// Importa a classe Usuario
require "Usuario.class.php";
 
// Cria um objeto Usuario
$usuario = new Usuario();
 
// Mensagem de erro para mostrar na tela
$erro = "";
 
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
                $erro = "Erro ao cadastrar o usuário";
            }
 
        } else {
 
            // Usuário já existe
            $erro = "Usuário já cadastrado. Faça login";
        }
 
    } else {
 
        // Erro na conexão
        $erro = "Banco indisponível, tente mais tarde!";
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
    <title>GestMax - Cadastro</title>
 
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
        }
 
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px 0 20px;
        }
 
        .brand {
            display: flex;
            align-items: center;
            gap: 8px;
        }
 
        .brand-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #16a085, #2980b9);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: bold;
            font-size: 16px;
        }
 
        .brand-name {
            font-weight: 700;
            font-size: 16px;
            color: #222;
        }
        .brand-name span { color: #2980b9; }
 
        .entrar-btn {
            border: 1px solid #ccc;
            background: #f5f5f5;
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 12px;
            color: #333;
            cursor: pointer;
            text-decoration: none;
        }
        .entrar-btn:hover { background: #ebebeb; }
 
        h1.titulo {
            text-align: center;
            font-size: 18px;
            margin: 6px 0 18px 0;
            color: #222;
        }
 
        form { padding: 0 24px 24px 24px; }
 
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
 
        .abas {
            display: flex;
            gap: 8px;
            margin: 18px 0;
        }
 
        .abas span {
            flex: 1;
            text-align: center;
            padding: 8px 0;
            border: 1px solid #bbb;
            border-radius: 20px;
            font-size: 13px;
            color: #333;
            background: #fff;
        }
        .abas span.ativa {
            background: #eaf2fa;
            border-color: #2980b9;
            color: #2980b9;
            font-weight: 600;
        }
 
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
            margin: 0 24px 14px 24px;
        }
    </style>
 
</head>
 
<body>
 
    <div class="card">
 
        <!-- Cabeçalho com logo e botão entrar -->
        <div class="card-header">
            <div class="brand">
                <img src="logo-icon.png" alt="GestMax" class="brand-icon">
                <div class="brand-name">Gest<span>Max</span></div>
            </div>
            <a class="entrar-btn" href="login.php">entrar</a>
        </div>
 
        <!-- Título -->
        <h1 class="titulo">Cadastro</h1>
 
        <!-- Mensagem de erro, se houver -->
        <?php if ($erro): ?>
            <div class="msg-erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>
 
        <!-- Formulário -->
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
 
            <!-- Campo senha -->
            <div class="campo">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
 
            <!-- Abas (etapa 1 de 2) -->
            <div class="abas">
                <span class="ativa">1</span>
                <span>2</span>
            </div>
 
            <!-- Botão cadastrar -->
            <input type="submit" name="botao" value="Confirmar" class="confirmar-btn">
 
        </form>
 
    </div>
 
</body>
</html>
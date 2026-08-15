```php
<?php

// Cria a classe Usuario
class Usuario{

    // Dados do usuário
    private $id;
    private $email;
    private $cnpj;
    private $senha;
    private $pdo;


    // Conecta ao banco
    public function conecta() {

        // Dados do banco
        $dns = "mysql:dbname=etimUsuario;host=localhost";
        $userCnpj = "root";
        $userPass = "";

        // Tenta conectar
        try {

            // Cria a conexão
            $this->pdo = new PDO($dns, $userCnpj, $userPass);

            // Conexão deu certo
            return true;

        } catch (Throwable $th) {

            // Conexão deu errado
            return false;
        }
    }


    // Cadastra um usuário
    public function inserirUsuario($cnpj, $email, $senha){  

        // Comando para inserir no banco
        $sql = "INSERT INTO usuario SET cnpj = :c, email = :e, senha = :s";

        // Prepara o comando
        $stmt = $this->pdo->prepare($sql);

        // Passa os valores
        $stmt->bindValue(":e", $email);
        $stmt->bindValue(":c", $cnpj);
        $stmt->bindValue(":s", $senha);

        // Executa o cadastro
        return $stmt->execute();
    }


    // Verifica se o usuário existe
    public function checkUser($email){

        // Procura o email no banco
        $sql = "SELECT * FROM usuario WHERE email = :e";

        // Prepara o comando
        $stmt = $this->pdo->prepare($sql);

        // Passa o email
        $stmt->bindValue(":e", $email);

        // Executa a busca
        $stmt->execute();

        // Retorna true se encontrar
        return $stmt->rowCount() > 0;
    }


   // Verifica CNPJ, email e senha
    public function checkPass($cnpj, $email, $senha){

    // Procura os três dados no banco
    $sql = "SELECT * FROM usuario WHERE cnpj = :c AND email = :e AND senha = :s";

    // Prepara o comando
    $stmt = $this->pdo->prepare($sql);

    // Passa os valores
    $stmt->bindValue(":c", $cnpj);
    $stmt->bindValue(":e", $email);
    $stmt->bindValue(":s", $senha);

    // Executa a busca
    $stmt->execute();

    // Retorna true se encontrar
    return $stmt->rowCount() > 0;
    }


    // Lista todos os usuários
    public function listarUsuarios(){

        // Busca todos os usuários
        $sql = "SELECT * FROM usuario";

        // Prepara o comando
        $stmt = $this->pdo->prepare($sql);

        // Executa a busca
        $stmt->execute();

        // Retorna os usuários encontrados
        return $stmt->fetchAll();
    }


    // Altera os dados do usuário
    public function alterarUsuarios($id, $cnpj, $email, $senha){

        // Comando para alterar
        $sql = "UPDATE usuario SET cnpj = :c, email = :e, senha = :s WHERE id = :i";

        // Prepara o comando
        $stmt = $this->pdo->prepare($sql);

        // Passa os valores
        $stmt->bindValue(":c", $cnpj);
        $stmt->bindValue(":e", $email);
        $stmt->bindValue(":s", $senha);
        $stmt->bindValue(":i", $id);

        // Executa a alteração
        return $stmt->execute();
    }


    // Procura um usuário pelo ID
    public function localizarUsuario($id){

        // Busca o usuário pelo ID
        $sql = "SELECT * FROM usuario WHERE id = :i";

        // Prepara o comando
        $stmt = $this->pdo->prepare($sql);

        // Passa o ID
        $stmt->bindValue(":i", $id);

        // Executa a busca
        $stmt->execute();

        // Retorna o usuário encontrado
        return $stmt->fetch();
    }

    // Exclui um usuário
public function excluirUsuario($id){

    // Comando para excluir
    $sql = "DELETE FROM usuario WHERE id = :i";

    // Prepara o comando
    $stmt = $this->pdo->prepare($sql);

    // Passa o ID
    $stmt->bindValue(":i", $id);

    // Executa a exclusão
    return $stmt->execute();
}
}

?>
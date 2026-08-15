<?php
require "Usuario.class.php";
$usuario = new Usuario();

$con = $usuario->conecta();

if($con){
    $user = $usuario->listarUsuarios();
    if(empty($user)){
        echo "Não ha usuarios para listar!";
    }else{
        ?>
            <style>
        table {
            border-collapse: collapse;
            width: 600px;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        a {
            color: blue;
        }
    </style>

        <table>
            <tr>
                <th>Código</th>
                <th>CNPJ</th>
                <th>Email</th>
                <th colspan="2">Ações</th>
            </tr>
            <?php
            foreach($user as $item){
                $id = $item['id'];
                $cnpj = $item['cnpj'];
                $email = $item['email'];
            ?>

            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['cnpj']; ?></td>
                <td><?php echo $item['email']; ?></td>
                <td><a href="editar.php?id=<?php echo $item['id']; ?>">Editar</a></td>
                <td><a href="excluir.php?id=<?php echo $item['id']; ?>">Excluir</a></td>
            <tr>
            <?php
        }
        ?>
    </table>
    <?php
    }
}else{
    echo "Banco indisponivel. Tente mais tarde!";
}
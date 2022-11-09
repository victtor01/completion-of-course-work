<?php
include('conexao.PHP');

class fornecedor
{
    function cadastrar(){
        include('conexao.php');

        $nome_fornecedor = $_POST['nome_fornecedor'];
        $email_fornecedor = $_POST['email_fornecedor'];
        $telefone_fornecedor = $_POST['telefone_fornecedor'];
    
        $sql_inserir = "INSERT INTO fornecedor(nome, email, telefone) VALUES ('$nome_fornecedor','$email_fornecedor','$telefone_fornecedor')";
        $inserir = mysqli_query($conexao, $sql_inserir);
    
        header('Location: ../HTML/categoria.php');
        die();
    }
    function editar(){
        include_once('conexao.php');
        $id = $_GET['id_fornecedor'];
        $sql_select = "SELECT * FROM fornecedor WHERE id_fornecedor=$id";
        $result = $conexao->query($sql_select);
    
       if($result->num_rows > 0) {
            while($user_data = mysqli_fetch_assoc($result)){
                $nome_fornecedor = $user_data['nome'];
                $email_fornecedor = $user_data['email'];
                $telefone = $user_data['telefone'];
            }
    
        }
        else {
            header('Location: ../categoria-fornecedor.php');
        }
    }
}

if(isset($_POST['nome_fornecedor']) && isset($_POST['cadastrar-fornecedor'])){
    $fornecedor = new fornecedor;
    $fornecedor->cadastrar();
}

if(!empty($_GET['id_fornecedor'])){
   $fornecedor = new fornecedor;
   $fornecedor->editar();
}

?>
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
    
        header('Location: ../HTML/fornecedores.php');
        die();
    }
    function editar(){
        include('conexao.php');

        $id = $_POST['id'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $nome = $_POST['nome'];

        $sql = "UPDATE fornecedor SET nome='$nome', email='$email', telefone='$telefone' WHERE id_fornecedor=$id";
        $result = $conexao->query($sql);

        header('Location: ../HTML/fornecedores.php');
        die();

    }
    function delete($id){
        include('conexao.php');
        $sql  = "DELETE FROM fornecedor WHERE id_fornecedor = {$id}";
        $query = $conexao->query($sql);
    }
}

if(isset($_POST['nome_fornecedor']) && isset($_POST['cadastrar-fornecedor'])){
    $fornecedor = new fornecedor;
    $fornecedor->cadastrar();
}

if(!empty($_GET['id_fornecedor'])){
   $fornecedor = new fornecedor;
   $fornecedor->delete($_GET['id_fornecedor']);
}

if(isset($_POST['id']))
{
    $id = $_POST['id'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nome = $_POST['nome'];

    $fornecedor = new fornecedor;
    $fornecedor->editar();
}
?>
<?php
session_start();
$_SESSION['cargo'];
$cargo = intval($_SESSION['cargo']);

if($cargo != 1){
    include 'links.php';
    header('Location:' . $this->link_painel);
    die();
}

include 'links.php';

class funcionario extends links{
    function inserir(){

        $foto = $_FILES['foto'];
        $nome = $_POST['nome'];
        $CPF = $_POST['CPF'];
        $cargo = $_POST['cargo'];
        $data_nascimento = $_POST['data'];
        $salario = $_POST['salario'];
        $contato = $_POST['contato'];
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);;
        $senha = strval($_POST['senha']);
        $confirmar_senha= $_POST['confirmar_senha'];

        if($senha != $confirmar_senha){
            header('Location: ' . $this->link_funcionarios);
            die("senha errada");
        }
        $pasta = "../imagens/imagens-fun/";
        $imagem = uniqid();
        $imagem_nome = $foto['name'];
        $extensao = strtolower(pathinfo($imagem_nome, PATHINFO_EXTENSION));
        echo $criptografy = password_hash($senha, PASSWORD_DEFAULT);

        if($extensao != 'jpg' &&  $extensao != 'png' ) { header('Location: ../HTML/funcionarios.html'); die(); }
        else{ $patch = $pasta . $imagem . "." . $extensao;  $move = move_uploaded_file($foto["tmp_name"], $patch); }

        if($move)
        {
            include_once('conexao.PHP');              
            $sql = "INSERT INTO funcionarios(nome, CPF, cargo, data_nascimento, foto, salario, contato, email, senha) 
            VALUES ('$nome', '$CPF', '$cargo', '$data_nascimento', '$patch', '$salario', '$contato', '$email', '$criptografy')";
            $conexao->query($sql); 
        }

        header('Location: ' . $this->link_funcionarios);
        die();
        
    }
    function mostrar_funcionarios(){
        include_once 'conexao.php';
        $sql = "SELECT * FROM funcionarios";
        $query = $conexao->query($sql);
        while($user_data = mysqli_fetch_assoc($query)){

        }
    }
}


if($_POST['nome']){
$funcionario = new funcionario;
$funcionario->inserir();
    echo "funcao";
}

?>
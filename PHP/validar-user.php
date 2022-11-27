<?php
include_once 'links.php';

class usuario extends links_pages{
    function login(){
        include('conexao.PHP');

        if(empty(session_start())) {
            session_start();
        }
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql_code = "SELECT * FROM funcionarios WHERE email = '$email' ";
        $query = mysqli_query($conexao, $sql_code);
        $usuario = $query->fetch_assoc();
        $hash = $usuario['senha'];

        if(password_verify($senha , $hash))
        {
            $_SESSION['id'] = $usuario['id_funcionario']; 
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['cargo'] = $usuario['cargo'];
            header('Location: ' . $this->link_painel);
            die();
        }   
        else{
            header('Location: ../login.html');
            die();
        }
    }
    function logout(){

        session_start();
        session_destroy();
        header('Location: ../login.html');
        die();
        
    }
}

if(!empty($_GET['logout']) && $_GET['logout'] == 1){
    $usuario = new usuario;
    $usuario->logout();
}
if(isset($_POST['acessar']) && isset($_POST['email']) && isset($_POST['senha'])){
    $usuario = new usuario;
    $usuario->login();
}
?>
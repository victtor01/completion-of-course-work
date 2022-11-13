<?php
if(isset($_POST['acessar']) && isset($_POST['email']) && isset($_POST['senha'])){
    include('conexao.PHP');
    //echo $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql_code = "SELECT * FROM funcionarios WHERE email = '$email' LIMIT 1";
    $query = mysqli_query($conexao, $sql_code);
    $usuario = $query->fetch_assoc();

    if(password_verify($senha , $usuario['senha']))
    {
        header('Location: ../HTML/painel.php');
        die();
    }   
    else{
        header('Location: ../login.html');
        die();
    }
}

?>
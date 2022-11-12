<?php
if(isset($_POST['acessar']) && isset($_POST['email']) && isset($_POST['senha'])){
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'];

    include_once('conexao.PHP');
    $sql_code = "SELECT * FROM senhas WHERE email = '$email' LIMIT 1";
    $sql_execute = mysqli_query($coenxao, $sql_code);
    $user = mysqli_fetch_assoc($sql_execute);

    if(password_verify($senha, $usario['senha'])){
        header('../HTML/painel.html');
        die();
    }   
    else{
        header('Location: ../login.html');
        die();
    }
    //$senha = password_hash( $_POST['senha'], PASSWORD_DEFAULT);
}

?>
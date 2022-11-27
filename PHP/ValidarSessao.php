<?php
if(empty($_SESSION['nome'])){
    session_start();
}
if(!isset($_SESSION['nome']) || !isset($_SESSION['cargo']) || !isset($_SESSION['id'])){
    header('Location: ../login.html');
    die("Houve Algum Erro!");
}
?>
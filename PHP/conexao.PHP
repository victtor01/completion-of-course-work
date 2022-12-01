<?php


$usuario = "root";
$bancodedados = "controleestoque";
$senha="root";
$hostname = "localhost";

$conexao = new mysqli($hostname, $usuario, $senha, $bancodedados)
or die ("erro ao conectar ao banco de dados");

?>
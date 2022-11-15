<?php
class funcionario{
    function inserir(){
        if(!empty($_POST['nome'])){

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

            if($senha != $confirmar_senha)
                header('Location: ../HTML/funcionarios.html');
                die();

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

            header('Location: ../HTML/funcionarios.HTML');
            die();
            
        }
    }
}

if($_POST['nome']){
    $funcionario = new funcionario;
    $funcionario->inserir();
}
else{
    echo "deu erro";
}

?>
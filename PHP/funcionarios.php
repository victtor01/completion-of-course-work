<?php

if(empty($_SESSION['nome'])){
    session_start();
}

$_SESSION['cargo'];
$cargo = intval($_SESSION['cargo']);

if($cargo != 1){
    header('Location: ../html/funcionarios.php');
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
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
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
        $criptografy = password_hash($senha, PASSWORD_DEFAULT);

        if($extensao != 'jpg' &&  $extensao != 'png' ) { header('Location: ../HTML/funcionarios.html'); die(); }
        else{ $patch = $pasta . $imagem . "." . $extensao;  $move = move_uploaded_file($foto["tmp_name"], $patch); }

        if($move)
        {
            include_once 'conexao.PHP';              
            $sql = "INSERT INTO funcionarios(nome, CPF, cargo, data_nascimento, foto, salario, contato, email, senha) 
            VALUES ('$nome', '$CPF', '$cargo', '$data_nascimento', '$patch', '$salario', '$contato', '$email', '$criptografy')";
            $conexao->query($sql); 
        }

        header('Location: ' . $this->link_funcionarios);
        die();
        
    }
    public function mostrar_funcionarios(){
        include 'conexao.PHP'; 
        $sql = "SELECT * FROM funcionarios";
        $query = mysqli_query($conexao, $sql);

        while($user_data = mysqli_fetch_assoc($query)){

        $foto = $user_data['foto'];
        $nome = $user_data['nome'];
        $CPF = $user_data['CPF'];
        $cargo = $user_data['cargo'];
        $data_nascimento = $user_data['data_nascimento'];
        $salario = $user_data['salario'];
        $contato = $user_data['contato'];
        $email = $user_data['email'];

        

        echo"<div class='div-info-geral'>

                <div class='div-foto'>
                    <img src='". $foto ."' alt=''  width=100% height='100%'>
                </div>

                <div class='div-informacoes'>

                    <div>

                        <label class='label-info'>
                            <span> Nome: </Span>
                            <input type='text' name'nome' value='$nome'>
                        </label>
                        <label class='label-info'>
                            <span> Email: </span>
                            <input type='text' name'Email' value='$email'>
                        </label>
                        <label class='label-info'>
                            <span> Contato: </span>
                            <input type='text' name'Contato' value='$contato'>
                        </label>
                        <label class='label-info>
                            <span> CPF: </span>
                            <input type='text' name'CPF' value='$CPF'>
                        </label>

                    </div>
                    <div>
                    
                        <label class='label-info' >
                            <span> Cargo: </span>
                            <select name='cargo' class='select'>
                                <option value='1' "; if($cargo == 1){ echo 'selected'; } echo">Gerente</option>
                                <option value='2'"; if($cargo == 2){ echo 'selected'; }  echo">Faxineiro</option>
                                <option value='3'"; if($cargo == 3){echo 'selected'; }  echo">Recepcionista</option>
                                <option value='4'"; if($cargo == 4){ echo 'selected';} echo">Vendedor</option>
                            </select>
                        </label>
                        <label class='label-info' >
                            <span> Nascimento: </span>
                            <input type='text' name='Data_de_nascimento' value='$data_nascimento'>
                        </label>
                        <label class='label-info' >
                            <span> Salario: </span>
                            <input type='text' name='Salario' value='R$ $salario'>
                        </label>

                    </div>

                    <div style='max-width: 35px; height: 100% ;display: flex;'>
                            <button class='editar' type='button' style='margin: 5px 0px 5px 0px; height: 50%;'>
                                <a style='width: 35px; height: 35px; name='#' href='#'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                    <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                    </svg>
                                </a>
                            </button> 
                
                
                            <button class='editar' type='button' style='margin: 5px 0px 5px 0px; height: 50%;'>
                                <a style='width: 35px; height: 35px;' name='#' href='#'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                    <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                                    <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                                    </svg>
                                </a>
                            </button>
                        </div>
                </div>

            </div>";

        }
    }
}

if(isset($_POST['nome'])){
$funcionario = new funcionario;
$funcionario->inserir();
}

?>
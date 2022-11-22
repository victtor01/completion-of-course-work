<?php


if(empty($_SESSION['nome'])){
    session_start();
}

$_SESSION['cargo'];
$cargo = intval($_SESSION['cargo']);


require_once 'links.php';
class funcionario extends links_pages{
    
    private $id;
    private $cargo;
    private $nome;
    private $foto;
    private $PrimeiroNome;

    function __construct(){
        require 'conexao.PHP';
        $id_funcionario = $_SESSION['id'];
        $sql = "SELECT * FROM funcionarios WHERE id_funcionario = $id_funcionario";
        $query = mysqli_query($conexao, $sql);
        $row = $query->fetch_assoc();


        $this->id = $_SESSION['id'];
        $this->cargo = $_SESSION['cargo'];
        $this->foto = $row['foto'];
        $this->nome = $row['nome'];

        $tmp = explode(' ' , $this->nome);
        $this->PrimeiroNome = $tmp[0];

        $this->funcionario = array(
            "nome" => $this->nome,
            "foto" => $this->foto, 
            "PrimeiroNome" => $this->PrimeiroNome,
        ); 

        
    }
    public function inserir(){

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
            die();
        }
        $pasta = "../imagens/imagens-fun/";
        $imagem = uniqid();
        $imagem_nome = $foto['name'];
        $extensao = strtolower(pathinfo($imagem_nome, PATHINFO_EXTENSION));
        $criptografy = password_hash($senha, PASSWORD_DEFAULT);

        if($extensao != 'jpg' &&  $extensao != 'png' ) { header('Location: ../HTML/funcionarios.html'); die(); }
        else{ $patch = $pasta . $imagem . "." . $extensao;  $move = move_uploaded_file($foto["tmp_name"], $patch); }

        include 'conexao.PHP';              
        $sql = "INSERT INTO funcionarios(nome, CPF, cargo, data_nascimento, foto, salario, contato, email, senha) 
        VALUES ('$nome', '$CPF', '$cargo', '$data_nascimento', '$patch', '$salario', '$contato', '$email', '$criptografy')";
        $conexao->query($sql); 

        header('Location: ' . $this->link_funcionarios);
        die();
        
    }
    public function getFuncionario(){
        return $this->funcionario;
    }
    public function Deletarfuncionario(){

        if($this->cargo == 1){
            if($this->id != $_GET['id_funcionario']){
                if($_GET['id_funcionario'] != 1){
                    
                    $id = $_GET['id_funcionario'];
                    include 'conexao.php';
                    $sql = "SELECT foto FROM funcionarios WHERE id_funcionario = $id";
                    $query = mysqli_query($conexao, $sql);
                    $row = $query->fetch_assoc();
                    $patch = $row['foto'];

                    $delete = "DELETE FROM funcionarios WHERE id_funcionario = $id";
                    $query = mysqli_query($conexao, $delete);
                    
                    if($query){
                        if(is_file($patch)){
                            unlink($patch);
                            header('Location: '.$this->link_funcionarios);
                            die();
                        }
                    }
                }
            }
        }
        header('Location: ' . $this->link_funcionarios);
        die();
    }
    public function mostrarFuncionarios(){

        include 'conexao.PHP'; 
        $sql = "SELECT * FROM funcionarios WHERE id_funcionario";
        $query = mysqli_query($conexao, $sql);

        while($user_data = mysqli_fetch_assoc($query)){

        $id = $user_data['id_funcionario'];
        $foto = $user_data['foto'];
        $nome = $user_data['nome'];
        $CPF = $user_data['CPF'];
        $cargo = $user_data['cargo'];
        $data_nascimento = $user_data['data_nascimento'];
        $salario = $user_data['salario'];
        $contato = $user_data['contato'];
        $email = $user_data['email'];
        
        ?>
        <div class="div-info-geral">

        <div class="div-foto">
            <img src=" <?php echo $foto ?> " alt=" " width="100%" height="100%">
        </div>

        <div class="div-informacoes">

            <div>

                <label class="label-info">
                    <span> Nome: </Span>
                    <input type="text" name="nome" value=" <?php echo $nome ?>">
                </label>
                <label class="label-info">
                    <span> Email: </span>
                    <input type="text" name="Email" value=" <?php echo $email ?>">
                </label>
                <label class="label-info">
                    <span> Contato: </span>
                    <input type="text" name="Contato" value=" <?php echo $contato ?>">
                </label>
                <label class="label-info">
                    <span> CPF: </span>
                    <input type="text" name="CPF" value=" <?php echo $CPF ?>">
                </label>

            </div>
            <div>
            
                <label class="label-info" >
                    <span> Cargo: </span>
                    <select name="cargo" class="select">
                        <option value="1" <?php if($cargo == 1){ echo "selected"; } ?>>Gerente</option>
                        <option value="2" <?php if($cargo == 2){ echo "selected"; } ?> >Faxineiro</option>
                        <option value="3" <?php if($cargo == 3){ echo "selected"; }  ?>>Recepcionista</option>
                        <option value="4" <?php if($cargo == 4){ echo "selected";} ?>>Vendedor</option>
                    </select>
                </label>
                <label class="label-info" >
                    <span> Nascimento: </span>
                    <input type="text" name="Data_de_nascimento" value=" <?php echo $data_nascimento ?>">
                </label>
                <label class="label-info" >
                    <span> Salario: </span>
                    <input type="text" name="Salario" value="R$ <?php echo $salario ?>">
                </label>

            </div>

            <div style="max-width: 35px; height: 100%; display: flex;">
                    <button class="editar" type="button" style="margin: 5px 0px 5px 0px; height: 50%; background-color: black;">
                        <a style="width: 35px; height: 35px;" name="#" href="?id_funcionario=<?php echo $id ?>">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                        </a>
                    </button> 
        
        
                    <button name="deletar" class="editar" type="button" style="margin: 5px 0px 5px 0px; height: 50%;">
                        <a style="width: 35px; height: 35px;" name="#" href="../PHP/funcionarios.php?id_funcionario=<?php echo $id ?>&&delete=1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                        </a>
                    </button>
                </div>
            </div>
        </div>
        <?php
        }
    }
    public function MudarSenhadoFuncionario(){
        $senha = strval($_POST['senha']);
        $confirmar_senha = strval($_POST['confirmar_senha']);
        $id_funcionario = $_POST['id_funcionario'];

        if($senha == $confirmar_senha){
            include 'conexao.PHP';
            $criptografy = password_hash($confirmar_senha, PASSWORD_DEFAULT);
            $sql = "UPDATE funcionarios SET senha='$criptografy' WHERE id_funcionario = '$id_funcionario'";
            $query = $conexao->query($sql);
        }       

        header('Location: ../HTML/funcionarios.php');
        die("deu certo");
    }
    public function ModalMudarSenhadoFuncionario(){
        
        ?>
        
        <dialog class="modal" id="modal-password" style="position: relative;">
            <header class="header-cadastro">

                <h2>Nova senha de acesso</h2>
                <button type="button" style="background: none;" id="botao-modal-password" onclick="esconder()">
                    <ion-icon style="width: 30px; height: 30px;" name="close-outline"></ion-icon>
                </button>

            </header>

            <section class="section-password">
                <form action="../PHP/funcionarios.php" method="post">
                    <input type="hidden" name="id_funcionario" value="<?php echo $_GET['id_funcionario']?>">
                    <label class="label-password">
                        <span> Nova senha: </span>
                        <input type="password" class="input" name="senha">
                    </label>
                    <label class="label-password">
                        <span> Confirmar nova senha: </span>
                        <input type="password" class="input" name="confirmar_senha">
                    </label>

                    <label class="label-password">
                        <button type="submit" id="button" name="submit-update-senha">
                            Concluído
                        </button>
                    </label>
                    
                </form>
            </section>
        </dialog>

        <style>
            form{
                width: 100%;
            }
            .modal{
            width: 500px;
            height: 300px;
            background-color: white;
            position: absolute;
            margin: 100px auto 0px auto;
            border: 0; 
            background-color: rgb(244, 244, 244);
            }
            .section-password{
                display: flex; 
                width: 100%;
                height: 80%;
                flex-direction: column; 
                align-items: center; 
                justify-content:end;
                box-sizing: border-box;
                padding: 10px;
            }
            .label-password{
                width: 100%;
                display: flex;
                flex-direction: column;
                box-sizing: border-box;
                padding: 6px;
            }
            .input{
                border: 0px;
                width: 100%;
                box-shadow: 0px 0px 10px rgb(181, 181, 181); 
                height: 40px; 
                outline: none; 
                padding: 10px; 
                font-size: 12pt; 
                border-radius: 20px;
                box-sizing: border-box;
                
            }
            #button{
                background: none; 
                width: 100%; 
                box-shadow: 0px 0px 10px rgb(181, 181, 181); 
                height: 35px; 
                box-sizing:border-box; 
                padding: 10px; 
                font-size: 12pt;
                font-family: 'Courier New', Courier, monospace;
                font-weight: 550;
                border-radius: 20px;
                margin-top: 25px;
                transition: 0.7s;
            }
            #button:hover{
                background-color: black;
                color: white;
            }
            span{
                margin-left: 10px;
                font-weight: 600;
            }
            
        </style>
            
        <script>
            var modal_ = window.document.getElementById('modal-password');
            modal_.showModal();

            function esconder(){
                var modal_ = window.document.getElementById('modal-password');
                modal_.close();
            }

        </script>

        <?php
        
    }
}

$funcionario = new funcionario;

if(isset($_POST['nome'])){
$funcionario->inserir();
}

if(isset($_POST['senha'])){
$funcionario->MudarSenhadoFuncionario();
}

if(isset($_GET['delete'])){
$funcionario->Deletarfuncionario();
}


?>
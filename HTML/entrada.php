<?php

require_once '../PHP/ValidarSessao.php';
require_once '../PHP/conexao.php';
require_once '../PHP/funcionarios.php';
require_once '../PHP/entrada.php';

$funcionario = new funcionario;
$funcionario = $funcionario->getFuncionario();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../CSS/index.css">
    <link rel="stylesheet" href="../modal/modal.css">

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="../JS/script.js"></script>
    <script src="../modal/modal.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


    <title>Entradas</title>

</head>
<body>
    <header class="header-titulo titulo-principal">
        <div style="width: 100%; height: 100%; align-items: center; display: flex; position: relative; cursor: pointer;">
            <a href="painel.php" style="text-decoration: none; color: white; display: flex; justify-content: left; font-size: 12pt;">
                <img src="../imagens/box.png" width="45px" height="45px;" style="margin-right: 30px;">
                <h1 style="margin-right: 50px;"> Controle de Estoque </h1>
            </a>
            <div style="right: 0; position: absolute; color: #FF731D; display: flex;">
                <h2> Bem vindo <?php $name = explode(' ', $funcionario['nome']); echo $name[0];?> </h2>
            </div>
        </div>
    </header>
    <main>
        <div class="barra-lateral">
            <header>
                <div class="imagem">
                    <img src="<?php echo $funcionario['foto']; ?>" width="150" height="150">
                </div>
                <h2 style="margin-top: 10px;"> <?php echo $funcionario['nome']?></h2>
            </header>
            <section>
                <a href="painel.php">
                    <ion-icon name="desktop-outline"></ion-icon> <span> Home </span>
                </a>
                <a href="produtos.php">
                    <ion-icon name="bag-outline"></ion-icon> <span> Produtos </span>
                </a>
                <a href="categoria.php">
                    <ion-icon name="bookmark-outline"></ion-icon> <span> Categorias </span>
                </a>
                <a href="fornecedores.php">
                    <ion-icon name="person-outline"></ion-icon> <span> Fornecedores </span>
                </a>
                
                <button class="clientes-funcionarios" id="botao-financeiro" onclick="Financeiro()">
                    <ion-icon name="cash-outline"></ion-icon></ion-icon> <span> Financeiro </span>
                    <ion-icon name="chevron-forward-outline" id="ion-icon-seta-financeiro" width='10px'></ion-icon>    
                </button>
                <div class="href-clientes-funcionarios" id="href-financeiro">
                    <!-- <a href="dashboard.php">
                        <span> Dashboard </span>
                    </a> -->
                    <a>
                        <span> Entradas </span>
                    </a>
                    <a href="saidas.php">
                        <span> saidas </span>
                    </a>
                </div>
                
                <?php if($_SESSION['cargo'] == 1){ ?>
                    <a href="funcionarios.php">
                        <ion-icon name="person-outline"></ion-icon> <span> Funcionários </span>
                    </a>
                  <!--   <button class="clientes-funcionarios" id="botao-contas" onclick="ClientesFuncionarios()">
                        <ion-icon name="person-add-outline"></ion-icon> <span> Contas </span>
                        <ion-icon name="chevron-forward-outline" id="ion-icon-seta" width='10px'></ion-icon>    
                    </button>
                    <div class="href-clientes-funcionarios" id="href-clientes-funcionarios">
                        <a href="funcionarios.php">
                            <span> Funcionários </span>
                        </a>
                        <a href="clientes.php">
                            <span> Clientes </span>
                        </a>
                    </div> -->
                <?php }?>

                <a href="../PHP/validar-user.php?logout=1" class="sair">
                    <ion-icon name="exit-outline"></ion-icon> <span> Sair </span>
                </a>
                
            </section>
        </div>

        <section class="section-principal">
            <?php Entrada::all(); ?>
        </section>
    </main>

    <script>
        let button = window.document.getElementsByClassName('button_entrada')

        for (var but of button) {
            but.addEventListener('click', function() {
                let confirm = window.confirm('Deseja Excluir esse registro de entrada?')

                if(!confirm)
                {
                    return alert('cancelado!')   
                }

                let id = this.id

                exluir()

                function exluir() {
                    $.post("../PHP/entrada.php", {id: id}, function(res){
                        let button = window.document.getElementById(`tr[${id}]`);
                        button.style.cssText = 'display: none'
                    })
                }
            }
        )
    }
    </script>
</body>
</html>
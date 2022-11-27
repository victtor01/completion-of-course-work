<?php

if(empty($_SESSION['id'])){
    session_start();
}

if(!isset($_SESSION['nome']) || !isset($_SESSION['id'])){
    header('Location: ../login.html');
    die();
}

include_once '../PHP/conexao.php';
include_once '../PHP/categoria.php';
require_once '../php/produto.php';
require_once '../PHP/funcionarios.php';

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

    <script src="../JS/script.js"></script>
    <script src="../modal/modal.JS"></script>

    <title>categorias</title>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>

<body>

    <!-- TITULO DA PAGINA (padrao em todas as paginas)-->
    <header class="header-titulo titulo-principal">
        <div style="width: 100%; height: 100%; align-items: center; display: flex; position: relative; cursor: pointer;">
            <a href="painel.html" style="text-decoration: none; color: white; display: flex; justify-content: left; font-size: 12pt;">
                <img src="../imagens/box.png" width="45px" height="45px;" style="margin-right: 30px">
                <h1 style="margin-right: 50px;"> Controle de Estoque </h1>
            </a>
            <div style="right: 0; position: absolute; color: #FF731D;">
                <h2> Ola, admin! </h2>
            </div>
        </div>
    </header>

    <!-- PRINCIPAL -->
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
                <a class="selecionado">
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
                    <a href="#">
                        <span> Dashboard </span>
                    </a>
                    <a href="#">
                        <span> Entradas </span>
                    </a>
                    <a href="#">
                        <span> saidas </span>
                    </a>
                </div>

                <?php if($_SESSION['cargo'] == 1){ ?>
                    <button class="clientes-funcionarios" id="botao-contas" onclick="ClientesFuncionarios()">
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
                    </div>
                <?php }?>

                <a href="../PHP/validar-user.php?logout=1" class="sair">
                    <ion-icon name="exit-outline"></ion-icon> <span> Sair </span>
                </a>
                
            </section>
        </div>

        <!-- SECTION DA CATEGORIA-->
        <section class="section-principal section-categoria" style="height: auto; background: none; box-shadow: none;">
            <!-- TITULO DA SECTION -->
            <header class="header-titulo titulo-section">
                <h1> categorias </h1>
            </header>
            <!-- PRINCIPAIS BOTOES DA PAGINA -->
            <div class="botoes-principais">
                <div class="div" style="margin-left: 10px;">
                    <button type="button" class="botao" onclick="abrirmodal('button-entrada')"> + Categoria </button>
                </div>
            </div>
            <!-- SECTION QUE CONTEM AS TABELAS -->
            <section style="margin: 5px auto 10px auto; max-height: 400px; overflow: scroll; overflow-x: hidden;">
                <!-- TABELA -->
                <table style="margin: 5px auto 10px auto;">
                    <thead>
                        <tr class="tr">
                            <th> ID </th>
                            <th> Nome </th>
                            <th> Descrição </th>
                            <th> Quantidade de Itens</th>
                            <th> Ações</th>
                        </tr>
                    </thead>
                    <?php
                        $categoria = new categoria;
                        $categoria->mostrar_categoria();
                    ?>
                </table>
            </section>
            <!-- FOOTER QUE IRÁ TER O RESUMO DA CATEGORIA-->
            <footer>
                
            </footer>

        </section>


    </main>

    <dialog id="modal-entrada" class="modal">

        <header class="header-cadastro">
            <h2>cadastrar produto</h2>
            <button type="button" style="background: none;" onclick="fecharmodal('button-entrada-fechar')">
            <ion-icon style="width: 33px; height: 33px;"name="close-outline"></ion-icon>
            </button>
        </header>

        <!-- DIV PARA CADASTRAR CATEGORIA-->
        <section class="section-cadastro">
            <form action="../PHP/categoria.php" method="POST">
                <input type="text" name="nome" placeholder="Digite o nome da categoria aqui">
                <textarea name="obs" id="obs" cols="30" rows="10" style="width: 100%; border: 0; background-color: #ffffff44; outline: none;" placeholder="Digite a descrição aqui..."></textarea>
                <div class="botoes-submit">
                     <button type="submit" class="botao1"> cadastrar </button>
                </div>
            </form>
        </section>

    </dialog>

</body>

</html>
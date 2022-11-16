<?php
session_start();
if(isset($_SESSION['nome']) && isset($_SESSION['id'])){
    include_once '../PHP/conexao.php';
    include_once '../PHP/categoria.php';
}
else{
    header('Location: ../login.html');
    die();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/index.css">
    <script src="../JS/script.js"></script>
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
                    <img src="../imagens/admin.png" width="150" height="150">
                </div>
                <h1> Admin</h1>
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
                <a href="#">
                    <ion-icon name="cash-outline"></ion-icon> <span> Financeiro </span>
                </a>

                <button class="clientes-funcionarios" id="botao-contas" onclick="ClientesFuncionarios()">
                    <ion-icon name="person-add-outline"></ion-icon> <span> Contas </span>
                    <ion-icon name="chevron-forward-outline"id="ion-icon-seta" width='10px'></ion-icon>    
                </button>
                <div class="href-clientes-funcionarios">
                    <a href="funcionarios.html">
                        <span> Funcionários </span>
                    </a>
                    <a href="#">
                        <span> Clientes </span>
                    </a>
                </div>

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
                    <button type="button" class="botao" onclick="clicar_categoria()"> Adicionar </button>
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
                FOOTER
            </footer>

        </section>


    </main>

    
    <!-- FUNDO PARA REGISTRAR A CATREGORIA OBS: FICARÁ ESCONDIDA ATÉ QUE O USUÁRIO APERTA PARA CADASTRAR -->
    <div class="fundo-registrar-categoria" id="fundo-registrar-categoria">

        <!-- DIV PARA CADASTRAR CATEGORIA-->
        <div class="registrar-categoria" id="registrar-categoria">
            <!-- TITULO DA DIV -->
            <header class="header-cadastro">

                <!-- TITULO -->
                <h1>cadastrar Categoria</h1>

                <!-- BOTAO PARA FECHAR A DIV -->

                <button type="button" style="background: none; position:static; right: 0; top: 0;" class="button">
                    <img src="./imagens/fechar.png" class="img-fechar">
                </button>

            </header>
            <!-- REGISTRAR DO NOME DA CATEGORIA -->
            <form action="../PHP/categoria.php" method="POST">
                <input type="text" name="nome" placeholder="Digite o nome da categoria aqui">
                <textarea name="obs" id="obs" cols="30" rows="10"></textarea>
                <button type="submit"> cadastrar </button>
            </form>
        </div>

    </div>

</body>

</html>
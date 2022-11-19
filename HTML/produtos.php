<?php
session_start();
if(isset($_SESSION['id']) && isset($_SESSION['nome'])){
    include_once '../PHP/conexao.PHP';
    include_once '../PHP/produto.php';
}
else{
    header('Location: ../login.html');
    die();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <script src="../JS/script.js"></script>
    <script src="../modal/modal.js"></script>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../CSS/index.css">
    <link rel="stylesheet" href="../modal/modal.css">

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <title>Produtos</title>

</head>

<body>

    <div class="msg" id="msg2" style="background-color: red;">
        <h2> Algo deu errado</h2>
    </div>
    <div class="msg" id="msg1">
        <h2>Ação conluída com sucesso!</h2>
    </div>

    <?php
    if (!empty($_GET['msg'])) {
        include_once('../php/mensagem.php');
        mensagem($_GET['msg']);
    }
    ?>

    <header class="header-titulo titulo-principal">
        <div style="width: 100%; height: 100%; align-items: center; display: flex; position: relative; cursor: pointer;">
            <a href="painel.php" style="text-decoration: none; color: white; display: flex; justify-content: left; font-size: 12pt;">
                <img src="../imagens/box.png" width="45px" height="45px;" style="margin-right: 30px;">
                <h1 style="margin-right: 50px;"> Controle de Estoque </h1>
            </a>
            <div style="right: 0; position: absolute; color: #FF731D; display: flex;">
                <h2> Ola, admin! </h2>
            </div>
        </div>
    </header>

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
                <a class="selecionado">
                    <ion-icon name="bag-outline"></ion-icon> <span> Produtos </span>
                </a>
                <a href="categoria.php">
                    <ion-icon name="bookmark-outline"></ion-icon> <span> Categorias </span>
                </a>
                <a href="fornecedores.php">
                    <ion-icon name="person-outline"></ion-icon> <span> Fornecedores </span>
                </a>
                <a href="#">
                    <ion-icon name="cash-outline"></ion-icon> <span> Financeiro </span>
                </a>

                <?php if($_SESSION['cargo'] == 1){ ?>
                    <button class="clientes-funcionarios" id="botao-contas" onclick="ClientesFuncionarios()">
                        <ion-icon name="person-add-outline"></ion-icon> <span> Contas </span>
                        <ion-icon name="chevron-forward-outline"id="ion-icon-seta" width='10px'></ion-icon>    
                    </button>
                    <div class="href-clientes-funcionarios">
                        <a href="funcionarios.php">
                            <span> Funcionários </span>
                        </a>
                        <a href="#">
                            <span> Clientes </span>
                        </a>
                    </div>
                <?php }?>

                <a href="../PHP/validar-user.php?logout=1" class="sair">
                    <ion-icon name="exit-outline"></ion-icon> <span> Sair </span>
                </a>
                
            </section>
        </div>

        <section class="section-principal">
            <header class="header-titulo titulo-section">
                <h1>
                    Produtos
                </h1>
            </header>

            <div class="botoes-principais">
                <div class="div">
                    <button type="button" class="botao" id="button-entrada" onclick="abrirmodal('button-entrada')">
                        <ion-icon name="enter-outline" style="width: 30px; height: 100%;"></ion-icon>
                        Entrada
                    </button>
                </div>

                <div class="div-pesquisar div">
                    <input type="text" placeholder="Pesquise..." class="pesquisar">
                    <button type="button" class="btn-pesquisar" style="border: none; background: none;">
                        <img src="../imagens/lupa.png" width="25px" height="25px">
                    </button>
                </div>

                <form action="../PHP/produto.php" method="post">

                <div class="div">
                    <button type="submit" class="botao" id="modalsaida" value="submit-saida-produto" name="submit-saida-produto">
                        <ion-icon name="exit-outline" style="width: 30px; height: 100%;"></ion-icon>
                        Saída
                    </button>
                </div>
            </div>

            <section class="section-produtos">
                <table>
                    <?php

                    $produto = new produto;
                    $produto->mostrar_produtos();

                    ?>
                </table>
            </section>

            <footer style='margin-top: 15px;'>
            </footer>

        </section>

        </form>
    </main>

    <!-- modals -->
    <dialog id="modal-entrada" class="modal">
        <header class="header-cadastro">
            <!-- titulo da parte de registro de produto -->
            <h1>cadastrar produto</h1>
            <!-- botao que vai fechar a parte de registor de produto-->
            <button type="button" style="background: none;" onclick="fecharmodal('button-entrada-fechar')">
            <ion-icon style="width: 40px; height: 40px;"name="close-outline"></ion-icon>
            </button>

        </header>

        <section class="section-cadastro">
            <form method="POST" action="../PHP/produto.php" >
                <!--nome do produto --> 
                <label>
                    <label class="label-titulo"> Nome do produto: *</label>
                    <input name="nome" type="text" class="input-registro" placeholder="Biquini Vermelho" autocomplete="off">
                </label>

                <!-- quantidade e tamanho do produto -->
                <div class="div-quantidade-tamanho">
                    <!-- qunatidade -->
                    <label class="label-quantidade">
                        <label class="label-titulo"> Quantidade: *</label>
                        <input name="quantidade" type="number" class="input-registro" placeholder="Unidades">
                    </label>
                    <!-- tamanho do produto-->
                    <label class="label-tamanho">
                        <label class="label-titulo">Tamanho *</label>
                        <select id="tamanho" name="tamanho" class="select">
                            <option value='1'>PP</option>
                            <option value='2'>P</option>
                            <option value='3'>M</option>
                            <option value='4'>G</option>
                            <option value='5'>GG</option>
                        </select>
                    </label>
                </div>

                <!-- data do produto -->
                <div class="div-quantidade-tamanho">
                    <label class="label-data">
                        <label class="label-titulo"> Data: *</label>
                        <input name="data" type="date" class="input-registro">
                    </label>
                    <label>
                        <label class="label-titulo"> Foto: </label>
                        <input class="file-image" name="valor_unidade" type="file">
                    </label>
                </div>
                

                <!-- categoria e fornecedor -->
                <div class="div-categoria-fornecedor">

                    <!-- categoria -->
                    <label class="label-categoria">

                        <label class="label-titulo"> Categoria: </label>
                        <select id="categoria" name="categoria" class="select">
                            <option value="nenhum"> Nenhum </option>
                            <?php
                            $sql = "SELECT * FROM categoria";
                            $result = $conexao->query($sql);
                            while ($user_data = mysqli_fetch_assoc($result)) {
                                echo "<option value=" . $user_data['id_categoria'] . ">";
                                echo $user_data['nome'] . "</option>";
                            }
                            ?>
                        </select>

                    </label>

                    <!-- forncedor-->
                    <label class="label-fornecedor">
                        <label class="label-titulo"> Fornecedor: </label>
                        <select id="fornecedor" name="fornecedor" class="select">
                            <option value="nenhum"> Nenhum </option>
                            <?php
                            $sql = "SELECT * FROM fornecedor";
                            $result = $conexao->query($sql);
                            while ($user_data = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $user_data['id_fornecedor'] . "'>";
                                echo $user_data['nome'] . "</option>";
                            }
                            ?>

                        </select>

                    </label>

                </div>

                <!-- valor de investimento -->
                <div class="div-investimento-lucro">
                    <label class="label-numero">
                        <label class="label-titulo"> Valor da Unidade: *</label>
                        <input id="valor_fornecedor" name="investimento" type="text" class="input-registro" placeholder="R$ 1000,00">
                    </label>
                    <label class="label-numero">
                        <label class="label-titulo"> Lucro (%): *</label>
                        <input name="lucro" type="text" class="input-registro" placeholder="15" autocomplete="off">
                    </label>
                </div>

                <!-- butao (submit) para enviar o produto para o banco de dados-->
                <div class="botoes-submit">
                    <button type="submit" name="submit-produto" class="botao1"> cadastrar</button>
                    <button type="reset" class="botao2"> Limpar </button>
                </div>
            </form>
        </section>

    </dialog>

    <dialog id="modal-saida" class="modal">

        <header class="header-cadastro">
            <h1>Saída dos produtos</h1>
            <button type="button" style="background: none; border: none;" onclick="fecharmodal('button-saida-fechar')">
            <ion-icon style="width: 40px; height: 40px;"name="close-outline"></ion-icon>
            </button>
        </header>

        <section id="modal-saida-select">
            <form action="../PHP/produto.php" method="POST">
                <?php
                if (!empty($_GET['pesquisa'])) {
                    $pesquisa = $_GET['pesquisa'];
                    $produto = new produto;
                    $produto->modal_produtos_selecionados($pesquisa);
                }
                ?>
                <div class="botoes-submit">
                    <button type="reset" class="botao2"> Limpar </button>
                    <label for=""> <span>Desconto do valor total</span><input type="number"> </label>
                    <button type="submit" class="botao1" name="retirar-produto"> Concluir </button>
                </div>
                <form>
        </section>

    </dialog>

</body>

</html>
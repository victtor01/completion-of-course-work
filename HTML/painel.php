<?php
    include_once('../PHP/conexao.php');
    $sql = "SELECT SUM(quantidade) as SOMA FROM produto";
    $query = mysqli_query($conexao, $sql);
    $row = $query->fetch_assoc();
    $SUM = $row['SOMA'];

    $sql =  "SELECT COUNT(*) as CONTAGEM FROM produto ";
    $query = mysqli_query($conexao, $sql);
    $row = $query->fetch_assoc();
    $COUNT = $row['CONTAGEM'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../JS/script.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>     

    <title>Painel</title>
</head>

<body>

    <header class="header-titulo titulo-principal">
        <div style="width: 98%; height: 100%; align-items: center; display: flex; position: relative;"> 
            <img src="../imagens/box.png" width="45px" height="45px;" style="margin-right: 30px">
            <h1 style="margin-right: 50px;"> Controle de Estoque </h1> 
            <div style="right: 0; position: absolute; color: #FF731D;">
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
                <a class="selecionado">
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
                <a href="#">
                    <ion-icon name="cash-outline"></ion-icon> <span> Financeiro </span>
                </a>

                <button class="clientes-funcionarios" id="botao-contas" onclick="ClientesFuncionarios()">
                    <ion-icon name="person-add-outline"></ion-icon> <span> Contas </span>
                    <ion-icon name="chevron-forward-outline"id="ion-icon-seta"></ion-icon>    
                </button>
                <div class="href-clientes-funcionarios">
                    <a href="#">
                        <span> Clientes </span>
                    </a>
                    <a href="funcionarios.html">
                        <span> Funcionários </span>
                    </a>
                </div>

                <a href="#" class="sair">
                    <ion-icon name="exit-outline"></ion-icon> <span> Sair </span>
                </a>
            </section>
        </div>
        
        <section class="section-principal">

            <div class="principais-acoes">
                <button class="acao" id="produtos">

                    <p> <?php echo $COUNT ?> Produtos Cadastrados</p>
                    <p> <?php echo $SUM ?> Itens no estoque    </p>
                    <div class="link_acao" id="link_produtos"> 
                    <a href="produtos.php">Produtos</a>
                    </div>

                </button>

                <button class="acao" id="fornecedores">
    
                   <p> Total de <?php ?> fornecedores </p>
                   <div class="link_acao" id="link_fornecedores">
                    <a href="fornecedores.php">Fornecedores</a>
                    </div>

                </button>

                <button class="acao acao-3">

                <p> financeiro </p>
                    <div class="link_acao link-acao-3">
                        <a href="#">Financeiro</a>
                    </div>
                </button>
            </div>

            <!-- graficos -->
            <div class="graficos">

                <div class="entrada_saida">
                    <div class="titulo_grafico">
                    <h2> Entrada e saida de produtos</h2>
                    </div>
                    <div id="curve_chart"></div>
                </div>

                
                <div class="entrada_saida">
                    <div class="titulo_grafico">
                    <h2> Entrada e saida de caixa</h2>
                    </div>
                    <div id="chart_div"></div>
                </div>
                
            </div>
            
        </section>

    </main>

</body>
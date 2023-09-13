<?php

require_once '../PHP/ValidarSessao.php';
require_once '../PHP/conexao.php';
require_once '../php/produto.php';
require_once '../PHP/funcionarios.php';

$funcionario = new funcionario;
$funcionario = $funcionario->getFuncionario();

?>
<!DOCTYPE html>
<html lang="pt-BR">
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

    <title>Dashboard</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mês', 'produtoX', 'produtoY', 'produtoZ'],
          ['2014', 1000, 400, 200],
          ['2015', 1170, 460, 250],
          ['2016', 660, 1120, 300],
          ['2017', 1030, 540, 350]
        ]);

        var options = {
          chart: {
            title: 'Company Performance',
            subtitle: 'Sales, Expenses, and Profit: 2014-2017',
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

    <script type="text/javascript">

        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Produto", "Quantidade", { role: "style" } ],

            <?php 
            include '../PHP/conexao.PHP';
            $sql = "SELECT nome_produto, SUM(quantidade) as quantidade FROM saida GROUP BY nome_produto ORDER BY SUM(quantidade) DESC LIMIT 3";
            $query = mysqli_query($conexao, $sql);

            while($date = mysqli_fetch_assoc($query)){
                $nome = $date['nome_produto'];
                $quantidade = intval($date['quantidade']);
            ?>

            ['<?php echo $nome?>',<?php echo intval($quantidade)?>, "#d7d7d776"],

            <?php
            }
            ?>
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                        { calc: "stringify",
                            sourceColumn: 0,
                            type: "string",
                            role: "annotation" },
                        2]);

        var options = {
            title: "Produtos mais vendidos",
            width: 400,
            height: 220,
            bar: {groupWidth: "60%"},
            legend: { position: "absolute" },
        };
        var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
        chart.draw(view, options);
    }
    </script>

</head>
<body>

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

    <section class="section-principal">
        <header class="header-titulo titulo-section">
            <h1> Dashboard </h1>
        </header>
        <section class="dashboard">
            <div class="div caixa"> 
                <div class="column">
                    <span class="real"> R$ 234<span style="font-size: 20pt;">,90</p> </span>
                </div>    
            </div>
            <div class="div valores" style="background-color: #002973">
                <h3> Dispesas Fixas:</h3> <hr>
                <div class="row">
                    <div class="column">
                        <span> Dispesa fixa total: </span>
                        <span> R$ 2300,00 </span>
                    </div>
                </div>
            </div>
            <div class="div valores" style="background-color: #fbc107;">
                <h3> Dispesas Variáveis </h3> <hr>
                <div class="row">
                    <div class="column">
                        <span> Dispesa fixa total: </span>
                        <span> R$ 2300,00 </span>
                    </div>
                </div>
            </div>
        </section>
        <style>
            .dashboard{
                width: 100%;
                width: min(100%, none);
                font-family: sans-serif;
                height: 150px;
                margin: 1% auto 10px auto;
                position: relative;
                box-sizing: border-box;
                justify-content: space-between;
                display: flex;
                padding: 5px;
                color: white;
            }.dashboard .valores{
                position: relative;
            }
            .dashboard .valores button {
                right: 0;
                bottom: 0;
                width: 100px;
                height: 30px;
                background: none;
                box-shadow: 0px 0px 4px rgba(255, 255, 255, 0.1);
                border-radius: 15px;
                margin: 10px 10px 10px 10px;
                background-color: white;
                position: absolute;
                font-weight: 600;
                text-transform: uppercase;
                transition: 0.2s;
            }
            .dashboard .valores button:hover{
                box-shadow: 0px 0px 10px whitesmoke;
                transform: scale(1.01);
            }
            .dashboard .div{
                width: 100%;
                height: 100%;
                position: relative;
                box-shadow: 0px 2px 10px -4px rgb(220, 220, 220);
                padding: 10px;
                border-radius: 4px;
                color: white;
                transition: 0.3s;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                margin: 0px 10px 0px 10px;
            }
            .dashboard .div:hover{
                transform: scale(1.02);
            }
            .dashboard .div input{
                width: 100%;
                height: 40px;
                background-color: white;
                outline: none;
                margin: 5px 0px 5px 2px;
                border: none;
                box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.2);
                border-radius: 4px;
                padding: 5px;
                font-size: 13pt;
                transition: 0.4s;
            }
            .dashboard .div input:hover{
                box-shadow: 0px 0px 10px white;
            }
            .dashboard .div input::placeholder{
                color: rgba(0, 0, 0, 0.4);
            }
            .dashboard .caixa {
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #44b331;
                width: 100%;
            }
            .dashboard .valores h3{
                font-size: 14pt;
                font-weight: 450;
            }
            .dashboard hr{
                margin: 5px auto 5px auto;
                background-color: white;
                border: 1px solid white;
                width: 100%;
            }
            .dashboard .valores .row{
                height: auto;
                display: flex;
            }
            .dashboard .valores .row span {
                font-size: 18pt;
                font-weight: 450;
            }
            .dashboard .div .real{
                font-size: 35pt;
            }
            .column{
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                width: 100%;
                padding: 5px;
            }
        </style>

        <form action="../PHP/dashboard.php" method="post">
            <section class="acoes">
                    <div class="div">
                        <div class="column" style="color:rgba(0, 0, 0, 1);">
                            Registro caixa
                            <div class="hr"> 
                                <hr> 
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>
                                            nome
                                        </th>
                                        <th>
                                            valor
                                        </th>
                                        <th>
                                            Opcao
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            café
                                        </td>
                                        <td>
                                            R$ 203,34
                                        </td>
                                        <td>
                                            Excluir
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="div">
                        <div class="column" style="color:rgba(0, 0, 0, 1);">
                            Registro caixa
                            <div class="hr"> <hr> </div>
                        </div>
                    </div>
                    <div class="div">
                        <div class="column" style="color:rgba(0, 0, 0, 1);">
                            Registro caixa
                            <div class="hr"> <hr> </div>
                        </div>
                    </div>
                    <!--
                    <div class="botao"> 
                        <button class="botao-acao">
                            Enviar
                        </button>
                    </div>
                    -->
            </section>
        </form>

        <style>
            .acoes{
                width: 100%;
                width: min(100%, none);
                font-family: sans-serif;
                height: 270px;
                margin: 1% auto 10px auto;
                position: relative;
                box-sizing: border-box;
                justify-content: space-between;
                display: flex;
                padding: 5px;
                color: white;
                position: relative;
            }
            .acoes .div{
                width: 100%;
                height: 100%;
                margin: 0px 10px 0px 10px;
                transition: 0.2s;
                transition-delay: 0.05s;
                border-radius: 4px;
                padding: 5px;
                display: flex;
                overflow-y: scroll;
                position: relative;
            }
            .botao{
                width: 60px;
                height: 15%;
                bottom: 0;
                background: none;
                margin: 5px auto 5px auto;
                background-color: black;
                color: white;
                position: absolute;
            }
            .botao .botao-acao{
                background: none;
                color: white;
            }
            .acoes .div:hover{
                box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
            }
        </style>

        <div class="hr"> <hr> <span> Gráficos </span> <hr> </div>
        <style>
            .hr{
                display: flex;
                width: 100%;
                justify-content: center;
                align-items: center;
                opacity: 0.40;
            }
            .hr hr{
                width: 99%;
                margin: 5px 3px 5px 3px;
                background-color: rgba(0, 0, 0, 0.5);
                height: 1px;
            }
            .hr span{
                font-weight: 500;
                font-family: Arial, Helvetica, sans-serif;
            }
        </style>

        <div class="graficos">
            <div class="entrada_saida">
                 <div id="barchart_material" style="width: 95%; height: 95%;"></div>
            </div>
            <div class="entrada_saida">
                <div id="barchart_values"  style="max-width: 100%; max-height:100%;"></div>
            </div>
            <div class="entrada_saida">
                <div id="barchart_values"  style="width: 95%; height: 95%;"></div>
            </div>
        </div>
        <style>
            .graficos {
                width: 100%;
                height: auto;
                margin: auto;
                display: flex;
                justify-content: space-between;
                box-sizing: border-box;
                font-family: Arial, Helvetica, sans-serif;
                padding: 15px;
                overflow-x: scroll !important;
            }
            .graficos::-webkit-scrollbar
            {
            display: none;
            scrollbar-width: none;
            }
            .titulo_grafico {
                color: #262626;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: white;
                text-align: center;
                padding: 5px;
                box-sizing: border-box;
            }
            .titulo_grafico h2{
                font-weight: 500;
            }
            .entrada_saida {
                width:100%;
                min-width: 400px;
                height: 240px;
                min-height: 240px;
                margin: 0px 10px 0px 10px;
                box-sizing: border-box;
                box-shadow: 1px 3px 1px 1px rgba(220, 220, 220, 1);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                position: relative;
                overflow: hidden;
                color: var(--preto);
                border-radius: 2px;
                transition: 0.1s;
                border-radius: 5px;
            }
            .entrada_saida:hover{
                transform: scale(1.01);
                box-shadow: 1px 3px 2px 1px rgba(220, 220, 220, 0.9);
            }

        </style>

    </section>
</main>

</body>
</html>
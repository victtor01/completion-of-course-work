<?php
if(empty($_SESSION[''])){
session_start();
}

if (isset($_SESSION['id']) && isset($_SESSION['nome'])) {
    include_once('../PHP/conexao.php');

    $sql = "SELECT SUM(quantidade) as SOMA FROM produto";
    $query = mysqli_query($conexao, $sql);
    $row = $query->fetch_assoc();
    $SUM = $row['SOMA'];

    $sql =  "SELECT COUNT(*) as CONTAGEM FROM produto ";
    $query = mysqli_query($conexao, $sql);
    $row = $query->fetch_assoc();
    $COUNT = $row['CONTAGEM'];

    $sql = "SELECT COUNT(*) as CONTAGEM_FOR FROM fornecedor";
    $query = $conexao->query($sql);
    $row = $query->fetch_assoc();
    $COUNT_FOR = $row['CONTAGEM_FOR'];
    

    require_once '../PHP/funcionarios.php';
    $funcionario = new funcionario;
    $funcionario = $funcionario->getFuncionario();

} else {
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
    <link rel="stylesheet" href="../CSS/style.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../JS/script.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <title>Painel</title>
</head>

<body>

<header class="header-titulo titulo-principal">
        <div style="width: 100%; height: 100%; align-items: center; display: flex; position: relative; cursor: pointer;">
            <a href="painel.php" style="text-decoration: none; color: white; display: flex; justify-content: left; font-size: 12pt;">
                <img src="../imagens/box.png" width="45px" height="45px;" style="margin-right: 30px;">
                <h1 style="margin-right: 50px;"> Controle de Estoque </h1>
            </a>
            <div style="right: 0; position: absolute; color: #FF731D; display: flex;">
                <h2> Ola,  <?php echo $funcionario['PrimeiroNome']?>!</h2>
            </div>
        </div>
    </header>

    <main>

    <div class="barra-lateral">
            <header>
                <div class="imagem">
                    <img src="<?php echo $funcionario['foto']; ?>" width="150" height="150">
                </div>
                <h2 style="margin-top: 10px;"> <?php echo $funcionario['nome']; ?> </h2> 
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

            <div class="principais-acoes">
                <button class="acao button" id="produtos">

                    <p> <?php echo $COUNT ?> Produtos Cadastrados</p>
                    <p> <?php echo $SUM ?> Itens no estoque </p>
                    <div class="link_acao" id="link_produtos">
                        <a href="produtos.php">Produtos</a>
                    </div>

                </button>

                <button class="acao button" id="fornecedores">

                    <p> Total de <?php echo $COUNT_FOR ?> fornecedores </p>
                    <div class="link_acao" id="link_fornecedores">
                        <a href="fornecedores.php">Fornecedores</a>
                    </div>

                </button>

                <button class="acao acao-3 button">

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

    <script type="text/javascript">

        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            let data = google.visualization.arrayToDataTable([

                ['data', 'entrada', 'saida'],
                <?php

                $sql_date = "SELECT DISTINCT YEAR (data_saida) as ano, MONTH (data_saida) as mes, DAY(data_saida) as dia FROM saida 
                UNION SELECT DISTINCT YEAR (data_entrada) as ano, MONTH(data_entrada) as mes, DAY(data_entrada) as dia FROM entrada 
                ORDER BY mes,dia ASC LIMIT 30";

                $query = $conexao->query($sql_date);

                while($date = mysqli_fetch_assoc($query)){
                    $ano = $date['ano'];
                    $mes = $date['mes'];
                    $dia = $date['dia'];

                    $data = $ano ."-". $mes ."-". $dia;

                    $sql_entrada = "SELECT SUM(quantidade_entrada) as quantidade_entrada FROM entrada WHERE data_entrada = '$data'";
                    $queryEntrada = $conexao->query($sql_entrada);

                    $sql_saida = "SELECT SUM(quantidade) as quantidade_saida FROM saida WHERE data_saida = '$data'";
                    $querySaida = $conexao->query($sql_saida);

                    $row = $queryEntrada->fetch_assoc();
                    $quantidadeEntrada = intval($row['quantidade_entrada']);
                    
                    $row = $querySaida->fetch_assoc();
                    $quantidadeSaida = intval($row['quantidade_saida']);
                    
                ?>

                ['<?php echo  $dia.'-'. $mes?>',<?php echo $quantidadeEntrada?>,<?php echo $quantidadeSaida?>],

                <?php } ?>
            ]);
            let data2 = google.visualization.arrayToDataTable([
                ['Year', 'Sales', 'Expenses'],
                ['2013', 1000, 400],
                ['2014', 1170, 460],
                ['2015', 660, 1120],
                ['2016', 1030, 540]
            ]);

            let options = {
                title: 'Entrada e saída de produtos',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                }

            };
            let options2 = {
                title: 'Company Performance',
                hAxis: {
                    title: 'Year',
                    titleTextStyle: {
                        color: '#333'
                    }
                },
                vAxis: {
                    minValue: 0
                }
            }

            let chart2 = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart2.draw(data2, options2);

            let chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
            
        }


    </script>

</body>
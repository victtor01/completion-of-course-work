<?php

include '../PHP/validarSessao.php';
include_once '../PHP/conexao.php';
include_once '../php/clientes.php';
include_once '../PHP/funcionarios.php';

$funcionario = new funcionario;
$funcionario = $funcionario->getFuncionario();

?>

<!DOCTYPE html>
<html lang="en">
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

    <title>Clientes</title>
</head>
<body>
    <header class="header-titulo titulo-principal">
        <div style="width: 100%; height: 100%; align-items: center; display: flex; position: relative;">
            <a href="painel.php" style="text-decoration: none; color: white; display: flex; justify-content: left; font-size: 10pt;">
                <img src="../imagens/box.png" width="40px" height="40px;" style="margin-right: 30px;">
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
        <form action="../PHP/clientes.php" method="post" style="width: 100%;">
            <section class="section-principal">
                <header class="header-titulo titulo-section">
                    <h1> Clientes </h1>
                </header>
                <div class="botoes-principais">
                    <div class="div">
                        <button type="button" class="botao" id="button-entrada" onclick="abrirmodal('button-entrada')">
                            <ion-icon name="add-outline" style="width: 30px; height: 100%;"></ion-icon>
                            <span> Cadastro </span> 
                        </button>
                    </div>
                    <div class="div-pesquisar div">
                        <input type="text" placeholder="Pesquise..." class="pesquisar">
                        <button type="button" class="btn-pesquisar" style="border: none; background: none;">
                            <img src="../imagens/lupa.png" width="25px" height="25px">
                        </button>
                    </div>
                    <div class="div">
                        <button type="submit" class="botao" id="modalremessa" value="submit-saida-produto" name="submit-entrada-produto">
                        <ion-icon name="enter-outline" style="width: 30px; height: 100%;"></ion-icon>
                            Guardar
                        </button>
                    </div>
                </div>
                <section class="section-informacoes">
                    <?php
                    $cliente = new cliente;
                    $cliente->MostrarClientes();
                    ?>
                </section>
            </section>
        </form>
    </main>

    <dialog id="modal-entrada" class="modal">

        <header class="header-cadastro">
            <!-- titulo da parte de registro de produto -->
            <h2 style="font-weight: 400;">Cadastrar Clientes</h2>
            <!-- botao que vai fechar a parte de registor de produto-->
            <button type="button" style="background: none;" onclick="fecharmodal('button-entrada-fechar')">
            <ion-icon style="width: 40px; height: 40px;"name="close-outline"></ion-icon>
            </button>

        </header>

        <section class="section-cadastro">
            <form method="POST" action="../PHP/clientes.php" enctype="multipart/form-data">
                <label class="informacoes">
                    <label class="label-titulo"> Nome do Cliente: * </label>
                    <input name="nome" type="text" class="input-registro" placeholder="João" autocomplete="off" required>
                </label>

                <!-- Idade - Cargo-->
                <div class="div-informacoes">
                    <label class="label-quantidade">
                        <label class="label-titulo"> CPF </label>
                        <input name="CPF" type="text" class="input-registro" placeholder="000.000.000-00" autocomplete="off" required>
                    </label>
                </div>

                <!--  Data - Foto-->
                <div class="div-informacoes">
                    <label class="label-data">
                        <label class="label-titulo"> Data de Nascimento: * </label>
                        <input name="data" type="date" class="input-registro" autocomplete="off" required>
                    </label>
                    <label>
                        <label class="label-titulo"> Foto: </label>
                        <input class="foto" name="foto" type="file">
                    </label>
                </div>

                <!-- Salário - Contato -->
                <div class="div-informacoes">
                    <label class="label-numero">
                        <label class="label-titulo"> Contato: *</label>
                        <input name="contato" type="text" class="input-registro" placeholder="(99)9999-9999" autocomplete="off" required>
                    </label>
                </div>
                
                <!-- Email -->
                <div class="div-informacoes">
                    <label class="label-numero">
                        <label class="label-titulo"> Email: *</label>
                        <input name="email" type="email" class="input-registro" placeholder="example@gmail.com" autocomplete="off" required>
                    </label>
                </div>

                <!-- butao (submit) para enviar o produto para o banco de dados-->
                <div class="botoes-submit">
                    <button type="reset" class="botao2"> Limpar </button>
                    <button type="submit" name="inserir" class="botao1"> cadastrar</button>
                </div>
            </form>
        </section>

    </dialog>
</body>
</html>
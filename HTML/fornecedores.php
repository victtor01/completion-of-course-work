<?php

if(empty($_SESSION['id'])){
    session_start();
}

if(!isset($_SESSION['id']) || !isset($_SESSION['nome'])){
    header('Location: ../login.html');
    die();
}

include_once '../PHP/conexao.php';
include_once '../PHP/fornecedor.php';
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

    <script src="../JS/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


    <title>Produtos</title>

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
                <a class="selecionado">
                    <ion-icon name="person-outline"></ion-icon> <span> Fornecedores </span>
                </a>
                <button class="clientes-funcionarios" id="botao-financeiro" onclick="Financeiro()">
                    <ion-icon name="cash-outline"></ion-icon></ion-icon> <span> Financeiro </span>
                    <ion-icon name="chevron-forward-outline" id="ion-icon-seta-financeiro" width='10px'></ion-icon>    
                </button>
                <div class="href-clientes-funcionarios" id="href-financeiro">
                    <!-- <a href="#">
                        <span> Dashboard </span>
                    </a> -->
                    <a href="entrada.php">
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

        <section class="section-principal section-fornecedor">
            <!-- TITULO DA SECTION -->
            <header class="header-titulo titulo-section">
                <h1>
                    Fornecedores
                </h1>
            </header>

            <!-- BOTOES PRINCIPAIS DE ADICIONAR UM NOVO FORNECEDOR  -->
            <div class="botoes-principais">
                <!-- ADICIONAR FORNECEDOR -->
                <div class="div">
                    <button type="button" class="botao" onclick="clicar_fornecedor()"> Adicionar </button>
                </div>
                <div class="div">
                    <button type="button" class="botao" id="guardarFuncionarios"> guardar </button>
                </div>

            </div>

            <!-- SECTION ONDE FICARA A TABELA COM OS FORNECEDORES -->
            <section>
                <!-- TABELA -->
                <table style="margin: 5px auto 10px auto">
                    <!-- HEAD DA TABELA-->
                    <thead>
                        <tr class="tr">
                            <th> id </th>
                            <th> Nome</th>
                            <th> Email </th>
                            <th> Telefone </th>
                            <th> </th>
                        </tr>
                    </thead>
                    <!-- PHP PARA MOSTRAR OS FORNECEDORES -->
                    <tr>
                        <?php
                        $sql = "SELECT * FROM fornecedor ORDER BY id_fornecedor ASC ";
                        $result = $conexao->query($sql);
                        while ($user_data = mysqli_fetch_assoc($result)) {

                            echo "<tr id='tr[$user_data[id_fornecedor]]'>";
                            echo "<td>" . $user_data['id_fornecedor'] . "</td>";
                            echo "<td><input name='' id='nome_fornecedor[$user_data[id_fornecedor]]' value='$user_data[nome]' type='text' />" . "</td>";
                            echo "<td><input name='' id='email_fornecedor[$user_data[id_fornecedor]]' value='$user_data[email]' type='text' />" . "</td>";
                            echo "<td><input name='' id='telefone_fornecedor[$user_data[id_fornecedor]]' value='$user_data[telefone]' type='text' />". "</td>" ;

                            //BOTOES DE EDITAR E EXCLUIR
                            ?>
                            <td style='max-width: 30px; min-width: 100px'>
    
                                <button class='editar editarFornecedor' type='button' id="<?php echo $user_data['id_fornecedor'] ?>">
                                    <a style='width: 35px; height: 35px;' name='id_produto'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                        </svg>
                                    </a>
                                </button> 

                                <script>
                                    let buttonEditarFornecedor = window.document.getElementsByClassName('editarFornecedor')

                                    for (var but of buttonEditarFornecedor) {
                                        but.addEventListener('click', function() {

                                            let id = this.id
                                            
                                            const nome = window.document.getElementById(`nome_fornecedor[${id}]`);
                                            const email = window.document.getElementById(`email_fornecedor[${id}]`);
                                            const telefone = window.document.getElementById(`telefone_fornecedor[${id}]`);
                                            
                                            $.post("../PHP/fornecedor.php", {id: id, update: true, nome: nome.value, email: email.value, telefone: telefone.value}, function(res){
                                                alert(res)
                                            })
                                            
                                        })
                                    }


                                </script>
                    
                    
                                <button class='editar button-delete' type='button'>
                                    <a style='width: 35px; height: 35px;' name='id_produto' href="../PHP/fornecedor.php?id_fornecedor='<?php echo $user_data['id_fornecedor']; ?>'">
                                        <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                        <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                                        <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                                        </svg>
                                    </a>
                                </button>
                        
                            </td>

                            </tr>

                            <?php
                        }
                        ?>
                    </tr>

                </table>

            </section>
        </section>

    </main>

    <!-- FUNDO PARA CADASTRAR FORNECEDOR OBS: FICARÁ ESCONDIDA ATÉ QUE O USUÁRIO APERTA PARA CADASTRAR-->
    <div class="fundo-registrar-fornecedor" id="fundo-registrar-fornecedor">
        <!-- DIV PARA CADASTRAR FORNECEDOR -->
        <div class="registrar-fornecedor" id="registrar-fornecedor">
            <!-- TITULO -->
            <header class="header-cadastro">

                <!-- TITULO DO HEADER -->
                <h1>cadastrar Fornecedor</h1>

                <!-- BOTAO PARA FECHAR A DIV -->
                <button type="button" style="background: none; position:static; right: 0; top: 0;" id="button-forn" class="button">
                    <ion-icon style="width: 30px; height: 30px;" name="close-outline"></ion-icon>
                </button>

            </header>

            <script>
                let button = document.getElementById('button-forn');
                button.addEventListener('click', () => {
                    let fundo = document.getElementById('fundo-registrar-fornecedor');
                    let content = document.getElementById('registrar-fornecedor');
                    fundo.style.cssText = 'display: none';
                    content.style.cssText = 'display: none'
                })
            </script>

            <!-- CADASTRAR NOVO FORNECEDOR -->
            <form action="../PHP/fornecedor.php" method="POST">
                <input type="text" name="nome_fornecedor" placeholder="nome">
                <input type="text" name="email_fornecedor" placeholder="email">
                <input type="text" name="telefone_fornecedor" placeholder="telefone">
                <button type="submit" name="cadastrar-fornecedor"> cadastrar </button>
            </form>
        </div>
    </div>

    <style>
        .registrar-fornecedor {
            padding: 0.4rem;
            height: auto;
        }
        .registrar-fornecedor header h1{
            font-size: 1rem;
            font-weight: 300;
        }
        .registrar-fornecedor form {
            display: flex;
            flex-direction: column;
        }
        .registrar-fornecedor form input{
            margin: 0.5rem 0 1rem 0;
            height: 2.8rem;
            border: none;
            background-color: #fff;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
            border-radius: 0.2rem;
            padding-left: 0.3rem;
            outline: none;
        }
        .registrar-fornecedor form button{
            height: 2rem;
        }
    </style>

    <script>
        let button_deletar = window.document.getElementsByClassName('button-delete')

        for (var but of button_deletar) {
            but.addEventListener('click', function() {
                let confirm = window.confirm('Deseja Excluir esse registro de entrada?')

                if(!confirm)
                {
                    return alert('cancelado!')   
                }

                let id = this.id
                alert(id)

                $.post("../PHP/fornecedor.php", {id: id}, function(res){
                    let button = window.document.getElementById(`tr[${id}]`);
                    button.style.cssText = 'display: none'
                    alert(res);
                })
                
            })
        }
    </script>
</body>
<?php

if(isset($_GET['nome'])){
    $nome = $_GET['nome'];
    $id = $_GET['id_categoria'];
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styleprodutos.css">
    <script src="JS/script.js"></script>

    <title>Editar categoria</title>
</head>
<body>

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
    <section class="section-principal">
            <header class="header-titulo titulo-section"> 

                <h1> editar categoria </h1>

            </header>
            <section class="section-secundaria-editar-categoria">
                <form action="../PHP/edit-categoria.php" method="POST">

                    <label class="label-titulo"> Novo nome: </label>
                    <input type="text" name="nome" placeholder="Digite o novo nome aqui" 
                    value = "<?php echo $nome?>" class="input_editar">
                    <input type="hidden" name="id" value="<?php echo $id?>">
                    <button type="submit" name="update"> Enviar </button>

                </form>
            </section>
    </section>
    </main>
</body>
</html>
<?php
if(empty($_SESSION['id'])){
session_start();
}

if(!isset($_SESSION['nome']) || !isset($_SESSION['id']) || !isset($_SESSION['cargo'])){
    header('Location: ../login.php');
    die();
}

include_once 'links.php';
class produto extends links_pages
{
    public function CosntrutorImagem($foto){
        $pasta = "../imagens/imagens-pro/";
        $imagem = uniqid();
        $imagem_nome = $foto['name'];
        $extensao = strtolower(pathinfo($imagem_nome, PATHINFO_EXTENSION));

        if($extensao != 'jpg' &&  $extensao != 'png' ) { 
            header('Location: ../HTML/produtos.php'); 
            die(); 
        }
        else { 
            $patch = $pasta . $imagem . "." . $extensao;  
            $move = move_uploaded_file($foto["tmp_name"], $patch); 
            return $patch;
        }
    }
    public function inserir()
    {
        $produto = new produto;
        include 'conexao.PHP';

        $nome =  $_POST['nome'];
        $categoria =  $_POST['categoria'];
        $quantidade =  $_POST['quantidade'];
        $fornecedor =  $_POST['fornecedor'];
        $valor_investido =  $_POST['investimento'];
        $lucro_esperado = $_POST['lucro'];
        $data_produto = $_POST['data'];
        $tamanho = $_POST['tamanho'];
        $foto = $_FILES['foto'];

        $patch = $produto->CosntrutorImagem($foto);

        $inserir_produto  = "INSERT INTO produto (nome, categoria, quantidade, 
        fornecedor, valor_investido, lucro_esperado, tamanho, data_produto, foto)
        VALUES ('$nome', $categoria, '$quantidade',$fornecedor, '$valor_investido', 
        '$lucro_esperado', '$tamanho','$data_produto', '$patch')";

        $query_result = mysqli_query($conexao, $inserir_produto);

        if($query_result){
            $produto->entrada($quantidade, $nome, $valor_investido, $data_produto, 
            $tamanho, $categoria, $fornecedor);
        }

        $msg = $query_result? 1 : 0;
        header('Location: '. $this->link_produtos . '?msg=' . $msg);
        die();
    }
    public function retirar()
    {
        include('conexao.PHP');
        $produtos = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        foreach ($produtos['id'] as $chave => $id){

            $id_produto = $produtos['id'][$chave];
            $nome = $produtos['nome'][$chave];
            $quantidade_retirada = $produtos['quantidade'][$chave];
            $preco = $produtos['preco'][$chave];
            $categoria = $produtos['categoria'][$chave];
            $fornecedor = $produtos['fornecedor'][$chave];
            $data = $produtos['data'];
            $tamanho = $produtos['tamanho'][$chave];
            $valor_total = (intval($quantidade_retirada) * intval($preco));

            $sql_quantidade_atual = "SELECT quantidade FROM produto WHERE id_produto=$id_produto";
            $query = mysqli_query($conexao, $sql_quantidade_atual);

            $quant = mysqli_fetch_assoc($query);
            $quantidade_atual = $quant['quantidade'];

            $resto = (intval($quantidade_atual) - intval($quantidade_retirada));

            if ($resto < 0){ exit; }

            $sql_update = "UPDATE produto SET quantidade = '$resto' WHERE id_produto=$id_produto";
            $query = mysqli_query($conexao, $sql_update);
            $produto = new produto;
            $produto->saida($nome, $preco, $data, $tamanho, $categoria, $fornecedor, $quantidade_retirada, $valor_total);

        }

        header('Location: '. $this->link_produtos);
    
    }
    public function delete($id)
    {
        include_once('conexao.PHP');
        $sql = "SELECT quantidade FROM produto WHERE id_produto = $id LIMIT 1";
        $query = mysqli_query($conexao, $sql);
        $row = $query->fetch_array();

        
        if($row['quantidade'] > 0) {
            header('Location: '. $this->link_produtos . "?msg=2");
            die();
        }else{
            $sql = "DELETE FROM produto WHERE id_produto = $id ";
            $query = mysqli_query($conexao, $sql);
            header('Location: '. $this->link_produtos . "?msg=1");
        }


    }
    public function ModalEditar()
    {
        if(isset($_GET['id_produto'])){

            ?>
            <script>
                let modal_ = window.document.getElementById('modal-editar');
                modal_.showModal();
            </script>
            <?php

            include 'conexao.php';
            $id = $_GET['id_produto'];
            $sql = "SELECT * FROM produto WHERE id_produto = $id";
            $query = mysqli_query($conexao, $sql);
            $row = $query->fetch_assoc();

            $sql = "SELECT * FROM fornecedor";
            $queryFornecedor = mysqli_query($conexao, $sql);

            $sql = "SELECT * FROM categoria";
            $queryCategoria = mysqli_query($conexao, $sql);

            $porcento =  $row['valor_investido'] * ($row['lucro_esperado']/100);
            $valor_venda = $row['valor_investido'] + $porcento;

            ?>
                <section class="section-cadastro">
                    <form method="POST" action="../PHP/produto.php" enctype="multipart/form-data">
                        <div class="div-info">
                            <label class="div-foto">

                                <div class="div-file-foto">
                                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                </svg>
                                
                                <input name="foto" type="file">
                                </div>
                        
                                <img src="<?php echo $row['foto']?>" alt="" width="100%" height="100%">

                            </label>
                            <div class="div-label-info">
                                <input type="hidden" name="id_produto" value="<?php echo $row['id_produto']?>">
                                <label class="label-info">
                                    <span> Nome: </span>
                                    <input type="text" name="nome" value="<?php echo $row['nome'] ?>">
                                </label>
                                <label class="label-info">
                                    <span>Categoria:</span>
                                    <select name="categoria" id="">
                                        <option value=''> nenhum</option>
                                        <?php 
                                            while($categoria = mysqli_fetch_assoc($queryCategoria)){
                                                echo "<option value='$categoria[id_categoria]'";     
                                                if($categoria['id_categoria'] == $row['categoria']) { echo "selected"; }
                                                echo ">" . $categoria['id_categoria'] . " - " . $categoria['nome'] . "</option>";   
                                            }
                                        ?>
                                    </select>
                                </label>
                                <label class="label-info">
                                    <span>Tamanho:</span>
                                    <select name="tamanho">
                                        <option value="1" <?php if($row['tamanho'] == 1){echo "selected";}?>> PP </option>
                                        <option value="2" <?php if($row['tamanho'] == 2){echo "selected";}?>> P </option>
                                        <option value="3" <?php if($row['tamanho'] == 3){echo "selected";}?>> M </option>
                                        <option value="4" <?php if($row['tamanho'] == 4){echo "selected";}?>> G </option>
                                        <option value="5" <?php if($row['tamanho'] == 5){echo "selected";}?>> GG </option>
                                    </select>
                                </label>
                                <label class="label-info">
                                    <span>Quantidade:</span>
                                    <input type="text" name="quantidade" value="<?php echo $row['quantidade'] ?>">
                                </label>
                                <label class="label-info">
                                    <span>Preço de Compra:</span>
                                    <input onkeyup="LucroPorcentagem()" id="preco_compra" type="text" name="preco" value="<?php echo $row['valor_investido'] ?>">
                                </label>
                                <label class="label-info">
                                    <span>Preço de Venda:</span>
                                    <input onkeyup="LucroPorcentagem()" id="preco_venda_" type="text" name="valor_venda" value="<?php echo $valor_venda ?>">
                                </label>
                                <label class="label-info">
                                    <span>Lucro (%):</span>
                                    <input id="lucro_" type="text" name="lucro" value="<?php echo $row['lucro_esperado']?>">
                                </label>
                                <label class="label-info">
                                    <span>Data:</span>
                                    <input type="text" name="data" value="<?php echo $row['data_produto'] ?>">
                                </label>
                                <label class="label-info">
                                    <span>Fornecedor:</span>
                                    <select name="fornecedor" id="">
                                        <option value=''> nenhum</option>
                                        <?php 
                                            while($fornecedor = mysqli_fetch_assoc($queryFornecedor)){

                                                echo "<option value='$fornecedor[id_fornecedor]'";     
                                                if($fornecedor['id_fornecedor'] == $row['fornecedor']) { echo "selected"; }
                                                echo ">" . $fornecedor['id_fornecedor'] . " - " . $fornecedor['nome'] . "</option>";   

                                            }
                                        ?>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <hr>
                        <div class="botoes">
                            <button type="submit" name="submit-update-produto" class="button-enviar">
                                Enviar
                            </button>
                        </div>
                    </form>
                </section>

                <script>

                    function LucroPorcentagem(){

                    let valor_unidade = window.document.getElementById('preco_compra').value;
                    let valor_venda = window.document.getElementById('preco_venda_').value;

                    console.log("preco:" + valor_venda);
                    let valor = parseFloat(valor_unidade);
                    let preco = parseFloat(valor_venda);
                    console.log(valor);
                    console.log(preco);
                    
                    let diferenca = (preco - valor);
                    let porcentagem = (diferenca / valor);
                    let subtotal = (porcentagem * 100);

                    var total = parseFloat(subtotal);
                    total = round(total);

                    let lucro = window.document.getElementById('lucro_');
                    lucro.value = total;
                    }

                    function round(num) {
                    var m = Number((Math.abs(num) * 100).toPrecision(15));
                    return Math.round(m) / 100 * Math.sign(num);
                    }

                </script>
                
            <?php
        }
    } 
    public function EditarProduto()
    {
        
        include 'conexao.php';
        $id = $_POST['id_produto'];
        $sql = "SELECT * FROM produto WHERE id_produto = $id";
        $query = mysqli_query($conexao, $sql);
        $row = $query->fetch_assoc();
        $tmp = $row['quantidade'];
        
        $nome = $_POST['nome'];
        $categoria = $_POST['categoria'];
        $tamanho = $_POST['tamanho'];
        $quantidade = $_POST['quantidade'];
        $preco = $_POST['preco'];
        $data = $_POST['data'];
        $fornecedor = $_POST['fornecedor'];
        $lucro = $_POST['lucro'];
        $foto = $_FILES['foto'];

        if($foto['size'] == 0){
            $foto = $row['foto'];
            $sql = "UPDATE produto SET nome='$nome', categoria='$categoria',
            tamanho='$tamanho',  quantidade='$quantidade', valor_investido='$preco', data_produto='$data',
            fornecedor='$fornecedor', foto='$foto', lucro_esperado='$lucro' WHERE id_produto = $id";
            $query = mysqli_query($conexao, $sql);
        }
        else{
            $pasta = "../imagens/imagens-pro/";
            $imagem = uniqid();
            $imagem_nome = $foto['name'];
            $extensao = strtolower(pathinfo($imagem_nome, PATHINFO_EXTENSION));

            if($extensao != 'jpg' &&  $extensao != 'png' ) 
            { header('Location: ../HTML/produtos.php'); die(); }
            else
            { $patch = $pasta . $imagem . "." . $extensao;  
            $move = move_uploaded_file($foto["tmp_name"], $patch);}

            $sql = "UPDATE produto SET nome='$nome', categoria='$categoria',
            tamanho='$tamanho', quantidade='$quantidade', valor_investido='$preco', data_produto='$data',
            fornecedor='$fornecedor', foto='$patch' lucro_esperado='$lucro' WHERE id_produto = $id";
            $query = mysqli_query($conexao, $sql);
        }

        header('Location: ../html/produtos.php');
    }
    public function mostrar_produtos()
    {
        include 'conexao.PHP';
        include 'LimitPages.php';
        $pagina = Paginas("produto", 7);
        $pagina['inicio'];
        $pagina['num_paginas'];

        $sql = "SELECT * FROM produto ORDER BY data_produto DESC LIMIT $pagina[inicio], $pagina[quantidadePorPagina]";
        $result = mysqli_query($conexao, $sql);

        if (mysqli_num_rows($result) > 0) {
        ?>
            <table>
            <thead>
                <tr class='tr'>
                    <th style="min-width: 30px;"></th>
                    <th> Nome </th>
                    <th> Categoria</th>
                    <th> Tamanho</th>
                    <th > Quantidade</th>
                    <th style ="max-width: 40px"> Preço de Compra</th>
                    <th max-width='40px'> Lucro (%) </th>
                    <th> Preço de venda: </th>
                    <th> Data</th>
                    <th style='min-width: 100px;'> Ações </th>
                </tr>
            </thead>

        <?php
        while ($user_data = mysqli_fetch_assoc($result)){

        $id = $user_data['id_produto'];
        $nome = $user_data['nome'];
        $categoria = $user_data['categoria'];
        $quantidade = $user_data['quantidade'];
        $fornecedor = $user_data['fornecedor'];
        $valor_investido = $user_data['valor_investido'];
        $lucro_esperado = $user_data['lucro_esperado'];
        $tamanho = $user_data['tamanho'];
        $data = $user_data['data_produto'];

        $sql_fornecedor = "SELECT nome FROM fornecedor WHERE id_fornecedor = $fornecedor";
        $result_fornecedor = mysqli_query($conexao, $sql_fornecedor);
        $row = $result_fornecedor->fetch_assoc();
        $fornecedor_nome = $row["nome"];

        $sql_categoria = "SELECT nome FROM categoria WHERE id_categoria = $categoria";
        $result_categoria = mysqli_query($conexao, $sql_categoria);
        $row = $result_categoria->fetch_assoc();
        $categoria_nome = $row["nome"];


            echo "<tr> <td>";
                echo "<input type='checkbox' style='width: 70%; height: 70%; border-radius: 5px; 
                'name='checkbox_id[$id]' value='" . $id . "'>";
            echo "</td>";

            echo "<td style='max-width: 120px; '>";
                echo $nome;
            echo "</td>";

            echo "<td style='max-width: 120px; '>";
                echo $categoria_nome;
            echo "</td>";

            echo "<td>";
                switch ($tamanho) {
                    case 1:
                        echo "PP";
                        break;
                    case 2:
                        echo "P";
                        break;
                    case 3:
                        echo "M";
                        break;
                    case 4:
                        echo "G";
                        break;
                    case 5:
                        echo "GG";
                        break;
                }
            echo "</td>";

            echo "<td style='color: "; 
                if ($quantidade > 5) { echo "green;'>"; } 
                elseif ($quantidade > 0) { echo "blue;'>"; } 
                else {echo "red;'>"; }
            echo $quantidade . "</td>";

            echo "<td> R$ " 
                . $valor_investido .
                "</td>";

            echo "<td> $lucro_esperado %</td>";
            $porcento = ($lucro_esperado/100) * $valor_investido;
            $preco_venda = $valor_investido + $porcento;
            echo "<td>R$" . intval($preco_venda) ."</td>";

            echo "<td>" . $data . "</td>";

            echo 
            "<td style='max-width: 50px; min-width: 20px;'>

                <button class='editar' type='button'>
                    <a style='width: 35px; height: 35px;name='id_produto' href='?id_produto=$user_data[id_produto]&button-update-produto=1'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                        </svg>
                    </a>
                </button> 
    
    
                <button class='editar' type='button'>
                    <a style='width: 35px; height: 35px;' name='id_produto' href='../PHP/produto.php?id_produto=$user_data[id_produto]&delete=on'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                        <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                        <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                        </svg>
                    </a>
                </button>
                
            </td>";

            echo 
            "</tr>";
        }
        echo "</table>";
        ?>

        <footer class="footer">
            <nav  class="paginacao">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#"><ion-icon name="chevron-back-outline"></ion-icon></a>
                </li>
                <?php for($i = 1; $i < $pagina['num_paginas'] + 1; $i++){ ?>
                    <li class="page-item">
                        <a class="page-link" href="produtos.php?pagina=<?php echo $i?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
                <li class="page-item">
                    <a class="page-link" href="#"><ion-icon name="chevron-forward-outline"></ion-icon></a>
                </li>
            </ul>
            </nav>
        </footer>

        <?php
        } 
        else { echo "<h3> Nenhum produto cadastrado </h3>"; }
        
    }
    public function validar($dados, $opcao)
    {
        include_once('conexao.PHP');

        if (!empty($dados['checkbox_id'])) {
            $pesquisa = implode(", ", $dados['checkbox_id']);
            header("Location: ../HTML/produtos.php?pesquisa=".$pesquisa. "&opcao=" .$opcao);
        } else {
            header("Location: ../HTML/produtos.php");
        }
    }
    private function entrada($quantidade, $nome, $valor, 
    $data, $tamanho, $categoria, $fornecedor)
    {
        include('conexao.PHP');
        $sql = "INSERT INTO entrada(nome, categoria, fornecedor, quantidade_entrada, tamanho, valor, data_entrada)
        VALUES ('$nome', '$categoria', '$fornecedor', '$quantidade', '$tamanho', '$valor', '$data')";
        $result = mysqli_query($conexao, $sql);

    }
    private function saida($nome, $valor, $data, $tamanho, 
    $categoria, $fornecedor, $quantidade, $valor_total)
    {
        include('conexao.PHP');
        $sql = "INSERT INTO saida(quantidade, valor_produto, nome_produto,
            data_saida, tamanho, categoria, fornecedor, valor_total) 
            VALUES ('$quantidade', '$valor', '$nome', '$data', '$tamanho', '$categoria', '$fornecedor', '$valor_total')";

        $query = mysqli_query($conexao, $sql);
    }
    public function modal_produtos_selecionados($pesquisa)
    {

        include('conexao.PHP');
        $sql = "SELECT * FROM produto WHERE id_produto IN ($pesquisa)";
        $result = mysqli_query($conexao, $sql);


        if (mysqli_num_rows($result) > 0) {
            echo" 
            <script>
                var modal_ = window.document.getElementById('modal-saida');
                modal_.showModal();
            </script>";

            while ($produto_data = mysqli_fetch_assoc($result)) {

            $id = $produto_data['id_produto'];
            $nome = $produto_data['nome'];
            $categoria = $produto_data['categoria'];
            $tamanho = $produto_data['tamanho'];
            $quantidade = $produto_data['quantidade'];
            $fornecedor = $produto_data['fornecedor'];
            $preco = $produto_data['valor_investido'];
            $lucro_esperado = $produto_data['lucro_esperado'];
            $preco = $preco + ($preco * ($lucro_esperado/100));

            echo
            "<div class='modal-saida-select-result'>
                <input type='hidden' name='id[]' value='$id'>

                <label style='width: 100%; display: flex; flex-direction: column; '>
                    <span style=' width: 100%;'> nome: </span>
                    <span>" . $nome . " </span>
                    <input name='nome[]' type='hidden' value='" . $nome . "'>
                </label>

                <label style='width: 100%; display: flex;flex-direction: column;'>
                    <span style=' width: 100%;'> categoria: </span>
                    <span> " . $categoria . "</span>
                    <input name='categoria[]' type='hidden' value='" . $categoria . "'>
                </label>

                <label style='width: 100%; display: flex;flex-direction: column;'>
                    <span style=' width: 100%;'> tamanho: </span>
                    <span > ";
                    switch ($tamanho) {
                        case 1:
                            echo "P";
                            break;
                        case 2:
                            echo "PP";
                            break;
                        case 3:
                            echo "M";
                            break;
                        case 4:
                            echo "G";
                            break;
                        case 5:
                            echo "GG";
                            break;
                    }
                    echo 
                    "</span>
                <input type='hidden' name='tamanho[]' value='$tamanho'>
                </label>

                <label style='width: 100%; display: flex;flex-direction: column;'>
                    <span style=' width: 100%;'> quantidade: </span>
                    <span>" . $quantidade . " </span>
                </label>

                <label style='width: 100%; display: flex;flex-direction: column;'>
                    <span style=' width: 100%;'> valor (uni): </span>";
                    if($_GET['opcao'] == 1){
                        echo "<span type='text' style='text-transform: capitalize;'><strong>R$ $preco</strong></span>";
                    }
                    elseif($_GET['opcao'] == 2){
                        echo "<input name='preco[]' type='text' value='$preco'>";
                    }
                echo" 
                </label>

                <label style='width: 100%; display: flex;flex-direction: column;'>
                    <span style=' width: 100%;'> quantidade: </span>
                    <input name='quantidade[]' type='number' "; if($_GET['opcao'] == 2){ echo "max=$quantidade"; } echo ">
                </label>

                <input type='hidden' name='fornecedor[]' value=.$fornecedor.>

            </div>";
        }

        echo "<label style='width: 100%; display: flex;flex-direction: column;'>
                <span style=' width: 100%;'> data: </span>
                <input name='data' type='date' required>
            </label>";
        }
    }
    
}

$produto = new produto;

if (isset($_POST['submit-produto'])) {
    $produto->inserir();
} 

elseif (!empty($_GET['id_produto']) && !empty($_GET['delete'])) 
{
    if ($_GET['delete'] == 'on') {
        $id = $_GET['id_produto'];
        $produto->delete($id);
    }
} 

elseif (isset($_POST['submit-saida-produto']) || isset($_POST['submit-entrada-produto'])) 
{
        
    if(isset($_POST['submit-saida-produto'])){
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $produto->validar($dados, 2);
    }
    elseif(isset($_POST['submit-entrada-produto'])){
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $produto->validar($dados, 1);
    }
}

elseif (isset($_POST['retirar-produto'])) {
    $produto->retirar();
}

elseif(isset($_POST['submit-update-produto'])){
$produto->EditarProduto();
}

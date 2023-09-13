<?php
if(empty($_SESSION['id'])){
session_start();
}

if(!isset($_SESSION['nome']) || !isset($_SESSION['id']) || !isset($_SESSION['cargo'])){
    header('Location: ../login.php');
    die();
}

class Entrada
{
    static function all()
    {
        include ('conexao.PHP');
        include 'LimitPages.php';

        $pagina = Paginas("produto", 1000);
        $pagina["inicio"] . "<br>";
        $pagina['num_paginas'];

        $sql = "SELECT * FROM entrada ORDER BY id DESC LIMIT $pagina[inicio], $pagina[quantidadePorPagina]";
        $query = mysqli_query($conexao, $sql);

        if(mysqli_num_rows($query) < 1)
        {
            return '<div>Nenhum Registro</div>';
        }

        ?>

        <table>
            <thead>
                <tr class='tr'>
                    <th> Nome </th>
                    <th> Categoria </th>
                    <th> Fornecedor </th>
                    <th> Quantidade</th>
                    <th> Tamanho </th>
                    <th> Valor </th>
                    <th> Data </th>
                    <th> Opções </th>
                </tr>
            </thead>
            <tbody>
                <?php while($data = mysqli_fetch_assoc($query)): ?>
                    <tr id="tr[<?php echo $data['id']?>]" style="padding: 1rem">
                        <td><?php echo $data['nome']?></td>
                        <td><?php echo $data['categoria']?></td>
                        <td><?php echo $data['fornecedor']?></td>
                        <td><?php echo $data['quantidade_entrada']?></td>
                        <td><?php echo $data['tamanho']?></td>
                        <td><?php echo $data['valor']?></td>
                        <td><?php echo $data['data_entrada']?></td>
                        <td> <button style="background-color: #fff; padding: 0.4rem; border-radius: 5px; justify-content: center; align-items: center" class="button_entrada" id="<?php echo $data['id']?>">
                        <ion-icon name="trash-outline"></ion-icon></button> </td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>

        <footer class="footer">
            <nav  class="paginacao">
            <ul class="pagination">

                <li class="page-item">
                    <a class="page-link" href="#"><ion-icon name="chevron-back-outline"></ion-icon></a>
                </li>

                <?php for($i = 1; $i < $pagina['num_paginas'] + 1; $i++){ ?>
                    <li class="page-item">
                        <a class="page-link" href="entrada.php?pagina=<?php echo $i?>"><?php echo $i; ?></a>
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
    function delete($id)
    {
        require ('conexao.PHP');

        $sql = "DELETE FROM entrada WHERE id = {$id}";
        $query = $conexao->query($sql);

        if($query)
        {
            return true;
        }

        return false;
    }
}

$Entrada = new Entrada;

if(isset($_POST['id']))
{
    $confirm = $Entrada->delete($_POST['id']);
    echo json_encode($confirm);
    return $confirm;
}
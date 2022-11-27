<?php
include 'ValidarSessao.php';
class cliente{

    function ConstrutorImagem($foto){
        $pasta = "../imagens/imagens-cli/";
        $imagem = uniqid();
        $imagem_nome = $foto['name'];
        $extensao = strtolower(pathinfo($imagem_nome, PATHINFO_EXTENSION));

        if($extensao != 'jpg' && $extensao != 'png'){
            die("Erro!");
        }
        else{
            $patch = $pasta . $imagem . "." . $extensao;
            return $patch;
        }

    }
    function inserir_cliente(){
        $cliente = new cliente;
        $foto = $_FILES['foto'];
        $patch = $cliente->ConstrutorImagem($foto);

        include 'conexao.php';
        $sql = "INSERT INTO clientes(nome_cliente, CPF, data_nascimento, contato_cliente, email_cliente, 
        foto_cliente) VALUES ('$_POST[nome]', '$_POST[CPF]', '$_POST[data]', '$_POST[contato]', '$_POST[email]', '$patch')";
        $query = mysqli_query($conexao, $sql);

        if($query){
            $move = move_uploaded_file($foto["tmp_name"], $patch);
            header('Location: ../html/clientes.php');
            die();
        }
        
    }
    function MostrarClientes(){
        include 'conexao.php';
        $sql = "SELECT * FROM clientes";
        $query = mysqli_query($conexao, $sql);
        if (mysqli_num_rows($query) > 0) {
            ?>
                <table>
                <thead>
                    <tr class='tr'>
                        <th style="max-width: 10px;"> Foto </th>
                        <th> Nome </th>
                        <th> CPF </th>
                        <th> Contato </th>
                        <th> Email </th>
                        <th> data de nascimento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($cliente_data = mysqli_fetch_assoc($query)) {?>
                        <tr>
                            <td style="max-width: 35px;"> 
                                <img src="<?php echo $cliente_data['foto_cliente'];?>" style="width: 100%; height: 70px;"> 
                            </td>
                            <td>
                                <?php echo $cliente_data['nome_cliente']?>
                            </td>
                            <td>
                                <?php echo $cliente_data['CPF']?>
                            </td>
                            <td>
                                <?php echo $cliente_data['contato_cliente']?>
                            </td>
                            <td>
                                <?php echo $cliente_data['email_cliente']?>
                            </td>
                            <td>
                                <?php echo $cliente_data['data_nascimento']?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            <?php
        }
    }
}
$cliente = new cliente;
if(isset($_POST['nome'])){
$cliente->inserir_cliente();
}
?>
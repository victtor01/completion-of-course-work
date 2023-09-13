<?php
include 'ValidarSessao.php';
class cliente{

    function ConstrutorImagem($foto){
        $pasta = "../imagens/imagens-cli/";
        $imagem = uniqid();
        $imagem_nome = $foto['name'];
        $extensao = strtolower(pathinfo($imagem_nome, PATHINFO_EXTENSION));

        if($foto){
            if($extensao != 'jpg' && $extensao != 'png'){
                die("Erro!");
            }
            else{
                $patch = $pasta . $imagem . "." . $extensao;
                return $patch;
            }
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
                        <th id="th-foto-cliente" style="max-width: 0px; overflow: hidden; opacity: 0;"> Foto </th>
                        <th> Nome </th>
                        <th> CPF </th>
                        <th> Contato </th>
                        <th> Email </th>
                        <th> data de nascimento</th>
                        <th> Ações </th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($cliente_data = mysqli_fetch_assoc($query)) {?>
                        <tr onmouseout="esconderfoto(this)" onmouseover="mostrarfoto(this)" id="id_cliente[<?php echo $cliente_data['id_cliente']?>]" class="tr-cliente">
                            <td id="foto_cliente[<?php echo $cliente_data['id_cliente']?>]" class="td-cliente" style="max-width: 50px; opacity: 0; width: 0; border: 0;"> 
                                <img src="<?php echo $cliente_data['foto_cliente'];?>" style="width: 100%; height: 100%;"> 
                            </td>
                            <td class="td-cliente">
                                <input type="text" value="<?php echo $cliente_data['nome_cliente']?>">
                            </td>
                            <td class="td-cliente">
                                <input type="text" value="<?php echo $cliente_data['CPF']?>">
                            </td>
                            <td class="td-cliente">
                                <input type="text" value="<?php echo $cliente_data['contato_cliente']?>">
                            </td>
                            <td class="td-cliente">
                                <input type="text" value="<?php echo $cliente_data['email_cliente']?>">
                            </td>
                            <td class="td-cliente">
                                <input type="date" value="<?php echo $cliente_data['data_nascimento']?>">
                            </td>
                            <td>
                                <?php echo "teste"; ?>
                            </td>
                            <style>
                                .td-cliente{
                                    border-radius: 1px;
                                    padding: 0;
                                   
                                }
                                .td-cliente input{
                                    width: 80%;
                                    height: 50%;
                                    font-size: 12pt;
                                    padding: 10px;
                                    outline: none;
                                    border: none;
                                }
                                .td-cliente, #th-foto-cliente{
                                    transition: 0.3s;
                                    transition-delay: 0.6s;
                                }
                            </style>
                        </tr>
                        <script>
                            function mostrarfoto(e){
                                let id = e.id;
                                let td = window.document.getElementById(`${id}`);
                                let th = window.document.getElementById('th-foto-cliente');
                                let foto = td.children[0].id;
                                let imagem = window.document.getElementById(`${foto}`);

                                th.style.cssText = 
                                'max-width: 70px;' +
                                'opacity: 1';

                                imagem.style.cssText = 
                                'opacity: 1;'+
                                'width: 70px;' +
                                'border: none;' + 
                                'height: 80px;' + 
                                'transition-delay: 0.3s;';
                            }
                            function esconderfoto(e){
                                let id = e.id;
                                let td = window.document.getElementById(`${id}`);
                                let th = window.document.getElementById('th-foto-cliente');
                                let foto = td.children[0].id;

                                let imagem = window.document.getElementById(`${foto}`);
                                imagem.style.cssText = 
                                'transition-delay: 0.6s;'+
                                'opacity: 0;'+
                                'width: 0;' +
                                'border: none;'+
                                'height: 0px;';

                                th.style.cssText = 
                                'max-width: 0px;' +
                                'overflow: hidden;' +
                                'opacity: 0;';
                            }
                        </script>
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
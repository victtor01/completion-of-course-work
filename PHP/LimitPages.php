<?php
function Paginas($tabela){
    include('conexao.PHP');
    $pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;
    $sql = "SELECT * FROM " . $tabela;
    $query = mysqli_query($conexao, $sql);

    $total_produtos = mysqli_num_rows($query);
    $quantidadePorPagina = 12;

    $num_paginas = ceil($total_produtos/$quantidadePorPagina);
    $inicio = ($quantidadePorPagina * $pagina)-$quantidadePorPagina;
    
    return $vetor = array(
        "inicio" => $inicio,
        "num_paginas" => $num_paginas, 
        "quantidadePorPagina" => $quantidadePorPagina,
    );
}


?>

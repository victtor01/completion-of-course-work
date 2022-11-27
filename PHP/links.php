<?php

class links_pages{

    public $link_painel;
    public $link_produtos;
    public $link_categorias;
    public $link_fornecedores;
    public $link_financeiro;
    public $link_clientes;
    public $link_funcionarios;

    public function __construct()
    {
        $this->link_painel = '../HTML/painel.php';
        $this->link_produtos = '../HTML/produtos.php';
        $this->link_categorias = '../HTML/categoria.php';
        $this->link_fornecedores = '../HTML/fornecedores.php';
        $this->link_funcionarios = '../HTML/funcionarios.php';
    }

}
?>
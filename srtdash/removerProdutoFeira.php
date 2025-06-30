<?php

    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\ProdutoFeira;
    use App\Entity\Produto;


    if (isset($_POST['idFeira'], $_POST['idProduto'], $_POST['preco'], $_POST['quantidade'])) {

        $produto = Produto::getProduto($_POST['idProduto']);
        if(!$produto){
            die('Produto não encontrado');
        }

        if($_POST['quantidade'] > $produto->estoque){
            die('Estoque insuficiente.');
        }

        $produto->estoque -= $_POST['quantidade'];
        $produto->atualizar();

        $obFeiraProduto = new ProdutoFeira();
        $obFeiraProduto->idFeira =  $_POST['idFeira'];
        $obFeiraProduto->idProduto =  $_POST['idProduto'];
        $obFeiraProduto->preco = $_POST['preco'];
        $obFeiraProduto->quantidade = $_POST['quantidade'];
        $obFeiraProduto->cadastrar();

        header("Location:listarFeira.php?status=success");
        exit;
    }
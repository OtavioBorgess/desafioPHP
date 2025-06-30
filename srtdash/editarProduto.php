<?php

    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\Produto;

    if (!isset($_POST['id']) or !is_numeric($_POST['id'])) {
        header('location: viewEditarProduto.php?status=error');
        exit;
    }

    $obProd = Produto::getProduto($_POST['id']);

    if(!$obProd instanceof Produto){
        header('location: viewEditarProduto.php?status=error');
        exit;
    }

    if (isset($_POST['descricao'], $_POST['preco'], $_POST['unidade'], $_POST['estoque'])) {
        session_start();
        $obProd->idUsuario = $_SESSION['idUsuario'];
        $obProd->descricao = $_POST['descricao'];
        $obProd->preco = $_POST['preco'];
        $obProd->unidade = $_POST['unidade'];
        $obProd->estoque = $_POST['estoque'];
        $obProd->atualizar();
        header("location: listagemProdutoProdutor.php");
        exit;
    }



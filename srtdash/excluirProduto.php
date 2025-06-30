<?php

    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\Produto;

    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        header('Location: viewExcluirProduto.php?status=error');
        exit;
    }

    $obProd = Produto::getProduto($_POST['id']);

    if (!$obProd instanceof Produto) {
        header('Location: viewExcluirProduto.php?status=error');
        exit;
    }

    if (isset($_POST['excluir'])) {
        $obProd->excluir();
        header("Location: listagemProdutoProdutor.php?status=success");
        exit;
    }
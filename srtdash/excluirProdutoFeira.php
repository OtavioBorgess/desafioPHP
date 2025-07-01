<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Entity\ProdutoFeira;
use App\Entity\Produto;

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    header('Location: viewExcluirProduto.php?status=error');
    exit;
}

    $obProd = ProdutoFeira::getProdutoFeiraPorId($_POST['id']);

if (!$obProd instanceof ProdutoFeira) {
    header('Location: viewExcluirProduto.php?status=error');
    exit;
}

if (isset($_POST['excluir'])) {
    $prod = Produto::getProduto($obProd->idProduto);
    if ($prod instanceof Produto){
        $prod->estoque += $obProd->quantidade;
        $prod->atualizar();
    }
    $obProd->excluir();
    header("Location: listarProdutoFeira.php?status=success&idFeira={$obProd->idFeira}");
    exit;
}
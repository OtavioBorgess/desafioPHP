<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Entity\ProdutoFeira;
use App\Entity\Produto;

if (!isset($_POST['id']) or !is_numeric($_POST['id'])) {
    header('location: viewEditarProdutoFeira.php?status=error');
    exit;
}

$obProd = ProdutoFeira::getProdutoFeiraPorId($_POST['id']);

if (!$obProd instanceof ProdutoFeira) {
    header('location: viewEditarProdutoFeira.php?status=error');
    exit;
}

if (isset($_POST['idFeira'], $_POST['idProduto'], $_POST['preco'], $_POST['quantidade'])) {
    $obProd->idFeira = $_POST['idFeira'];
    $obProd->idProduto = $_POST['idProduto'];
    $obProd->preco = $_POST['preco'];

    if ($_POST['quantidade'] != $obProd->quantidade) {
        $novaQuantidade = $_POST['quantidade'];
        $quantidadeAntiga = $obProd->quantidade;
        $diferenca = $novaQuantidade - $quantidadeAntiga;

        $obProd->quantidade = $novaQuantidade;

        $produto = Produto::getProduto($obProd->idProduto);
        if ($produto instanceof Produto) {
            if($diferenca > $produto->estoque){
                die('quantidade insuficiente');
            }
            $produto->estoque -= $diferenca;
            $produto->atualizar();
        }
    }
    $obProd->atualizar();
}
header('location: listarProdutoFeira.php?status=success&idFeira=' . $obProd->idFeira);
exit;
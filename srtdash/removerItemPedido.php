<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Entity\ItemPedido;
use App\Entity\Pedido;
use App\Entity\ProdutoFeira;

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    header('Location: listagemProdutoFeiraConsumidor.php?status=error');
    exit;
}

$item = ItemPedido::getPedido($_POST['id']);

if (!$item instanceof ItemPedido) {
    header('Location: viewRemoverItemPedido.php?status=error');
    exit;
}

if (isset($_POST['excluir'])) {
    $prodFeira = ProdutoFeira::getProdutoFeiraPorId($item->idProdutoFeira);
    if($prodFeira instanceof ProdutoFeira){
        $prodFeira->quantidade += $item->quantidade;
        $prodFeira->atualizar();
    }

    $pedido = Pedido::getPedido($item->idPedido);
    if($pedido instanceof Pedido){
        $pedido->valorTotal -= $item->subTotal;
        $pedido->atualizar();
    }

    $item->excluir();
    header("Location: viewVisualizarPedidos.php?status=success");
    exit;
}
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use App\Entity\ItemPedido;
use App\Entity\Pedido;
use App\Entity\ProdutoFeira;

if (!isset($_POST['id'])) {
    header('Location: listagemProdutoFeiraConsumidor.php?status=error');
    exit;
}

$item = ItemPedido::getItem($_POST['id']);

if (!$item instanceof ItemPedido) {
    header('Location: viewRemoverItemPedido.php?status=error');
    exit;
}

if (isset($_POST['quantidade'])) {
    $novaQuantidade = $_POST['quantidade'];

    if ($novaQuantidade != $item->quantidade) {
        $quantidadeAntiga = $item->quantidade;
        $diferenca = $novaQuantidade - $quantidadeAntiga;

        $item->quantidade = $novaQuantidade;

        $prodFeira = ProdutoFeira::getProdutoFeiraPorId($item->idProdutoFeira);
        if ($prodFeira instanceof ProdutoFeira) {
            if ($diferenca > $prodFeira->quantidade) {
                header('Location: viewVisualizarPedidos.php?status=estoque_insuficiente');
                exit;
            }
            $prodFeira->quantidade -= $diferenca;
            $prodFeira->atualizar();
        }
        $subTotalAntigo = $item->subTotal;
        $item->subTotal = $item->precoUnit * $novaQuantidade;
        $difSubTotal = $subTotalAntigo - $item->subTotal;
        $pedido = Pedido::getPedido($item->idPedido);
        if ($pedido instanceof Pedido) {
            $pedido->valorTotal -= $difSubTotal;
            $pedido->atualizar();
        }
        $item->atualizar();

    }
}

header('Location: viewVisualizarPedidos.php?status=success');
exit;

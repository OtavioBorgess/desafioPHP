<?php

require __DIR__ . '/../vendor/autoload.php';

header('Content-Type: application/json');

use App\Entity\ItemPedido;
use App\Entity\Pedido;
use App\Entity\ProdutoFeira;

if (!isset($_POST['editItem_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'ID inválido'
    ]);
    exit;
}

$item = ItemPedido::getItem($_POST['editItem_id']);

if (!$item instanceof ItemPedido) {
    echo json_encode([
        'status' => 'error',
        'message' => 'itemPedido não encontado.'
    ]);
    exit;
}

if (isset($_POST['editItem_itemQuantidade'])) {
    $novaQuantidade = $_POST['editItem_itemQuantidade'];

    if ($novaQuantidade != $item->quantidade) {
        $quantidadeAntiga = $item->quantidade;
        $diferenca = $novaQuantidade - $quantidadeAntiga;

        $item->quantidade = $novaQuantidade;

        $prodFeira = ProdutoFeira::getProdutoFeiraPorId($item->idProdutoFeira);
        if ($prodFeira instanceof ProdutoFeira) {
            if ($diferenca > $prodFeira->quantidade) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Estoque insuficiente.'
                ]);
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

    echo json_encode([
        'status' => 'success',
        'message' => 'itemPedido atualizado com sucesso.'
    ]);
    exit;

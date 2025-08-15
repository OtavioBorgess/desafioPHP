<?php

    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\ItemPedido;
    use App\Entity\Pedido;
    use App\Entity\ProdutoFeira;

    if (!isset($_POST['item_id']) || !is_numeric($_POST['item_id'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID inválido'
        ]);
        exit;
    }

    $item = ItemPedido::getPedido($_POST['item_id']);

    if (!$item instanceof ItemPedido) {
        echo json_encode([
            'status' => 'error',
            'message' => 'item inexistente'
        ]);
        exit;
    }

    $prodFeira = ProdutoFeira::getProdutoFeiraPorId($item->idProdutoFeira);
    if ($prodFeira instanceof ProdutoFeira) {
        $prodFeira->quantidade += $item->quantidade;
        $prodFeira->atualizar();
    }

    $pedido = Pedido::getPedido($item->idPedido);
    if ($pedido instanceof Pedido) {
        $pedido->valorTotal -= $item->subTotal;
        $pedido->atualizar();
    }

    if ($item->excluir()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Item removido com sucesso!'
        ]);
        exit;
    }
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro ao remover item!'
    ]);
    exit;
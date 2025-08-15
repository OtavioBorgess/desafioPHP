<?php

    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\ItemPedido;
    use App\Entity\ProdutoFeira;

    if (!isset($_POST['idItem']) or !is_numeric($_POST['idItem'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID inválido'
        ]);
        exit;
    }

    $item = ItemPedido::getItem($_POST['idItem']);
    $prod = ProdutoFeira::getProdutoFeiraPorId($item->idProdutoFeira);

    if($item){
        echo json_encode([
            'status' => 'success',
            'message' => 'Produto encontrado',
            'id' => $item->id,
            'descricao' => $prod->descricao,
            'unidade' => $prod->unidade,
            'prodQuantidade' => $prod->quantidade,
            'itemQuantidade' => $item->quantidade,
            'preco' => $prod->preco,
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erro ao encontrar o produto'
        ]);
    }
    exit;
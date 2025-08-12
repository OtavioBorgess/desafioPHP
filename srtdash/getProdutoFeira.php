<?php

    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\ProdutoFeira;

    if (!isset($_POST['productFeira_id']) or !is_numeric($_POST['productFeira_id'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID inválido'
        ]);
        exit;
    }

    $obProdFeira = ProdutoFeira::getProdutoFeiraPorId($_POST['productFeira_id']);

    if($obProdFeira){
        echo json_encode([
            'status' => 'success',
            'message' => 'Produto encontrado',
            'id' => $obProdFeira->id,
            'idFeira' => $obProdFeira->idFeira,
            'descricao' => $obProdFeira->descricao,
            'preco' => $obProdFeira->preco,
            'unidade' => $obProdFeira->unidade,
            'quantidade' => $obProdFeira->quantidade,
            'estoque' => $obProdFeira->estoque,

        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erro ao encontrar o produto'
        ]);
    }
    exit;
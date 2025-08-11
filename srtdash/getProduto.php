<?php

    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\Produto;

    if (!isset($_POST['idProduto']) or !is_numeric($_POST['idProduto'])) {
      echo json_encode([
          'status' => 'error',
          'message' => 'ID inválido'
      ]);
      exit;
    }

    $obProd = Produto::getProduto($_POST['idProduto']);

    if($obProd){
        echo json_encode([
            'status' => 'success',
            'message' => 'Produto encontrado',
            'id' => $obProd->id,
            'descricao' => $obProd->descricao,
            'preco' => $obProd->preco,
            'unidade' => $obProd->unidade,
            'estoque' => $obProd->estoque,

        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erro ao encontrar o produto'
        ]);
    }
    exit;
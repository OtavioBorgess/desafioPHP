<?php

    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\Produto;

    $id = $_POST['p_id'];

    if (!isset($id) || !is_numeric($id)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID inválido'
        ]);
        exit;
    }

    $obProd = Produto::getProduto($id);

    if (!$obProd instanceof Produto) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Produto não encontrado.'
        ]);
        exit;
    }

    if ($obProd->excluir()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Produto excluído com sucesso.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erro ao excluir produto.'
        ]);
    }
    exit;


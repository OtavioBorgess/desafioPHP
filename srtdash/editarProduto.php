<?php

    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\Produto;

    session_start();
    $id = $_SESSION['idUsuario'];

    if (!isset($_POST['idProduct']) or !is_numeric($_POST['idProduct'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID inválido'
        ]);
        exit;
    }

    $obProd = Produto::getProduto($_POST['idProduct']);

    if (!$obProd instanceof Produto) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Produto não encontrado'
        ]);
        exit;
    }

    if (isset($_POST['update_product'])) {
        $obProd->idUsuario = $id;
        $obProd->descricao = $_POST['descricao'];
        $obProd->preco = $_POST['preco'];
        $obProd->unidade = $_POST['unidade'];
        $obProd->estoque = $_POST['estoque'];
        $obProd->atualizar();
        echo json_encode([
            'status' => 'success',
            'message' => 'Produto atualizado com sucesso!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error ao atualizar produto!'
        ]);
    }
    exit;



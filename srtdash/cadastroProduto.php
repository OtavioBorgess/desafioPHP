<?php

    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\Produto;

    session_start();
    $id = $_SESSION['idUsuario'];

    if (isset($_POST['save_product'])) {
        $obProduto = new Produto;
        $obProduto->idUsuario = $id;
        $obProduto->descricao = $_POST['descricao'];
        $obProduto->preco = $_POST['preco'];
        $obProduto->unidade = $_POST['unidade'];
        $obProduto->estoque = $_POST['estoque'];
        $obProduto->cadastrar();

       echo json_encode([
           'status' => 'success',
           'message' => 'Produto cadastrado com sucesso'
       ]);
       exit;
    }

    echo json_encode([
        'status' => 'error',
        'message' => 'Erro ao cadastrar Produto'
    ]);
    exit;

<?php

    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\Produto;

    session_start();

    if (isset($_POST['descricao'], $_POST['preco'], $_POST['unidade'], $_POST['estoque'])) {

        $obProduto = new Produto;
        $obProduto->idUsuario = $_SESSION['idUsuario'];
        $obProduto->descricao = $_POST['descricao'];
        $obProduto->preco = $_POST['preco'];
        $obProduto->unidade = $_POST['unidade'];
        $obProduto->estoque = $_POST['estoque'];
        $obProduto->cadastrar();

        header("Location:viewListarProduto.php?status=success");
        exit;
    }
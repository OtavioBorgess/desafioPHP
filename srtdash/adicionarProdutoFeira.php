<?php

    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\ProdutoFeira;
    use App\Entity\Produto;

    $produtoExistente = ProdutoFeira::getProduto($_POST['idFeira'], $_POST['idProduto']);
    if ($produtoExistente) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Produto já cadastrado.'
        ]);
        exit;
    }
    $produto = Produto::getProduto($_POST['idProduto']);
    if (!$produto) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Produto não encontrado'
        ]);
        exit;
    }

    if (isset($_POST['save_produt'])) {
        $produto->estoque -= $_POST['quantidade'];
        $produto->atualizar();

        $obFeiraProduto = new ProdutoFeira();
        $obFeiraProduto->idFeira = $_POST['idFeira'];
        $obFeiraProduto->idProduto = $_POST['idProduto'];
        $obFeiraProduto->preco = $_POST['preco'];
        $obFeiraProduto->quantidade = $_POST['quantidade'];
        $obFeiraProduto->cadastrar();

        echo json_encode([
            'status' => 'success',
            'message' => 'Produto adicionado com sucesso.'
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erro ao adicionar produto.'
        ]);
        exit;
    }
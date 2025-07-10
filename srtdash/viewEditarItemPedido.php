<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Excluir Produto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Entity\ItemPedido;
use App\Entity\ProdutoFeira;

if (!isset($_GET['id'])) {
    header('Location: listarProdutoFeira.php?status=error');
    exit;
}

$item = ItemPedido::getItem($_GET['id']);

if (!$item instanceof ItemPedido) {
    header('Location: listarProdutoFeira.php?status=error');
    exit;
}

$produto = ProdutoFeira::getProdutoFeiraPorId($item->idProdutoFeira);

if (!$produto) {
    echo "Produto não encontrado.";
    exit;
}
?>

<body>
<div class="page-container login-area">
    <aside class="sidebar-menu bg-dark text-light">
        <div class="sidebar-header p-3">
            <a href="painel.php" class="text-light text-decoration-none">
                <h2>AgriFood</h2>
                <small>Consumidor</small>
            </a>
        </div>
        <nav class="main-menu p-3">
            <ul class="metismenu" id="menu">
                <li>
                    <a href="#" aria-expanded="true" class="text-light d-block py-2">Perfil</a>
                    <ul class="collapse list-unstyled ps-3">
                        <li><a href="viewEditarPerfil.php" class="text-light">Editar</a></li>
                        <li><a href="viewAlterarSenha.php" class="text-light">Alterar senha</a></li>
                    </ul>
                </li>
                <li><a href="viewListagemFeira.php" class="text-light d-block py-2">Feiras</a></li>
                <li><a href="viewVisualizarPedidos.php" class="text-light d-block py-2">Pedidos</a></li>
                <li><a href="#" class="text-light d-block py-2">Relatórios</a></li>
                <li><a href="logout.php" class="text-light d-block py-2">Sair</a></li>
            </ul>
        </nav>
    </aside>

    <div class="container pt-5">
        <h3><?= $produto->descricao ?></h3>
        <p>Preço: R$ <?= number_format($produto->preco, 2, ',', '.') ?></p>
        <p>Disponível: <?=$produto->quantidade?></p>

        <form action="editarItemPedido.php" method="post">
            <input type="hidden" name="id" value="<?= $item->id ?>">
            <input type="hidden" name="idFeira" value="<?= $item->idFeira ?>">

            <div class="form-group">
                <label for="quantidade">Quantidade (em <?= $produto->unidade?>):</label>
                <input type="number" name="quantidade" id="quantidade" class="form-control" required min="1"
                       max="<?=$qtdeMaxima = $item->quantidade + $produto->quantidade?>" value="<?= $item->quantidade ?>">
            </div>

            <button type="submit" class="btn btn-primary">Editar Item</button>
            <a href="viewVisualizarPedidos.php" class="btn btn-secondary">Voltar</a>
        </form>
    </div>

    <!-- Scripts -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>

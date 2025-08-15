<!doctype html>
<html class="no-js" lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Item</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
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
    session_start();
    if (!isset($_SESSION['idUsuario'])) {
        header('Location: index.php');
        exit;
    }
    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\ProdutoFeira;

    $prodFeira = $_GET['idProdutoFeira'] ?? null;

    $produto = ProdutoFeira::getProdutoFeiraPorId($prodFeira);

    if (!$produto) {
        echo "Produto não encontrado.";
        exit;
    }
?>

<body>
<div class="page-container login-area">
    <aside class="sidebar-menu bg-dark text-light">
        <div class="sidebar-header bg-dark">
            <a href="painel.php" class="text-light text-decoration-none">
                <h2>AgriFood</h2>
                <small>Consumidor</small>
            </a>
        </div>
        <nav class="main-menu">
            <ul class="metismenu" id="menu">
                <li>
                    <a href="#perfilMenu" class="text-light d-block py-2" data-bs-toggle="collapse"
                       aria-expanded="false">
                        Perfil <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul class="collapse list-unstyled ps-4" id="perfilMenu">
                        <li><a href="viewEditarPerfil.php" class="text-light py-1 d-block">Editar</a></li>
                        <li><a href="viewAlterarSenha.php" class="text-light py-1 d-block">Alterar senha</a></li>
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
        <div class="card shadow-sm rounded">
            <div class="card-body">
                <h3 class="card-title mb-3"><?= $produto->descricao ?></h3>
                <p class="mb-1"><strong>Preço:</strong> R$ <?= number_format($produto->preco, 2, ',', '.') ?></p>
                <p class="mb-3"><strong>Disponível:</strong> <?= $produto->quantidade ?> <?= $produto->unidade ?></p>

                <form action="adicionarPedido.php" method="post">
                    <input type="hidden" name="idProdutoFeira" value="<?= $produto->id ?>">
                    <input type="hidden" name="idFeira" value="<?= $_GET['idFeira'] ?>">
                    <input type="hidden" name="preco" value="<?= $produto->preco ?>">

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="quantidade" name="quantidade" placeholder="Quantidade" min="1" max="<?= $produto->quantidade ?>" required>
                        <label for="quantidade">Quantidade (<?= $produto->unidade ?>)</label>
                    </div>

                    <div class=mt-4">
                        <a href="viewListagemFeira.php?idFeira=<?= $_GET['idFeira'] ?>" class="btn btn-secondary btn-lg">Voltar</a>
                        <button type="submit" class="btn btn-primary btn-lg">Adicionar à Cesta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/metisMenu.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery.slicknav.min.js"></script>

<script src="assets/js/plugins.js"></script>
<script src="assets/js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/crud.js"></script>

</html>
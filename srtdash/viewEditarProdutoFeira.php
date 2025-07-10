<!doctype html>
<html class="no-js" lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Adicionar Produto à Feira</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
<?php
    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\ProdutoFeira;


    if (!isset($_GET['id'])) {
        header('Location: listarProdutoFeira.php?status=error');
        exit;
    }

    $prod = ProdutoFeira::getProdutoFeiraPorId($_GET['id']);

    if (!$prod instanceof ProdutoFeira) {
        header('Location: listarProdutoFeira.php?status=error');
        exit;
    }
?>

<div class="page-container login-area">
    <aside class="sidebar-menu bg-dark text-light">
        <div class="sidebar-header p-3">
            <a href="painel.php" class="text-light text-decoration-none">
                <h2>AgriFood</h2>
                <small>Produtor</small>
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
                <li><a href="viewListagemFeiraviewListagemFeira.php" class="text-light d-block py-2">Feiras</a></li>
                <li>
                    <a href="#" aria-expanded="true" class="text-light d-block py-2">Produtos</a>
                    <ul class="collapse list-unstyled ps-3">
                        <li><a href="viewCadastroProduto.php" class="text-light">Cadastrar</a></li>
                        <li><a href="viewListarProduto.php" class="text-light">Listar</a></li>
                    </ul>
                </li>
                <li><a href="#" class="text-light d-block py-2">Relatórios</a></li>
                <li><a href="logout.php" class="text-light d-block py-2">Sair</a></li>
            </ul>
        </nav>
    </aside>

<div class="main-content login-area">
    <div class="container py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8">
                <div class="card shadow-lg rounded">
                    <div class="card-header bg-dark text-white text-center">
                        <h4 class="mb-0">Editar Produto na Feira</h4>
                    </div>
                    <div class="card-body px-4 py-4">
                        <form method="post" action="editarProdutoFeira.php">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($prod->id) ?>">
                            <input type="hidden" name="idFeira" value="<?= htmlspecialchars($prod->idFeira) ?>">
                            <input type="hidden" name="idProduto" value="<?= htmlspecialchars($prod->idProduto) ?>">

                            <div class="form-group mb-4">
                                <label for="produto" class="font-weight-bold">Produto</label>
                                <input type="text" class="form-control" id="produto" readonly
                                       value="<?= htmlspecialchars($prod->descricao) ?>">
                            </div>

                            <div class="form-row mb-4">
                                <div class="col-md-4">
                                    <label for="preco" class="font-weight-bold">Preço</label>
                                    <input type="number" class="form-control" name="preco" id="preco" min="0.01"
                                           step="0.01"
                                           required
                                           value="<?= htmlspecialchars($prod->preco) ?>" placeholder="Ex: 9.99">
                                </div>
                                <div class="col-md-4">
                                    <label for="unidade" class="font-weight-bold">Unidade</label>
                                    <input type="text" class="form-control" name="unidade" id="unidade" readonly
                                           value="<?= htmlspecialchars($prod->unidade) ?>">
                                </div>

                                <div class="col-md-4">
                                    <label for="estoque" class="font-weight-bold">Estoque</label>
                                    <input type="number" class="form-control" name="estoque" id="estoque" readonly
                                           value="<?= htmlspecialchars($prod->estoque) ?>">
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="quantidade" class="font-weight-bold">Quantidade para a Feira</label>
                                <input type="number" class="form-control" name="quantidade" id="quantidade" required
                                       min="1"
                                       value="<?= htmlspecialchars($prod->quantidade) ?>"
                                       placeholder="Informe a quantidade">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-dark px-4">Editar</button>
                                <a href="listarProdutoFeira.php?idFeira=<?= $prod->idFeira ?>" class="btn btn-danger">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

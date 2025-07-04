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

    use App\Entity\Produto;

    $produtos = array_filter($produtos = Produto::getBuscaProduto(), fn($p) => $p->estoque > 0);

    $idProdutoSelecionado = $_GET['idProduto'] ?? '';
    $produtoSelecionado = $idProdutoSelecionado ? Produto::getProduto($idProdutoSelecionado) : null;
?>

<div class="main-content login-area">
    <div class="container py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white text-center">
                        <h4>Adicionar Produto à Feira</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="salvarProdutoFeira.php">
                            <input type="hidden" name="idFeira" value="<?= $_GET['id'] ?>">

                            <div class="form-group mb-4">
                                <label for="idProduto">Produto</label>
                                <select name="idProduto" id="idProduto" class="form-control" required
                                        onchange="location.href='?id=<?= $_GET['id'] ?>&idProduto=' + this.value;">
                                    <option value="">Selecione...</option>
                                    <?php foreach ($produtos as $produto): ?>
                                        <option value="<?= $produto->id ?>"
                                            <?= $produto->id == $idProdutoSelecionado ? 'selected' : '' ?>>
                                            <?= $produto->descricao ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-row mb-4">
                                <div class="col-md-4">
                                    <label for="preco">Preço</label>
                                    <input type="text" class="form-control" name="preco" id="preco" min="1" required
                                           value="<?= $produtoSelecionado->preco ?? '' ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="unidade">Unidade</label>
                                    <input type="text" class="form-control" name="unidade" id="unidade" readonly
                                           value="<?= $produtoSelecionado->unidade ?? '' ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="estoque">Estoque</label>
                                    <input type="number" class="form-control" name="estoque" id="estoque" readonly
                                           value="<?= $produtoSelecionado->estoque ?? '' ?>">
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="quantidade">Quantidade para a Feira</label>
                                <input type="number" class="form-control" name="quantidade" id="quantidade" required
                                       min="1">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Salvar Produto</button>
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

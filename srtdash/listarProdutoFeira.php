<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Table Basic - srtdash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all"/>
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<?php
    include __DIR__ . '/../app/Entity/ProdutoFeira.php';
    include __DIR__ . '/../app/Entity/Feira.php';
    include __DIR__ . '/../app/Db/Database.php';

    use App\Entity\ProdutoFeira;
    use App\Entity\Feira;

    $filtro = $_GET['filtro'] ?? 'todos';

    $produtosFeira = ProdutoFeira::getProdutosDaFeira($_GET['idFeira']);

    $resultados = '';
    foreach ($produtosFeira as $prodFeira) {
        $resultados .= '<tr>
            <td>' . $prodFeira->descricao . '</td>
            <td>' . number_format($prodFeira->preco, 2, ',', '.') . '</td>
            <td>' . $prodFeira->unidade . '</td>
            <td>' . $prodFeira->quantidade . '</td>
            <td>
                <a href="viewEditarProdutoFeira.php?id='.$prodFeira->id.'" class="btn btn-info">Editar</a>
                <a href="viewExcluirProdutoFeira.php?id=' . $prodFeira->id . '" class="btn btn-danger">Excluir</a>
            </td>
        </tr>';
    }

    $feiras = Feira::getFeiras();
    $idFeiraSelecionada = $_GET['idFeira'] ?? '';

    $resultados = $resultados ?: '<tr><td colspan="5">Nenhum produto encontrado nesta feira</td></tr>';
?>

<body>

<div class="page-container login-area">
    <!-- sidebar menu area start -->
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <div class="logo">
                <a href="painelProdutor.php"><h2 class="text-light">AgriFood</h2></a>
                <p class="text-light">Produtor</p>
            </div>
        </div>
        <div class="main-menu">
            <div class="menu-inner">
                <nav>
                    <ul class="metismenu" id="menu">
                        <li>
                            <a href="#" aria-expanded="true"><span>Perfil</span></a>
                            <ul class="collapse">
                                <li><a href="viewEditarPerfil.php">Editar</a></li>
                                <li><a href="#">Alterar senha</a></li>
                            </ul>
                        </li>
                        <li><a href="listarFeira.php"><span>Listar Feiras</span></a></li>
                        <li>
                            <a href="#" aria-expanded="true"><span>Produtos</span></a>
                            <ul class="collapse">
                                <li><a href="viewCadastroProduto.php">Cadastrar</a></li>
                                <li><a href="listagemProdutoProdutor.php">Listar</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><span>Relatórios</span></a></li>
                        <li><a href="logout.php"><span>Sair</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="main-content-inner text-center">
        <div class="d-flex justify-content-center">
            <div class="card w-100" style="max-width: 1000px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="header-title mb-0">Seus Produtos</h4>
                        <form method="get" class="form-inline mb-3 justify-content-center">
                            <label for="idFeira" class="mr-2 font-weight-bold">Filtro: </label>
                            <select name="idFeira" id="idFeira" onchange="this.form.submit()" class="form-control"
                                    style="max-width: 300px; padding: 0 15px;">
                                <?php foreach ($feiras as $feira): ?>
                                    <option value="<?= $feira->id ?>" <?= $feira->id == $idFeiraSelecionada ? 'selected' : '' ?>>
                                        <?=$feira->titulo?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </div>

                    <div class="single-table">
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead class="text-uppercase bg-secondary">
                                <tr class="text-white">
                                    <th scope="col">Nome</th>
                                    <th scope="col">Preço</th>
                                    <th scope="col">Unidade</th>
                                    <th scope="col">Estoque</th>
                                    <th scope="col">Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?= $resultados ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</body>

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
</html>

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
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<?php

    include __DIR__ . '/../app/Entity/Produto.php';
    include __DIR__ . '/../app/Db/Database.php';

    use App\Entity\Produto;

    $produtos = Produto::getProdutoDisponivel();

    $resultados = '';
    foreach ($produtos as $produto) {
        $resultados .= '<tr>
        <td>' . $produto->idUsuario . '</td>
        <td>' . $produto->descricao . '</td>
        <td>' . number_format($produto->preco, 2, ',', ' ') . '</td>
        <td>' . $produto->unidade . '</td>
        <td>' . $produto->estoque  . '</td> 
        <td>
            <div class="botao-container">
                <!--<a href="viewEditarProduto.php?id=' . $produto->id . '" class="btn-acao btn-editar">Editar</a>
                <a href="viewExcluirProduto.php?id=' . $produto->id . '" class="btn-acao btn-excluir">Excluir</a>-->
            </div>
        </td>
    </tr>';
    }

    $resultados = strlen($resultados) ? $resultados : '<tr><td colspan="7">Nenhum registro encontrado</td></tr>';

?>

<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please
    <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="page-container">
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <div class="logo">
                <a href="index.php"><h2 class="text-light">AgriFood</h2></a>
                <p class="text-light">Consumidor</p>
            </div>
        </div>
        <div class="main-menu">
            <div class="menu-inner">
                <nav>
                    <ul class="metismenu" id="menu">
                        <li><a href="#" aria-expanded="true"><span>Perfil</span></a></li>
                        <li><a href="listagemProdutoConsumidor.php" aria-expanded="true"><span>Listar Produtos</span></a></li>
                        <li><a href="#" aria-expanded="true"><span>Seus Pedidos</span></a></li>
                        <li><a href="#" aria-expanded="true"><span>Relatórios</span></a></li>
                        <li><a href="#" aria-expanded="true"><span>Sair</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Conteúdo principal centralizado -->
    <div class="main-content-inner text-center mt-5">
        <div class="d-flex justify-content-center">
            <div class="card w-100" style="max-width: 1000px;">
                <div class="card-body">
                    <h4 class="header-title">Listagem de Produtos</h4>
                    <div class="single-table">
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead class="text-uppercase bg-secondary">
                                <tr class="text-white">
                                    <th scope="col">ID Produtor</th>
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

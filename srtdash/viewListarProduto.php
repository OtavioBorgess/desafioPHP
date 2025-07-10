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

include __DIR__ . '/../app/Entity/Produto.php';
include __DIR__ . '/../app/Db/Database.php';

use App\Entity\Produto;

$filtro = $_GET['filtro'] ?? 'disponiveis';

switch ($filtro) {
    case 'todos':
        $produtos = array_filter(Produto::getBuscaProduto());
        break;
    case 'indisponiveis':
        $produtos = array_filter(Produto::getBuscaProduto(), fn($p) => $p->estoque <= 0);
        break;
    default:
        $produtos = array_filter(Produto::getBuscaProduto(), fn($p) => $p->estoque > 0);
}

$resultados = '';
foreach ($produtos as $produto) {
    $resultados .= '<tr>
            <td>' . $produto->descricao . '</td>
            <td>' . number_format($produto->preco, 2, ',', ' ') . '</td>
            <td>' . $produto->unidade . '</td>
            <td>' . $produto->estoque . '</td> 
            <td>
                <div>
                    <a href="viewEditarProduto.php?id=' . $produto->id . '" class="btn btn-info">Editar</a>
                    <a href="viewExcluirProduto.php?id=' . $produto->id . '" class="btn btn-danger">Excluir</a>
                </div>
            </td>
        </tr>';
}

$resultados = strlen($resultados) ? $resultados : '<tr><td colspan="7">Nenhum registro encontrado</td></tr>';

?>

<body>

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
                <li><a href="viewListagemFeira.php" class="text-light d-block py-2">Feiras</a></li>
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

    <div class="main-content-inner text-center">
        <div class="d-flex justify-content-center">
            <div class="card w-100" style="max-width: 1000px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="header-title mb-0">Seus Produtos</h4>
                        <form method="get" class="form-inline">
                            <label for="filtro" class="mr-2 font-weight-bold">Filter:</label>
                            <select name="filtro" id="filtro" onchange="this.form.submit()" class="form-control"
                                    style="padding: 0 15px">
                                <option value="todos" <?= $filtro === 'todos' ? 'selected' : '' ?>>Todos</option>
                                <option value="disponiveis" <?= $filtro === 'disponiveis' ? 'selected' : '' ?>>
                                    Disponíveis
                                </option>
                                <option value="indisponiveis" <?= $filtro === 'indisponiveis' ? 'selected' : '' ?>>
                                    Indisponíveis
                                </option>
                            </select>
                        </form>
                    </div>

                    <div class="single-table">
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead class="text-uppercase bg-dark">
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

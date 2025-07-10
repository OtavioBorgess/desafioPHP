<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login - srtdash</title>
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

include __DIR__ . '/../app/Entity/Feira.php';
include __DIR__ . '/../app/Entity/Pedido.php';
include __DIR__ . '/../app/Entity/Usuario.php';
require_once __DIR__ . '/../app/Db/Database.php';

session_start();

use App\Entity\Feira;
use App\Entity\Pedido;
use App\Entity\Usuario;

$user = Usuario::getUsuario($_SESSION['idUsuario']);

$filtro = $_GET['filtro'] ?? 'ativa';
$dataAtual = date('Y-m-d');

switch ($filtro) {
    case 'todas':
        $feiras = array_filter(Feira::getFeiras());
        break;
    case 'inativa':
        $feiras = array_filter(Feira::getFeiras(), fn($p) => $p->dataRealizacao < $dataAtual);
        break;
    default:
        $feiras = array_filter(Feira::getFeiras(), fn($p) => $p->dataRealizacao >= $dataAtual);
}

$resultados = '';
foreach ($feiras as $feira) {
    $resultados .= '<tr>
        <td>' . htmlspecialchars($feira->titulo) . '</td>
        <td>' . date('d/m/Y', strtotime($feira->dataRealizacao)) . '</td>
        <td>' . date('d/m/Y', strtotime($feira->dataPrazo)) . '</td>
        <td>' . htmlspecialchars($feira->descricao) . '</td>
        <td>' . htmlspecialchars($feira->local) . '</td>
        <td>';

    $pedido = Pedido::getPedidoExistente($_SESSION['idUsuario'], $feira->id);
    if ($user->perfil === 'consumidor') {
        if ($pedido) {
            $resultados .= '<a href="viewVisualizarPedidos.php?idFeira=' . $feira->id . '" class="btn btn-info" title="Ver Pedido">Ver Pedido</a>';
        } else {
            $resultados .= '<a href="listarProdutoFeiraConsumidor.php?idFeira=' . $feira->id . '" class="btn btn-success" title="Ver produtos da feira">Ver Produtos</a>';
        }
    } else {
        if (strtotime($feira->dataPrazo) >= strtotime($dataAtual)) {
            $resultados .= '<a href="viewAdicionarProduto.php?id=' . $feira->id . '" class="btn btn-info mr-1" title="Adicionar produto à feira">Adicionar Produto</a>';
            $resultados .= '<a href="listarProdutoFeira.php?idFeira=' . $feira->id . '" class="btn btn-success" title="Ver produtos da feira">Ver Produtos</a>';
        } else {
            $resultados .= '<span class="badge bg-danger font-14">Prazo encerrado</span>';
        }
    }
}

$resultados = $resultados ?: '<tr><td colspan="7">Nenhum registro encontrado</td></tr>';

?>

<body>
<?php if ($user->perfil === 'consumidor') : ?>
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
    <?php else: ?>
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
        <?php endif; ?>

        <div class="main-content-inner text-center">
            <div class="d-flex justify-content-center">
                <div class="card w-100" style="max-width: 1000px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="header-title mb-0">Feiras</h4>
                            <form method="get" class="form-inline">
                                <label for="filtro" class="mr-2 font-weight-bold">Filter:</label>
                                <select name="filtro" id="filtro" onchange="this.form.submit()" class="form-control"
                                        style="padding: 0 15px">
                                    <option value="todas" <?= $filtro === 'todas' ? 'selected' : '' ?>>Todas</option>
                                    <option value="ativa" <?= $filtro === 'ativa' ? 'selected' : '' ?>>
                                        Ativas
                                    </option>
                                    <option value="inativa" <?= $filtro === 'inativa' ? 'selected' : '' ?>>
                                        Inativas
                                    </option>
                                </select>
                            </form>
                        </div>
                        <div class="single-table">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead class="text-uppercase bg-secondary">
                                    <tr class="text-white">
                                        <th scope="col">Título</th>
                                        <th scope="col">Data Realização</th>
                                        <th scope="col">Data Prazo</th>
                                        <th scope="col">Descrição</th>
                                        <th scope="col">Local</th>
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

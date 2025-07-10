<!doctype html>
<html class="no-js" lang="pt-br">

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
include __DIR__ . '/../app/Entity/Pedido.php';
include __DIR__ . '/../app/Entity/ItemPedido.php';
include __DIR__ . '/../app/Db/Database.php';

use App\Entity\ProdutoFeira;
use App\Entity\Feira;
use App\Entity\Pedido;
use App\Entity\ItemPedido;

session_start();

$idUsuario = $_SESSION['idUsuario'] ?? null;
$feiras = Feira::getFeiras();

$idFeiraSelecionada = $_GET['idFeira'] ?? '';
$filtro = $_GET['filtro'] ?? 'todos';

$produtosFeira = [];

if ($idFeiraSelecionada && $idUsuario) {
    $todosProdutos = ProdutoFeira::getProdutosDaFeira($idFeiraSelecionada);

    $pedido = Pedido::getPedidoExistente($idUsuario, $idFeiraSelecionada);

    $idsAdicionados = [];
    if ($pedido) {
        $itens = ItemPedido::getItensPorPedido($pedido->id);
        $idsAdicionados = array_map(fn($item) => $item->idProdutoFeira, $itens);
    }

    $produtosFeira = array_filter($todosProdutos, function ($p) use ($idsAdicionados) {
        return $p->quantidade > 0 && !in_array($p->id, $idsAdicionados);
    });
}

$resultados = '';
$dataAtual = date('Y-m-d');


foreach ($produtosFeira as $prodFeira) {
    $feira = Feira::getFeira($idFeiraSelecionada);
    if (strtotime($feira->dataPrazo) >= strtotime($dataAtual)) {
        $botao = ' <a href="viewAdicionarItem.php?idProdutoFeira=' . $prodFeira->id . '&idFeira=' . $idFeiraSelecionada . '" class="btn btn-success">Adicionar</a>';
    } else {
        $botao = '';
    }

    $resultados .= '<tr>
        <td>' . htmlspecialchars($prodFeira->descricao) . '</td>
        <td>R$ ' . number_format($prodFeira->preco, 2, ',', '.') . '</td>
        <td>' . htmlspecialchars($prodFeira->unidade) . '</td>
        <td>' . $prodFeira->quantidade . '</td>
        <td>' . $botao . '</td>
    </tr>';
}
$resultados = $resultados ?: '<tr><td colspan="6">Nenhum registro encontrado</td></tr>';
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

    <div class="main-content-inner text-center">
        <div class="d-flex justify-content-center">
            <div class="card w-100" style="max-width: 1000px;">
                <div class="card-body">
                    <h2 class="mb-4">Produtos da Feira</h2>
                    <div class="d-flex justify-content-around align-items-center mb-3">
                        <form method="get" class="form-inline mb-3 justify-content-center">
                            <label for="idFeira" class="mr-2 font-weight-bold">Filtro: </label>
                            <select name="idFeira" id="idFeira" onchange="this.form.submit()" class="form-control"
                                    style="max-width: 300px; padding: 0 15px;">
                                <?php foreach ($feiras as $feira): ?>
                                    <option value="<?= $feira->id ?>" <?= $feira->id == $idFeiraSelecionada ? 'selected' : '' ?>>
                                        <?= $feira->titulo ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                        <?php if ($idFeiraSelecionada):
                            $dataAtual = date('Y-m-d');

                            $feira = Feira::getFeira($idFeiraSelecionada);
                            $status = (strtotime($feira->dataPrazo) <= strtotime($dataAtual)) ? 'Encerrada' : 'Aberta';
                            $badgeClass = $status === 'Aberta' ? 'success' : 'danger';
                            ?>
                            <div class="mb-4">
                                <h5 class="mb-0">Status:
                                    <span class="badge bg-<?= $badgeClass ?>"><?= $status ?></span>
                                </h5>
                            </div>
                        <?php endif; ?>
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

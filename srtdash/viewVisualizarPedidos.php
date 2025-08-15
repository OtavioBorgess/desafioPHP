<!doctype html>
<html class="no-js" lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
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
<body>
<?php
    session_start();
    if (!isset($_SESSION['idUsuario'])) {
        header('Location: index.php');
        exit;
    }
    require_once './../vendor/autoload.php';

    use App\Entity\Pedido;
    use App\Entity\ItemPedido;
    use App\Entity\ProdutoFeira;
    use App\Entity\Produto;
    use App\Entity\Feira;

    $idUsuario = $_SESSION['idUsuario'] ?? null;
    $idFeiraSelecionada = $_GET['idFeira'] ?? '';

    $feiras = Feira::getFeiras();

    if (!$idFeiraSelecionada && count($feiras) > 0) {
        $idFeiraSelecionada = $feiras[0]->id;
    }

    $pedidos = Pedido::getPedidosPorFeira($idUsuario, $idFeiraSelecionada);

    if ($pedidos && !is_array($pedidos)) {
        $pedidos = [$pedidos];
    }

    $itensPedidos = [];
    $totalPedido = 0;

    if ($pedidos) {
        foreach ($pedidos as $pedido) {
            $itens = ItemPedido::getItensPorPedido($pedido->id);
            foreach ($itens as $item) {
                $totalPedido += $item->quantidade * $item->precoUnit;
                $item->pedido = $pedido;
                $itensPedidos[] = $item;
            }
        }
    }

    if (isset($_POST['idPedido'])) {
        $pedido = Pedido::getPedido($_POST['idPedido']);

        if ($pedido && $pedido->status === 'Pendente') {
            if (isset($_POST['confirmar'])) {
                $pedido->status = 'Confirmado';
                $pedido->atualizar();
                header("Location: viewVisualizarPedidos.php?idFeira=" . $idFeiraSelecionada . "&status=confirmado");
                exit;
            }

            if (isset($_POST['cancelar'])) {
                $itensPedidoCancel = ItemPedido::getItensPorPedido($pedido->id);
                foreach ($itensPedidoCancel as $item) {
                    $produtoFeira = ProdutoFeira::getProdutoFeiraPorId($item->idProdutoFeira);
                    if ($produtoFeira) {
                        $produtoFeira->quantidade += $item->quantidade;
                        $produtoFeira->atualizar();
                    }
                }
                $pedido->status = 'Cancelado';
                $pedido->atualizar();

                header("Location: viewVisualizarPedidos.php?idFeira=" . $idFeiraSelecionada . "&status=cancelado");
                exit;
            }
        }
    }
?>

<!--MODAL EDIT ITEM-->
<div class="modal fade" id="modalEditItem" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalLabel">Editar Item</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <form id="updateItem">
                <input type="hidden" id="editItem_id" name="editItem_id">

                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="editItem_descricao" name="editItem_descricao" placeholder="Descrição" disabled>
                        <label for="editItem_descricao">Descrição</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" step="0.01" class="form-control" id="editItemPreco" name="editItemPreco" placeholder="Preço" disabled>
                        <label for="editItemPreco">Preço (R$)</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="editItem_prodQuantidade"
                               name="editItem_prodQuantidade" placeholder="Estoque" disabled>
                        <label for="editItem_prodQuantidade">Estoque<span id="editItem_Unidade"></span>
                        </label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="editItem_itemQuantidade"
                               name="editItem_itemQuantidade" placeholder="Quantidade Atual" min="1" required>
                        <label for="editItem_itemQuantidade">Quantidade Desejada</label>
                    </div>
                </div>

                <div class="modal-footer bg-light d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary w-45" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success w-45">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>


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
    <main class="container pt-5" style="background: white;">
        <h2 class="mb-4 text-center">Minha Cesta</h2>
        <?php if (isset($_GET['status']) && $_GET['status'] === 'confirmado'): ?>
            <div class="alert alert-success text-center">
                Pedido confirmado com sucesso!
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'cancelado'): ?>
            <div class="alert alert-danger text-center">
                Pedido cancelado com sucesso!
            </div>
        <?php endif; ?>
        <form method="get" class="mb-4">
            <div>
                <div class="col-auto d-flex align-items-center mb-3">
                    <label for="idFeira" class="form-label fw-bold me-2">Selecione a Feira:</label>
                    <select id="idFeira" name="idFeira" class="form-select form-select-lg rounded"
                            onchange="this.form.submit()" style="width: 250px">
                        <?php foreach ($feiras as $feira): ?>
                            <option value="<?= $feira->id ?>" <?= $feira->id == $idFeiraSelecionada ? 'selected' : '' ?>>
                                <?= htmlspecialchars($feira->titulo) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>

        <?php if (!$pedidos || count($pedidos) === 0): ?>
            <div class="alert alert-info text-center">
                Você ainda não iniciou um pedido para esta feira.
            </div>
        <?php else: ?>
            <?php foreach ($pedidos as $pedido): ?>
                <?php
                $itensPedido = ItemPedido::getItensPorPedido($pedido->id);
                $totalPedido = 0;
                foreach ($itensPedido as $item) {
                    $totalPedido += $item->quantidade * $item->precoUnit;
                }
                ?>
                <?php if (!empty($itensPedido)): ?>
                    <div class="mb-5">
                        <h5 class="mb-2">Pedido #<?= $pedido->id ?> - Status:
                            <?php
                                $badgeClass = match ($pedido->status) {
                                    'Pendente' => 'warning',
                                    'Confirmado' => 'success',
                                    'Cancelado' => 'danger',
                                    default => 'secondary'
                                };
                            ?>
                            <span class="badge bg-<?= $badgeClass ?>"><?= htmlspecialchars($pedido->status) ?></span>
                        </h5>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle text-center
                            tableItemPedido" id="table_item">
                                <thead class="table-dark">
                                <tr>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                    <th>Subtotal</th>
                                    <th>Data Pedido</th>
                                    <th>Ação</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($itensPedido as $item):
                                    $produtoFeira = ProdutoFeira::getProdutoFeiraPorId($item->idProdutoFeira);
                                    $produto = Produto::getProduto($produtoFeira->idProduto);
                                    $subtotal = $item->quantidade * $item->precoUnit;
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($produto->descricao) ?></td>
                                        <td><?= $item->quantidade . ' ' . htmlspecialchars($produto->unidade) ?></td>
                                        <td>R$ <?= number_format($item->precoUnit, 2, ',', '.') ?></td>
                                        <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                                        <td><?= date('d/m/Y', strtotime($pedido->dataPedido)) ?></td>
                                        <td>
                                            <?php if ($pedido->status === 'Pendente'): ?>
                                                <button class="btn btn-warning btn-sm btnEditItem"
                                                        value="<?= $item->id ?>"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-danger bt-sm"
                                                        onclick="delItemPedido(<?= $item->id ?>, '<?= ($produtoFeira->descricao) ?>')">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="5" class="text-end"></td>
                                    <td>Total: <?= number_format($totalPedido, 2, ',', '.') ?></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php
            $ultimoPedido = null;
            $itensUltimoPedido = null;

            if ($pedidos && count($pedidos) > 0) {
                $ultimoPedido = end($pedidos);
                if ($ultimoPedido) {
                    $itensUltimoPedido = ItemPedido::getItensPorPedido($ultimoPedido->id);
                }
            }
        ?>

        <div class="d-flex justify-content-between mt-4">
            <div>
                <?php if ($ultimoPedido && $ultimoPedido->status === 'Pendente'): ?>
                    <a href="listarProdutoFeiraConsumidor.php?idFeira=<?= $idFeiraSelecionada ?>"
                       class="btn btn-primary px-4">Continuar Comprando</a>
                <?php endif; ?>
            </div>

            <form method="post">
                <div>
                    <?php if ($ultimoPedido && $ultimoPedido->status === 'Pendente' && count($itensUltimoPedido) > 0): ?>
                        <button type="submit" name="confirmar" class="btn btn-success">Confirmar Pedido</button>
                        <button type="submit" name="cancelar" class="btn btn-danger">Cancelar Pedido</button>
                        <input type="hidden" name="idPedido" value="<?= $ultimoPedido->id ?>">
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="text-center pb-5">
            <?php if ($ultimoPedido && $ultimoPedido->status === 'Cancelado'): ?>
                <a href="listarProdutoFeiraConsumidor.php?idFeira=<?= $idFeiraSelecionada ?>" class="btn btn-success">
                    Novo Pedido
                </a>
            <?php endif; ?>
        </div>
    </main>
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

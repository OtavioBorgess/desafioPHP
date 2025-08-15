<!doctype html>
<html class="no-js" lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Listagem Feira</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    require __DIR__ . '/../app/Entity/Feira.php';
    require __DIR__ . '/../app/Entity/Pedido.php';
    require __DIR__ . '/../app/Entity/Produto.php';
    require __DIR__ . '/../app/Entity/ProdutoFeira.php';
    require __DIR__ . '/../app/Entity/Usuario.php';
    require_once __DIR__ . '/../app/Db/Database.php';

    session_start();

    if (!isset($_SESSION['idUsuario'])) {
        header('Location: index.php');
        exit;
    }

    use App\Entity\Feira;
    use App\Entity\Pedido;
    use App\Entity\Produto;
    use App\Entity\ProdutoFeira;
    use App\Entity\Usuario;

    $user = Usuario::getUsuario($_SESSION['idUsuario']);
    $id = $_SESSION['idUsuario'];
    $idFeira = $_SESSION['idFeira'] ?? 1;

    $produtos = array_filter($produtos = Produto::getBuscaProduto($id), fn($p) => $p->estoque > 0);
    $produtosFeira = ProdutoFeira::getProdutosDaFeiraDoProdutor($id, $idFeira);

    $filtro = $_GET['filtro'] ?? 'ativa';
    $dataAtual = date('Y-m-d');

    $listaFeiras = Feira::getFeiras();

    switch ($filtro) {
        case 'todas':
            $feiras = $listaFeiras;
            break;
        case 'inativa':
            $feiras = array_filter($listaFeiras, fn($p) => $p->dataRealizacao < $dataAtual);
            break;
        default:
            $feiras = array_filter($listaFeiras, fn($p) => $p->dataRealizacao >= $dataAtual);
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
                $resultados .= '<button class="btn btn-sm btn-warning mr-1 btnAddProductFeira me-1" value="' .
                    $feira->id . '"><i class="fa fa-plus-square"></i></button>';
                $resultados .= '<button class="btn btn-sm btn-danger btnViewProductFeira" value="' . $feira->id . '"><i class="fa fa-eye"></i></button>';
            } else {
                $resultados .= '<span class="badge bg-danger font-14">Prazo encerrado</span>';
            }
        }

        $resultados .= '</td></tr>';
    }

    $resultados = $resultados ?: '<tr><td colspan="6">Nenhum registro encontrado</td></tr>';
?>
<body>
<!--ADDED PRODUCT FEIRA-->
<div class="modal fade" id="modalAddProductFeira" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalLabel">Adicionar Produto</h5>
            </div>

            <form id="addProductFeira">
                <input type="hidden" id="idFeira" name="idFeira">

                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label for="idProduto" class="form-label">Produto</label>
                        <select name="idProduto" id="idProduto" class="form-select" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($produtos as $produto): ?>
                                <option value="<?= $produto->id ?>"><?= $produto->descricao ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="preco" class="form-label">Preço</label>
                            <input type="number" name="preco" id="preco" class="form-control" step="0.01" min="1"
                                   required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="unidade" class="form-label">Unidade</label>
                            <input type="text" name="unidade" id="unidade" class="form-control" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="estoque" class="form-label">Estoque</label>
                            <input type="number" name="estoque" id="estoque" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="quantidade" class="form-label">Quantidade para a Feira</label>
                        <input type="number" name="quantidade" id="quantidade" class="form-control" min="1" required>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark">Salvar Produto</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!--VIEW PRODUCT FEIRA-->
<div class="modal fade" id="modalViewProductFeira" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalLabel">Produtos da Feira</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Fechar"></button>
            </div>
            <input type="hidden" id="idFeira" name="idFeira">

            <div class="modal-body bg-light">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered align-middle shadow-sm"
                           id="tableViewProduct">
                        <thead class="table-dark text-center text-uppercase">
                        <tr>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th>Unidade</th>
                            <th>Quantidade</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        <?php if (count($produtosFeira) > 0): ?>
                            <?php foreach ($produtosFeira as $prodFeira): ?>
                                <tr>
                                    <td><?= htmlspecialchars($prodFeira->descricao) ?></td>
                                    <td>R$ <?= number_format($prodFeira->preco, 2, ',', '.') ?></td>
                                    <td><?= htmlspecialchars($prodFeira->unidade) ?></td>
                                    <td><?= $prodFeira->quantidade ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btnEditProductFeira"
                                                value="<?= $prodFeira->id ?>" title="Editar">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger"
                                                onclick="delProductFeira(<?= $prodFeira->id ?>, <?= "'$prodFeira->descricao'" ?>)"
                                                title="Excluir">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center bg-info">Nenhum produto encontrado.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<!--UPDATE PRODUCT FEIRA-->
<div class="modal fade" id="modalEditProductFeira" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalLabel">Editar Produto da Feira</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Fechar"></button>
            </div>

            <form id="updateProductFeira">
                <input type="hidden" id="editIdFeira" name="editIdFeira">
                <input type="hidden" id="idProductFeira" name="idProductFeira">
                <input type="hidden" id="idEditProduto" name="idEditProduto">

                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label for="editDescricao" class="form-label fw-bold">Produto</label>
                        <input type="text" id="editDescricao" name="editDescricao" class="form-control" disabled
                               required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="editPreco" class="form-label fw-bold">Preço</label>
                            <input type="number" name="editPreco" id="editPreco" step="0.01" class="form-control"
                                   min="1" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="editUnidade" class="form-label fw-bold">Unidade</label>
                            <input type="text" name="editUnidade" id="editUnidade" class="form-control" readonly
                                   disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="editEstoque" class="form-label fw-bold">Estoque</label>
                            <input type="number" name="editEstoque" id="editEstoque" class="form-control" readonly
                                   disabled>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label for="editQuantidade" class="form-label fw-bold">Quantidade para a Feira</label>
                        <input type="number" name="editQuantidade" id="editQuantidade" class="form-control" min="1"
                               required>
                    </div>
                </div>

                <div class="modal-footer bg-light d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary w-45" data-bs-dismiss="modal">Cancelar
                    </button>
                    <button type="submit" class="btn btn-dark w-45">Salvar Produto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if ($user->perfil === 'consumidor'): ?>
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
    <?php else: ?>
    <div class="page-container login-area">
        <aside class="sidebar-menu bg-dark text-light">
            <div class="sidebar-header bg-dark">
                <a href="painel.php" class="text-light text-decoration-none">
                    <h2>AgriFood</h2>
                    <small>Produtor</small>
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
                    <li><a href="viewListarProduto.php" aria-expanded="true"
                           class="text-light d-block py-2">Produtos</a>
                    <li><a href="#" class="text-light d-block py-2">Relatórios</a></li>
                    <li><a href="logout.php" class="text-light d-block py-2">Sair</a></li>
                </ul>
            </nav>
        </aside>
        <?php endif; ?>

        <div class="main-content-inner text-center pt-5">
            <div class="d-flex justify-content-center">
                <div class="card w-100" style="max-width: 1000px;">
                    <div class="card-body">
                        <h2 class="mb-5">Feiras</h2>
                        <div class="d-flex align-items-center mb-3">
                            <label for="filtro" class="me-2 fw-bold">Filtrar:</label>
                            <form method="get">
                                <select name="filtro" id="filtro" class="form-select" onchange="this.form.submit()"
                                        style="width: 120px;">
                                    <option value="todas" <?= $filtro === 'todas' ? 'selected' : '' ?>>Todas</option>
                                    <option value="ativa" <?= $filtro === 'ativa' ? 'selected' : '' ?>>Ativas</option>
                                    <option value="inativa" <?= $filtro === 'inativa' ? 'selected' : '' ?>>Inativas
                                    </option>
                                </select>
                            </form>
                        </div>

                        <div class="table-responsive shadow-sm rounded">
                            <table class="table table-bordered table-striped table-hover align-middle mb-0">
                                <thead class="text-uppercase table-dark">
                                <tr>
                                    <th scope="col">Título</th>
                                    <th scope="col">Data Realização</th>
                                    <th scope="col">Data Prazo</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Local</th>
                                    <th scope="col" class="text-center">Ações</th>
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
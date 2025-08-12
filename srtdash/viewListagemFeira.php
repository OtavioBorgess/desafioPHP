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
    require __DIR__ . '/../app/Entity/Feira.php';
    require __DIR__ . '/../app/Entity/Pedido.php';
    require __DIR__ . '/../app/Entity/Produto.php';
    require __DIR__ . '/../app/Entity/ProdutoFeira.php';
    require __DIR__ . '/../app/Entity/Usuario.php';
    require_once __DIR__ . '/../app/Db/Database.php';

    session_start();

    use App\Entity\Feira;
    use App\Entity\Pedido;
    use App\Entity\Produto;
    use App\Entity\ProdutoFeira;
    use App\Entity\Usuario;

    $user = Usuario::getUsuario($_SESSION['idUsuario']);
    $id = $_SESSION['idUsuario'];
    $idFeira = $_SESSION['idFeira'];

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
                $resultados .= '<button class="btn btn-sm btn-warning mr-1 btnAddProductFeira" value="' . $feira->id . '"><i class="fa fa-plus-square"></i></button>';
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
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="addProductFeira">

                <input type="hidden" id="idFeira" name="idFeira">

                <div class="modal-body bg-light">
                    <div class="form-group">
                        <label for="idProduto">Produto</label>
                        <select name="idProduto" id="idProduto" class="form-control" required style="padding: 0 10px">
                            <option value="">Selecione...</option>
                            <?php foreach ($produtos as $produto): ?>
                                <option value="<?= $produto->id ?>">
                                    <?= $produto->descricao ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="preco">Preço</label>
                            <input type="number" name="preco" id="preco" class="form-control" min="1" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="unidade">Unidade</label>
                            <input type="text" name="unidade" id="unidade" class="form-control" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="estoque">Estoque</label>
                            <input type="number" name="estoque" id="estoque" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantidade">Quantidade para a Feira</label>
                        <input type="number" name="quantidade" id="quantidade" class="form-control" min="1" required>
                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark">Salvar Produto</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!--VIEW PRODUCT FEIRA-->
<div class="modal fade" id="modalViewProductFeira" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalLabel">Adicionar Produto</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <input type="hidden" id="idFeira" name="idFeira">

            <div class="modal-body bg-light">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle shadow-sm" id="tableViewProduct">
                        <thead class="thead-dark bg-dark text-white">
                        <tr>
                            <th class="text-center">Descrição</th>
                            <th class="text-center">Preço</th>
                            <th class="text-center">Unidade</th>
                            <th class="text-center">Quantidade</th>
                            <th class="text-center">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($produtosFeira as $prodFeira): ?>
                            <tr>
                                <td class="text-center"><?= $prodFeira->descricao ?></td>
                                <td class="text-center">R$ <?= number_format($prodFeira->preco, 2, ',', '.') ?></td>
                                <td class="text-center"><?= $prodFeira->unidade ?></td>
                                <td class="text-center"><?= $prodFeira->quantidade ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning btnEditProductFeira" value="<?= $prodFeira->id ?>"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger" onclick="delProductFeira(<?= $prodFeira->id ?>, <?= "'$prodFeira->descricao '"?>)"><i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--UPDATE PRODUCT FEIRA-->
<div class="modal fade" id="modalEditProductFeira" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalLabel">Adicionar Produto</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="updateProductFeira">

                <input type="hidden" id="editIdFeira" name="editIdFeira">
                <input type="hidden" id="idProductFeira" name="idProductFeira">

                <div class="modal-body bg-light">
                    <div class="form-group">
                        <label for="editDescricao">Produto</label>
                        <input type="text" id="editDescricao" name="editDescricao" class="form-control" required disabled>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="editPreco">Preço</label>
                            <input type="number" name="editPreco" id="editPreco" class="form-control" min="1" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="editUnidade">Unidade</label>
                            <input type="text" name="editUnidade" id="editUnidade" class="form-control" readonly disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="editEstoque">Estoque</label>
                            <input type="number" name="editEstoque" id="editEstoque" class="form-control" readonly disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editQuantidade">Quantidade para a Feira</label>
                        <input type="number" name="editQuantidade" id="editQuantidade" class="form-control" min="1" required>
                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark">Salvar Produto</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php if ($user->perfil === 'consumidor'): ?>
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
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <form method="get" class="form-inline">
                                <label for="filtro" class="mr-2 font-weight-bold">Filter:</label>
                                <select name="filtro" id="filtro" onchange="this.form.submit()" class="form-control"
                                        style="padding: 0 15px">
                                    <option value="todas" <?= $filtro === 'todas' ? 'selected' : '' ?>>Todas
                                    </option>
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
                                    <thead class="text-uppercase bg-dark">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/crud.js"></script>
</html>
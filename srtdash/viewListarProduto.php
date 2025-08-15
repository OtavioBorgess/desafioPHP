<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem Produto</title>
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

    include __DIR__ . '/../app/Entity/Produto.php';
    include __DIR__ . '/../app/Db/Database.php';

    use App\Entity\Produto;
    session_start();

    if (!isset($_SESSION['idUsuario'])) {
        header('Location: index.php');
        exit;
    }

    $id = $_SESSION['idUsuario'];

    $filtro = $_GET['filtro'] ?? 'disponiveis';

    switch ($filtro) {
        case 'todos':
            $produtos = array_filter(Produto::getBuscaProduto($id));
            break;
        case 'indisponiveis':
            $produtos = array_filter(Produto::getBuscaProduto($id), fn($p) => $p->estoque <= 0);
            break;
        default:
            $produtos = array_filter(Produto::getBuscaProduto($id), fn($p) => $p->estoque > 0);
    }

    $resultados = '';
    foreach ($produtos as $produto) {
        $id = $produto->id;
        $p_name = $produto->descricao;

        $resultados .= '<tr>
        <td>' . htmlspecialchars($produto->descricao) . '</td>
        <td>' . number_format($produto->preco, 2, ',', ' ') . '</td>
        <td>' . htmlspecialchars($produto->unidade) . '</td>
        <td>' . (int)$produto->estoque . '</td>
        <td>
            <div>
                <button class="btn btn-sm btn-warning btnEditProduct" value="' . $id . '"><i class="fa fa-edit"></i></button>
                 <button class="btn btn-sm btn-danger" onclick="delProduto(' . $id . ', \'' . ($p_name) . '\')"><i class="fa fa-trash-o"></i></button>
            </div>
        </td>
    </tr>';
    }

    $resultados = strlen($resultados) ? $resultados : '<tr><td colspan="7">Nenhum registro encontrado</td></tr>';

?>

<body>
<!-- Added Product -->
<div class="modal fade" id="modalAdicionarProduto" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalLabel">Adicionar Produto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <form id="saveProduct">
                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label for="descricao" class="form-label fw-bold">Descrição</label>
                        <input type="text" name="descricao" class="form-control" placeholder="Ex: Tomate cereja" required>
                    </div>

                    <div class="mb-3">
                        <label for="preco" class="form-label fw-bold">Preço (R$)</label>
                        <input type="number" name="preco" step="0.01" class="form-control" min="1" placeholder="Ex: 4.50" required>
                    </div>

                    <div class="mb-3">
                        <label for="unidade" class="form-label fw-bold">Unidade</label>
                        <select name="unidade" class="form-select">
                            <option value="kg">kg</option>
                            <option value="g">g</option>
                            <option value="un">un</option>
                        </select>
                    </div>

                    <div class="mb-0">
                        <label for="estoque" class="form-label fw-bold">Estoque</label>
                        <input type="number" name="estoque" class="form-control" min="0" placeholder="Ex: 100" required>
                    </div>
                </div>

                <div class="modal-footer bg-light d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary w-45" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success w-45">Salvar Produto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product -->
<div class="modal fade" id="modalEditProduct" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalLabel">Editar Produto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <form id="updateProduct">
                <input type="hidden" id="idProduct" name="idProduct">

                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label for="descricao" class="form-label fw-bold">Descrição</label>
                        <input type="text" name="descricao" id="descricao" class="form-control"
                               placeholder="Ex: Tomate cereja" required>
                    </div>
                    <div class="mb-3">
                        <label for="preco" class="form-label fw-bold">Preço (R$)</label>
                        <input type="number" name="preco" step="0.01" min="1" id="preco" class="form-control"
                               placeholder="Ex: 4.50" required>
                    </div>
                    <div class="mb-3">
                        <label for="unidade" class="form-label fw-bold">Unidade</label>
                        <select name="unidade" id="unidade" class="form-select">
                            <option value="kg">kg</option>
                            <option value="g">g</option>
                            <option value="un">un</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label for="estoque" class="form-label fw-bold">Estoque</label>
                        <input type="number" name="estoque" id="estoque" min="0" class="form-control"
                               placeholder="Ex: 100" required>
                    </div>
                </div>

                <div class="modal-footer bg-light d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary w-45" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success w-45">Editar Produto</button>
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
                <small>Produtor</small>
            </a>
        </div>
        <nav class="main-menu">
            <ul class="metismenu" id="menu">
                <li>
                    <a href="#perfilMenu" class="text-light d-block py-2" data-bs-toggle="collapse" aria-expanded="false">
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

    <div class="main-content-inner text-center pt-5">
        <div class="d-flex justify-content-center">
            <div class="card w-100" style="max-width: 1000px;">
                <div class="card-body">
                    <h2 class=" mb-4">Seus Produtos</h2>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <form method="get" class="form-inline">
                            <div class="d-flex align-items-center">
                                <label for="filtro" class="me-2 fw-bold">Filtrar:</label>
                                <form method="get">
                                    <select name="filtro" id="filtro" class="form-select" onchange="this.form.submit()" style="width: 150px;">
                                        <option value="todos" <?= $filtro === 'todos' ? 'selected' : '' ?>>Todos</option>
                                        <option value="disponivel" <?= $filtro === 'disponivel' ? 'selected' : '' ?>>Disponível</option>
                                        <option value="indisponiveis" <?= $filtro === 'indisponiveis' ? 'selected' : '' ?>>Indisponiveis</option>
                                    </select>
                                </form>
                            </div>
                        </form>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdicionarProduto">
                            Adicionar Produto
                        </button>
                    </div>

                    <div class="table-responsive shadow-sm rounded">
                        <table class="table table-bordered table-striped table-hover align-middle mb-0" id="table_product">
                                <thead class="text-uppercase table-dark">
                                <tr class="text-white">
                                    <th scope="col">Nome</th>
                                    <th scope="col">Preço</th>
                                    <th scope="col">Unidade</th>
                                    <th scope="col">Estoque</th>
                                    <th scope="col">Ações</th>
                                </tr>
                                </thead>
                                <tbody id="products">
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

<!doctype html>
<html class="no-js" lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
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
    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\Usuario;
    use App\Entity\Endereco;

    session_start();

    if (!isset($_SESSION['idUsuario'])) {
        header('Location: index.php');
        exit;
    }

    $user = $_SESSION['idUsuario'];

    $usuario = Usuario::getUsuario($user);
    $end = Endereco::getEndereco($user);

    $estadoSelecionado = $end->estado ?? '';

?>

<body>
<?php if ($usuario->perfil === 'consumidor'): ?>
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
                    <a href="#perfilMenu" class="text-light d-block py-2" data-bs-toggle="collapse" aria-expanded="false">
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
                        <a href="#perfilMenu" class="text-light d-block py-2" data-bs-toggle="collapse" aria-expanded="false">
                            Perfil <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="collapse list-unstyled ps-4" id="perfilMenu">
                            <li><a href="viewEditarPerfil.php" class="text-light py-1 d-block">Editar</a></li>
                            <li><a href="viewAlterarSenha.php" class="text-light py-1 d-block">Alterar senha</a></li>
                        </ul>
                    </li>
                    <li><a href="viewListagemFeira.php" class="text-light d-block py-2">Feiras</a></li>
                    <li><a href="viewListarProduto.php" aria-expanded="true" class="text-light d-block py-2">Produtos</a>
                    </li>
                    <li><a href="#" class="text-light d-block py-2">Relatórios</a></li>
                    <li><a href="logout.php" class="text-light d-block py-2">Sair</a></li>
                </ul>
            </nav>
        </aside>
        <?php endif; ?>

        <div class="main-content login-area">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card shadow-sm rounded">
                            <div class="card-header bg-dark text-white text-center">
                                <h4>Editar Perfil</h4>
                            </div>
                            <div class="card-body">
                                <form id="updatePerfil">

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="nome" name="nome" value="<?= $usuario->nome ?>" placeholder="Nome" required>
                                        <label for="nome">Nome</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="email" name="email" value="<?= $usuario->email ?>" placeholder="E-mail" required>
                                        <label for="email">E-mail</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="tel" class="form-control" id="telefone" name="telefone" value="<?= $usuario->telefone ?>" placeholder="Telefone" required>
                                        <label for="telefone">Telefone</label>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-8">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="rua" name="rua" value="<?= $end->rua ?? '' ?>" placeholder="Rua" required>
                                                <label for="rua">Rua</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="numero" name="numero" value="<?= $end->numero ?? '' ?>" placeholder="Numero" required>
                                                <label for="numero">Número</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="complemento" name="complemento" value="<?= $end->complemento ?? '' ?>" placeholder="Complemento">
                                        <label for="complemento">Complemento</label>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="bairro" name="bairro" value="<?= $end->bairro ?? '' ?>" placeholder="Bairro" required>
                                                <label for="bairro">Bairro</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="cep" name="cep" value="<?= $end->cep ?? '' ?>" pattern="\d{5}-?\d{3}" placeholder="12345-678" required>
                                                <label for="cep">CEP</label>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="cidade" name="cidade" value="<?= $end->cidade ?? '' ?>" placeholder="Cidade" required>
                                                <label for="cidade">Cidade</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-floating mb-4">
                                        <select name="estado" id="estado" class="form-select" required>
                                            <option value="">Selecione</option>
                                            <option value="AC" <?= $estadoSelecionado === 'AC' ? 'selected' : '' ?>>Acre</option>
                                            <option value="AL" <?= $estadoSelecionado === 'AL' ? 'selected' : '' ?>>Alagoas</option>
                                            <option value="AP" <?= $estadoSelecionado === 'AP' ? 'selected' : '' ?>>Amapá</option>
                                            <option value="AM" <?= $estadoSelecionado === 'AM' ? 'selected' : '' ?>>Amazonas</option>
                                            <option value="BA" <?= $estadoSelecionado === 'BA' ? 'selected' : '' ?>>Bahia</option>
                                            <option value="CE" <?= $estadoSelecionado === 'CE' ? 'selected' : '' ?>>Ceará</option>
                                            <option value="DF" <?= $estadoSelecionado === 'DF' ? 'selected' : '' ?>>Distrito Federal</option>
                                            <option value="ES" <?= $estadoSelecionado === 'ES' ? 'selected' : '' ?>>Espírito Santo</option>
                                            <option value="GO" <?= $estadoSelecionado === 'GO' ? 'selected' : '' ?>>Goiás</option>
                                            <option value="MA" <?= $estadoSelecionado === 'MA' ? 'selected' : '' ?>>Maranhão</option>
                                            <option value="MT" <?= $estadoSelecionado === 'MT' ? 'selected' : '' ?>>Mato Grosso</option>
                                            <option value="MS" <?= $estadoSelecionado === 'MS' ? 'selected' : '' ?>>Mato Grosso do Sul</option>
                                            <option value="MG" <?= $estadoSelecionado === 'MG' ? 'selected' : '' ?>>Minas Gerais</option>
                                            <option value="PA" <?= $estadoSelecionado === 'PA' ? 'selected' : '' ?>>Pará</option>
                                            <option value="PB" <?= $estadoSelecionado === 'PB' ? 'selected' : '' ?>>Paraíba</option>
                                            <option value="PR" <?= $estadoSelecionado === 'PR' ? 'selected' : '' ?>>Paraná</option>
                                            <option value="PE" <?= $estadoSelecionado === 'PE' ? 'selected' : '' ?>>Pernambuco</option>
                                            <option value="PI" <?= $estadoSelecionado === 'PI' ? 'selected' : '' ?>>Piauí</option>
                                            <option value="RJ" <?= $estadoSelecionado === 'RJ' ? 'selected' : '' ?>>Rio de Janeiro</option>
                                            <option value="RN" <?= $estadoSelecionado === 'RN' ? 'selected' : '' ?>>Rio Grande do Norte</option>
                                            <option value="RS" <?= $estadoSelecionado === 'RS' ? 'selected' : '' ?>>Rio Grande do Sul</option>
                                            <option value="RO" <?= $estadoSelecionado === 'RO' ? 'selected' : '' ?>>Rondônia</option>
                                            <option value="RR" <?= $estadoSelecionado === 'RR' ? 'selected' : '' ?>>Roraima</option>
                                            <option value="SC" <?= $estadoSelecionado === 'SC' ? 'selected' : '' ?>>Santa Catarina</option>
                                            <option value="SP" <?= $estadoSelecionado === 'SP' ? 'selected' : '' ?>>São Paulo</option>
                                            <option value="SE" <?= $estadoSelecionado === 'SE' ? 'selected' : '' ?>>Sergipe</option>
                                            <option value="TO" <?= $estadoSelecionado === 'TO' ? 'selected' : '' ?>>Tocantins</option>
                                        </select>
                                        <label for="estado">Estado</label>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-dark btn-lg">Salvar Alterações</button>
                                    </div>
                                </form>
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

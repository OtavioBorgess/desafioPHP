<!doctype html>
<html class="no-js" lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha</title>
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
    include __DIR__ . '/../app/Entity/Usuario.php';

    use App\Entity\Usuario;

    session_start();

    if (!isset($_SESSION['idUsuario'])) {
        header('Location: index.php');
        exit;
    }

    $user = $_SESSION['idUsuario'];

    $usuario = Usuario::getUsuario($user);

?>

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
        <?php endif; ?>

        <div class="main-content login-area">
            <div class="container py-5">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-8">
                        <div class="card shadow">
                            <div class="card-header bg-dark text-white text-center">
                                <h4>Alterar senha</h4>
                            </div>
                            <div class="card-body">
                                <form id="editarSenha">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="senhaAtual" name="senhaAtual"
                                               placeholder="Senha Atual" required>
                                        <label for="senhaAtual">Senha atual</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="novaSenha" name="novaSenha"
                                               placeholder="Nova Senha" required>
                                        <label for="novaSenha">Nova senha</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="confirmaSenha" name="confirmaSenha"
                                               placeholder="Repita a Senha" required>
                                        <label for="confirmaSenha">Repita a nova senha</label>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-dark">Salvar Alterações</button>
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

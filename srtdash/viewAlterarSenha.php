<!doctype html>
<html class="no-js" lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Editar Perfil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
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

<body>
<?php
include __DIR__ . '/../app/Entity/Usuario.php';

use App\Entity\Usuario;

session_start();

$user = $_SESSION['idUsuario'];

$usuario = Usuario::getUsuario($user);

?>

<?php if ($usuario->perfil === 'consumidor'): ?>
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

        <div class="main-content login-area">
            <div class="container py-5">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-8">
                        <div class="card shadow">
                            <div class="card-header bg-dark text-white text-center">
                                <h4>Alterar senha</h4>
                            </div>
                            <div class="card-body">
                                <form action="alterarSenha.php" method="POST">
                                    <div class="form-group mb-3">
                                        <label for="senhaAtual">Senha atual</label>
                                        <input type="password" class="form-control" id="senhaAtual" name="senhaAtual"
                                               required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="novaSenha">Senha nova</label>
                                        <input type="password" class="form-control" id="novaSenha" name="novaSenha"
                                               required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="confirmaSenha">Senha nova</label>
                                        <input type="password" class="form-control" id="confirmaSenha"
                                               name="confirmaSenha"
                                               required>
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

    <!-- Scripts -->
    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>

</body>
</html>

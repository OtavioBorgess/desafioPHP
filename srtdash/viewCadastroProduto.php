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

<body>
<div class="page-container">
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

    <div class="login-area">
        <div class="container">
            <div class="login-box">

                <form action="cadastroProduto.php" method="post">
                    <div class="login-form-head bg-dark">
                        <h4>Cadastrar Produto</h4>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="descricao" class="text-dark">Nome</label>
                            <input type="text" id="descricao" name="descricao" required>
                        </div>
                        <div class="form-gp">
                            <label for="preco" class="text-dark">Preço</label>
                            <input type="number" id="preco" name="preco" step="0.01" required>
                        </div>
                        <label for="perfil" class="text-dark">Unidade</label>
                        <div class="form-gp">
                            <div class="form-select">
                                <select name="unidade" id="unidade" class="form-control d-flex
                                justify-content-center" style="padding:0 0 0 10px; font-size: 16px">
                                    <option value="kg">kg</option>
                                    <option value="g">g</option>
                                    <option value="un">un</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-gp">
                            <label for="estoque" class="text-dark">Estoque</label>
                            <input type="number" id="estoque" name="estoque" step="1" required min="0">
                        </div>
                        <div class="submit-btn-area">
                            <button class="bg-dark" id="form_submit" type="submit">Cadastrar<i
                                        class="ti-arrow-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
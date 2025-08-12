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
<div class="login-area">
    <div class="container">
        <div class="login-box ptb--100">

            <form id="saveUser">
                <div class="login-form-head">
                    <h4>Inscrever-se</h4>
                </div>
                <div class="login-form-body">
                    <div class="form-gp">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" required>
                        <i class="ti-user"></i>
                    </div>
                    <div class="form-gp">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                        <i class="ti-email"></i>
                    </div>
                    <div class="form-gp">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" minlength="6" required>
                        <i class="ti-lock"></i>
                    </div>
                    <label for="perfil" class="text-muted opacity-50">Perfil</label>
                    <div class="form-gp">
                        <div class="custom-select-wrapper">
                            <select name="perfil" id="perfil" class="form-control">
                                <option value="consumidor">Consumidor</option>
                                <option value="produtor">Produtor</option>
                            </select>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </div>
                    <div class="submit-btn-area">
                        <button id="form_submit" type="submit">Cadastrar<i class="ti-arrow-right"></i></button>
                    </div>
                    <div class="form-footer text-center mt-5">
                        <p class="text-muted">Já possui uma conta? <a href="index.php">Entrar</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
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
</body>

</html>
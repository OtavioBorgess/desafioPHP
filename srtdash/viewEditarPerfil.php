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
<div class="page-container">
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <div class="logo">
                <a href="painelProdutor.php"><h2 class="text-light">AgriFood</h2></a>
                <p class="text-light">Produtor</p>
            </div>
        </div>
        <div class="main-menu">
            <div class="menu-inner">
                <nav>
                    <ul class="metismenu" id="menu">
                        <li>
                            <a href="#" aria-expanded="true"><span>Perfil</span></a>
                            <ul class="collapse">
                                <li><a href="viewEditarPerfil.php">Editar</a></li>
                                <li><a href="viewAlterarSenha.php">Alterar senha</a></li>
                            </ul>
                        </li>
                        <li><a href="listarFeira.php"><span>Listar Feiras</span></a></li>
                        <li>
                            <a href="#" aria-expanded="true"><span>Produtos</span></a>
                            <ul class="collapse">
                                <li><a href="viewCadastroProduto.php">Cadastrar</a></li>
                                <li><a href="listagemProdutoProdutor.php">Listar</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><span>Relatórios</span></a></li>
                        <li><a href="logout.php"><span>Sair</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <?php
        require __DIR__ . '/../vendor/autoload.php';

        use App\Entity\Usuario;
        use App\Entity\Endereco;

        $user = Usuario::getUsuario();
        $end = Endereco::getEndereco();

        $estadoSelecionado = $end->estado ?? '';

    ?>

    <div class="main-content login-area">
        <div class="container py-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-header bg-secondary text-white text-center">
                            <h4>Editar Perfil</h4>
                        </div>
                        <div class="card-body">
                            <form action="editarPerfil.php" method="POST">
                                <!-- Nome, Email e Telefone ocupando 100% da largura -->
                                <div class="form-group mb-3">
                                    <label for="nome">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome"
                                           value="<?= $user->nome ?>" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email">E-mail</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="<?= $user->email ?>" required>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="telefone">Telefone</label>
                                    <input type="tel" class="form-control" id="telefone" name="telefone"
                                           value="<?= $user->telefone ?>" required>
                                </div>

                                <!-- Endereço - espaçoso e organizado -->

                                <!-- Linha 1: Rua e Número -->
                                <div class="form-row mb-3">
                                    <div class="col-md-8">
                                        <label for="rua">Rua</label>
                                        <input type="text" class="form-control" id="rua" name="rua" value="<?= $end->rua ?? '' ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="numero">Número</label>
                                        <input type="text" class="form-control" id="numero" name="numero" value="<?= $end->numero ?? '' ?>" required>
                                    </div>
                                </div>

                                <!-- Linha 2: Complemento -->
                                <div class="form-group mb-3">
                                    <label for="complemento">Complemento</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento" value="<?= $end->complemento ?? '' ?>">
                                </div>

                                <!-- Linha 3: Bairro, CEP e Cidade -->
                                <div class="form-row mb-3">
                                    <div class="col-md-4">
                                        <label for="bairro">Bairro</label>
                                        <input type="text" class="form-control" id="bairro" name="bairro" value="<?= $end->bairro ?? '' ?>" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="cep">CEP</label>
                                        <input type="text" class="form-control" id="cep" name="cep" value="<?= $end->cep ?? '' ?>" required pattern="\d{5}-?\d{3}" placeholder="12345-678">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="cidade">Cidade</label>
                                        <input type="text" class="form-control" id="cidade" name="cidade" value="<?= $end->cidade ?? '' ?>" required>
                                    </div>
                                </div>

                                <!-- Linha 4: Estado -->
                                <div class="form-group mb-4">
                                    <label for="estado">Estado</label>
                                    <select name="estado" id="estado" class="form-control" style="padding: 0 0 0 10px;"
                                            required>
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
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-secondary">Salvar Alterações</button>
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

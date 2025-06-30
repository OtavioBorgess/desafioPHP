<?php

    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Entity\Usuario;

    if (isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['perfil'])) {

        $obUser = new Usuario;
        $obUser->nome = $_POST['nome'];
        $obUser->email = $_POST['email'];
        $obUser->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $obUser->perfil = $_POST['perfil'];
        $obUser->cadastrar();

        header("Location: index.php?status=success");
        exit;
    }
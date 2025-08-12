<?php

    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Entity\Usuario;

    if (isset($_POST['save_user'])) {

        $obUser = new Usuario;
        $obUser->nome = $_POST['nome'];
        $obUser->email = $_POST['email'];
        $obUser->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $obUser->perfil = $_POST['perfil'];
        $obUser->cadastrar();

        echo json_encode([
            'status' => 'success',
            'message' => 'Cadastro realizado com sucesso!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erro ao realizar cadastro!'
        ]);
    }
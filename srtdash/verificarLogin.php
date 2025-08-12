<?php
    require __DIR__ . '/../vendor/autoload.php';

    header('Content-type: application/json');

    session_start();

    use App\Entity\Usuario;

    $usuario = Usuario::login($_POST['email']);

    if ($usuario && password_verify($_POST['senha'], $usuario->senha)) {
        $_SESSION['idUsuario'] = $usuario->id;

        if ($usuario && password_verify($_POST['senha'], $usuario->senha)) {
            $_SESSION['idUsuario'] = $usuario->id;

            echo json_encode([
                'status' => 'success',
                'message' => 'Login efetuado com sucesso'
            ]);
            exit;
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Credenciais incorretas'
        ]);
    }     exit;

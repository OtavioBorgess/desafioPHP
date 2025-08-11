<?php
    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\Usuario;
    session_start();

    header('Content-Type: application/json');


    $id = $_SESSION['idUsuario'];

    $return = Usuario::getUsuario($id);

    $senhaAtual = $_POST['senhaAtual'] ?? '';

    if (password_verify($senhaAtual, $return->senha)) {
        if (isset($_POST['novaSenha'], $_POST['confirmaSenha'])) {
            if ($_POST['novaSenha'] === $_POST['confirmaSenha']) {
                $return->senha = password_hash($_POST['novaSenha'], PASSWORD_DEFAULT);
                $return->alterarSenha();
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Senha alterada com sucesso!'
                ]);
            } else {
                echo json_encode([
                    'status' => "error",
                    'message' => "Senhas diferentes"
                ]);
            }
            exit;
        }
    } else {
        echo json_encode([
            'status' => "error",
            'message' => "Senha atual incorreta",
        ]);
        exit;
    }
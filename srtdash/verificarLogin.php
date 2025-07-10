<?php
require __DIR__ . '/../vendor/autoload.php';

session_start();

use App\Entity\Usuario;

$usuario = Usuario::login($_POST['email']);

if ($usuario && password_verify($_POST['senha'], $usuario->senha)) {
    $_SESSION['idUsuario'] = $usuario->id;

    if ($usuario && password_verify($_POST['senha'], $usuario->senha)) {
        $_SESSION['idUsuario'] = $usuario->id;
        header("Location: painel.php?status=success");
        exit;
    }
} else {
    echo "<script>alert('Credenciais incorretas!'); window.location.href = 'index.php?status=error';</script>";
    exit;
}
<?php
    require __DIR__ . '/../vendor/autoload.php';

    session_start();

    use App\Entity\Usuario;

    $return = Usuario::login($_POST['email']);

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (password_verify($_POST['senha'], $return->senha)) {
        $_SESSION['idUsuario'] = $return->id;
        switch ($return->perfil) {
            case 'produtor':
                header("location: painelProdutor.php");
                exit;

            case 'consumidor':
                header("location: painelConsumidor.php");
                exit;

            default:
                echo "Perfil não encontrado";
        }
    } else {
        echo "<script>alert('Credenciais incorretas.'); window.location.href = 'index.php?stauts=error';</script>";
        exit;
    }

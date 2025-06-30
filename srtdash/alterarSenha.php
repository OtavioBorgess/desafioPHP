<?php
    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\Usuario;

    $return = Usuario::getUsuario();

    $senhaAtual = $_POST['senhaAtual'] ?? '';

    if (password_verify($senhaAtual, $return->senha)) {
        if (isset($_POST['novaSenha'], $_POST['confirmaSenha'])) {
            if ($_POST['novaSenha'] === $_POST['confirmaSenha']) {
                $return->senha = password_hash($_POST['novaSenha'], PASSWORD_DEFAULT);
                $return->alterarSenha();
                header("Location: index.php?status=success");
            } else {
                echo "<script>alert('A nova senha e a confirmação não coincidem!'); window.location.href = 'viewAlterarSenha.php?status=error';</script>";
                exit;
            }
        }
    } else {
        echo "<script>alert('Senha atual incorreta!'); window.location.href = 'viewAlterarSenha.php?status=error';</script>";
        exit;
    }
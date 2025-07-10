<?php
    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\Usuario;
    use App\Entity\Endereco;

    session_start();
    $idUsuario = $_SESSION['idUsuario'];

    if (isset($_POST['nome'], $_POST['email'], $_POST['telefone'], $_POST['rua'], $_POST['numero'], $_POST['complemento'], $_POST['bairro'], $_POST['cep'], $_POST['cidade'], $_POST['estado'])) {

        $user = Usuario::getUsuario($idUsuario);
        $user->nome = $_POST['nome'];
        $user->email = $_POST['email'];
        $user->telefone = $_POST['telefone'];
        $user->editar();

        $end = Endereco::getEndereco();
        if (!$end) {
            $end = new Endereco();
            $end->idUsuario = $_SESSION['idUsuario'];
        }

        $end->rua = $_POST['rua'];
        $end->numero = $_POST['numero'];
        $end->complemento = $_POST['complemento'];
        $end->bairro = $_POST['bairro'];
        $end->cep = $_POST['cep'];
        $end->cidade = $_POST['cidade'];
        $end->estado = $_POST['estado'];

        $end->id ? $end->atualizar() : $end->cadastrar();

        echo "<script>alert('Perfil editado com sucesso.'); window.location.href = 'viewEditarPerfilProdutor.php?status=success';</script>";
        exit;
    } else {
        echo "<script>alert('Erro ao editar o perfil.'); window.location.href = 'viewEditarPerfilProdutor.php?status=error';</script>";
        exit;
    }

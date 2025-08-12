<?php
    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\Usuario;
    use App\Entity\Endereco;

    header('Content-type: application/json');

    session_start();
    $idUsuario = $_SESSION['idUsuario'];

    if (isset($_POST['update_perfil'])) {

        $user = Usuario::getUsuario($idUsuario);
        $user->nome = $_POST['nome'];
        $user->email = $_POST['email'];
        $user->telefone = $_POST['telefone'];
        $user->editar();

        $end = Endereco::getEndereco($idUsuario);
        if (!$end) {
            $end = new Endereco();
            $end->idUsuario = $idUsuario;
        }

        $end->rua = $_POST['rua'];
        $end->numero = $_POST['numero'];
        $end->complemento = $_POST['complemento'];
        $end->bairro = $_POST['bairro'];
        $end->cep = $_POST['cep'];
        $end->cidade = $_POST['cidade'];
        $end->estado = $_POST['estado'];

        $end->id ? $end->atualizar() : $end->cadastrar();
        echo json_encode([
            'status' => 'success',
            'message' => 'Perfil atualizado com sucesso!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erro ao atualizar perfil!'
        ]);
    }
    exit;

<?php

    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\Feira;

    header ('Content-Type: application/json');
    session_start();

    if (!isset($_GET['idFeira']) or !is_numeric($_GET['idFeira'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID inválido'
        ]);
        exit;
    }

    $obFeira = Feira::getFeira($_GET['idFeira']);
    $_SESSION['idFeira'] = $obFeira->id;

    if ($obFeira) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Feira encontrada!',
            'id' => $obFeira->id,
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Feira não encontrada!'
        ]);
    }
    exit;
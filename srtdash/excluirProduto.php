<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Entity\Produto;

$id = $_POST['p_id'];

if (!isset($id) || !is_numeric($id)) {
    http_response_code(400);
    echo '<tr><td colspan="7">ID inválido</td></tr>';
    exit;
}

$obProd = Produto::getProduto($id);

if (!$obProd instanceof Produto) {
    http_response_code(404);
    echo '<tr><td colspan="7">Produto não encontrado</td></tr>';
    exit;
}

$obProd->excluir();

$produtos = Produto::getBuscaProduto();

$resultados = '';
foreach ($produtos as $produto) {
    $id = $produto->id;
    $p_name = addslashes($produto->descricao);

    $resultados .= '<tr>
        <td>' . htmlspecialchars($produto->descricao) . '</td>
        <td>' . number_format($produto->preco, 2, ',', ' ') . '</td>
        <td>' . htmlspecialchars($produto->unidade) . '</td>
        <td>' . (int)$produto->estoque . '</td>
        <td>
            <div>
                <a href="index.php?id=' . $id . '&flag=edit" class="fa fa-edit" title="Editar" style="margin-right: 10px;"></a>
                <a href="javascript:void(0)" class="fa fa-trash text-danger" title="Excluir" onclick="delProduto(' . $id . ', \'' . $p_name . '\')"></a>
            </div>
        </td>
    </tr>';
}

echo strlen($resultados) ? $resultados : '<tr><td colspan="7">Nenhum registro encontrado</td></tr>';

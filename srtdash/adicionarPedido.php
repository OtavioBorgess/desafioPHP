<?php
session_start();

require_once './../vendor/autoload.php';

use App\Entity\Pedido;
use App\Entity\ItemPedido;
use App\Entity\ProdutoFeira;

$idFeira = $_POST['idFeira'] ?? null;
$idProdutoFeira = $_POST['idProdutoFeira'] ?? null;
$quantidade = $_POST['quantidade'] ?? null;
$preco = $_POST['preco'] ?? null;

$idUsuario = $_SESSION['idUsuario'];

$pedido = Pedido::getPedidoExistente($idUsuario, $idFeira);

if (!$pedido) {
    $pedido = new Pedido();
    $pedido->idUsuario = $idUsuario;
    $pedido->idFeira = $idFeira;
    $pedido->status = 'Pendente';
    $pedido->dataPedido = date('Y-m-d');
    $pedido->valorTotal = 0;
    $pedido->cadastrar();
}

$item = new ItemPedido();
$item->idPedido = $pedido->id;
$item->idProdutoFeira = $idProdutoFeira;
$item->quantidade = $quantidade;
$item->precoUnit = $preco;
$item->subTotal = $item->quantidade * $item->precoUnit;
$item->cadastrar();

$pedido->valorTotal += $item->subTotal;
$pedido->atualizar();

$prodFeira = ProdutoFeira::getProdutoFeiraPorId($idProdutoFeira);
$prodFeira->quantidade -= $quantidade;
$prodFeira->atualizar();

header('Location: viewVisualizarPedidos.php?idFeira=' . $idFeira);
exit;
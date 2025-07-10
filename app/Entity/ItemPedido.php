<?php

namespace App\Entity;

use App\Db\DataBase;
use PDO;

class ItemPedido
{

    public $id;
    public $idPedido;
    public $idProdutoFeira;
    public $quantidade;
    public $precoUnit;
    public $subTotal;

    public function cadastrar()
    {
        $obDatabase = new Database('itemPedido');
        $this->id = $obDatabase->insert([
            'idPedido' => $this->idPedido,
            'idProdutoFeira' => $this->idProdutoFeira,
            'quantidade' => $this->quantidade,
            'precoUnit' => $this->precoUnit,
            'subTotal' => $this->subTotal
        ]);
    }

    public function atualizar()
    {
        return (new Database('itemPedido'))
            ->update('id = ' . $this->id, [
                'quantidade' => $this->quantidade,
                'subTotal' => $this->subTotal
            ]);
    }

    public function excluir()
    {
        return (new Database('itemPedido'))->delete('id = ' . $this->id);
    }

    public static function getPedido($id)
    {
        return (new Database('itemPedido'))->select('id = ' . $id)
            ->fetchObject(self::class);
    }

    public static function getItem($id)
    {
        $db = new Database('itemPedido');
        $query = "
        SELECT ip.*, p.descricao, pf.idFeira
        FROM itemPedido ip
        JOIN produto_feira pf ON pf.id = ip.idProdutoFeira
        JOIN produto p ON p.id = pf.idProduto
        WHERE ip.id = ?
    ";
        return $db->execute($query, [$id])
            ->fetchObject(self::class);
    }

    public static function getItensPorPedido($idPedido)
    {
        $db = new Database('itemPedido');
        $query = "
        SELECT * 
        FROM itemPedido 
        WHERE idPedido = ?";
        return $db->execute($query, [$idPedido])
            ->fetchAll(PDO::FETCH_OBJ);
    }
}
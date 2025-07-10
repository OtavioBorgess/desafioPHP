<?php

namespace App\Entity;

use App\Db\Database;
use PDO;

class Pedido
{
    public $id;
    public $idUsuario;
    public $idFeira;
    public $status;
    public $dataPedido;
    public $valorTotal;

    public function cadastrar()
    {
        $obDatabase = new Database('pedido');
        $this->id = $obDatabase->insert([
            'idUsuario' => $this->idUsuario,
            'idFeira' => $this->idFeira,
            'status' => $this->status,
            'dataPedido' => $this->dataPedido,
            'valorTotal' => $this->valorTotal
        ]);
        return true;
    }

    public function atualizar()
    {
        return (new Database('pedido'))
            ->update('id = ' . $this->id, [
                'valorTotal' => $this->valorTotal,
                'status' => $this->status
            ]);
    }

    public static function getPedidoExistente($idUsuario, $idFeira)
    {
        $db = new Database();
        $query = "
        SELECT *
        FROM pedido
        WHERE idUsuario = ? 
        AND idFeira = ?
        AND status != 'Cancelado'
    ";
        return $db->execute($query, [$idUsuario, $idFeira])
            ->fetchObject(self::class);
    }

    public static function getPedidosPorFeira($idUsuario, $idFeira)
    {
        $db = new Database();
        $query = "
        SELECT *
        FROM pedido
        WHERE idUsuario = ? 
        AND idFeira = ?
      
    ";
        return $db->execute($query, [$idUsuario, $idFeira])
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getPedido($id)
    {
        return (new Database('pedido'))->select('id = ' . $id)
            ->fetchObject(self::class);
    }

}
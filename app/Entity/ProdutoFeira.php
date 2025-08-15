<?php

    namespace App\Entity;

    use App\Db\Database;
    use PDO;


    class ProdutoFeira
    {
        public $id;
        public $idFeira;
        public $idProduto;

        public $preco;
        public $quantidade;


        public function cadastrar()
        {
            $obDatabase = new Database('produto_feira');
            $this->id = $obDatabase->insert([
                'idFeira' => $this->idFeira,
                'idProduto' => $this->idProduto,
                'preco' => $this->preco,
                'quantidade' => $this->quantidade
            ]);
            return true;
        }

        public function atualizar()
        {
            return (new Database('produto_feira'))
                ->update('id = ' . $this->id . ' AND ' . ' idFeira = ' . $this->idFeira . ' AND ' . ' idProduto = ' . $this->idProduto, [
                    'preco' => $this->preco,
                    'quantidade' => $this->quantidade,
                ]);
        }

        public function excluir()
        {
            return (new Database('produto_feira'))->delete('id = ' . $this->id);
        }

        public static function getProdutosDaFeira($idFeira)
        {
            $db = new Database();
            $query = "
        SELECT 
            pf.id,
            pf.idFeira,
            pf.idProduto,
            pf.preco,
            pf.quantidade,
            p.descricao,
            p.unidade
        FROM 
            produto_feira pf
        INNER JOIN 
            produto p ON pf.idProduto = p.id
        WHERE 
            pf.idFeira = ?
    ";
            return $db->execute($query, [$idFeira])
                ->fetchAll(PDO::FETCH_OBJ);
        }

        public static function getProdutosDaFeiraDoProdutor($idFeira, $idProduto)
        {
            $db = new Database();
            $query = "
        SELECT 
            pf.id,
            pf.idFeira,
            pf.idProduto,
            pf.preco,
            pf.quantidade,
            p.descricao,
            p.unidade
        FROM 
            produto_feira pf
        INNER JOIN 
            produto p ON pf.idProduto = p.id
        WHERE 
            pf.idFeira = ? AND p.idUsuario = ?
    ";
            return $db->execute($query, [$idFeira, $idProduto])
                ->fetchAll(PDO::FETCH_OBJ);
        }

        public static function getProdutoFeiraPorId($id)
        {
            $db = new Database();
            $query = "
        SELECT
            pf.id,
            pf.idFeira,
            pf.idProduto,
            pf.quantidade,
            pf.preco,
            p.descricao,
            p.unidade,
            p.estoque
        FROM 
            produto_feira pf
        INNER JOIN produto p ON p.id = pf.idProduto
        WHERE
            pf.id = ?
    ";
            return $db->execute($query, [$id])
                ->fetchObject(self::class);
        }

        public static function getProduto($idFeira, $idProduto)
        {
            $db = new Database();
            $query = "
            SELECT
                pf.id,
                pf.idFeira,
                pf.idProduto
            FROM 
                produto_feira pf
            WHERE
                pf.idFeira = ? AND pf.idProduto = ?
    ";
            return $db->execute($query, [$idFeira, $idProduto])
                ->fetchObject(self::class);
        }
    }
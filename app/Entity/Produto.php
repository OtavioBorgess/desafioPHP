<?php

    namespace App\Entity;

    use App\Db\Database;
    use PDO;

    class Produto
    {
        public $id;
        public $idUsuario;
        public $descricao;
        public $preco;
        public $unidade;
        public $estoque;

        public function cadastrar()
        {
            $obDatabase = new Database('produto');
            $this->id = $obDatabase->insert([
                'idUsuario' => $this->idUsuario,
                'descricao' => $this->descricao,
                'preco' => $this->preco,
                'unidade' => $this->unidade,
                'estoque' => $this->estoque
            ]);
        }

        public function atualizar()
        {
            return (new Database('produto'))
                ->update('id = ' . $this->id . ' AND ' . ' idUsuario = ' . $this->idUsuario, [
                    'descricao' => $this->descricao,
                    'preco' => $this->preco,
                    'unidade' => $this->unidade,
                    'estoque' => $this->estoque
                ]);
        }

        public function excluir()
        {
            return (new Database('produto'))->delete('id = ' . $this->id);
        }

        public static function getBuscaProduto()
        {
            session_start();
            $idUsuario = $_SESSION['idUsuario'];

            return (new Database('produto'))->select('idUsuario = ' . $idUsuario, 'descricao')
                ->fetchAll(PDO::FETCH_CLASS, self::class);
        }

        public static function getProduto($id)
        {
            return (new Database('produto'))->select('id = ' . $id, 'estoque')
                ->fetchObject(self::class);
        }
    }
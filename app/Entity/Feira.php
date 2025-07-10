<?php

    namespace App\Entity;

    use App\Db\Database;
    use PDO;

    class Feira
    {
        public $id;
        public $titulo;
        public $dataRealizacao;
        public $dataPrazo;
        public $descricao;
        public $local;

        public function cadastrar()
        {
            $obDatabase = new DataBase('feira');
            $this->id = $obDatabase->insert([
                'titulo' => $this->titulo,
                'dataRealizacao' => $this->dataRealizacao,
                'dataPrazo' => $this->dataPrazo,
                'descricao' => $this->descricao,
                'local' => $this->local
            ]);
            return true;
        }

        public function atualizar()
        {
            return (new Database('feira'))
                ->update('id = ' . $this->id, [
                    'titulo' => $this->titulo,
                    'dataRealizacao' => $this->dataRealizacao,
                    'dataPrazo' => $this->dataPrazo,
                    'descricao' => $this->descricao,
                    'local' => $this->local
                ]);
        }

        public function excluir()
        {
            return (new Database('feira'))->delete('id = ' . $this->id);
        }

        public static function getFeiras($where = null, $order = null, $limit = null)
        {
            return (new Database('feira'))->select($where, 'dataRealizacao DESC', $limit)
                ->fetchAll(PDO::FETCH_CLASS, self::class);
        }

        public static function getFeira($idFeira)
        {
            return (new Database('feira'))->select('id = ' . $idFeira)
                ->fetchObject(self::class);
        }
    }
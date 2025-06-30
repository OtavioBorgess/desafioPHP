<?php

    namespace App\Entity;

    use App\Db\Database;

    class Endereco
    {
        public $id;
        public $idUsuario;
        public $rua;
        public $numero;
        public $complemento;
        public $bairro;
        public $cep;
        public $cidade;
        public $estado;

        public function cadastrar()
        {
            $obDatabase = new Database('endereco');
            $this->id = $obDatabase->insert([
                'idUsuario' => $this->idUsuario,
                'rua' => $this->rua,
                'numero' => $this->numero,
                'complemento' => $this->complemento,
                'bairro' => $this->bairro,
                'cep' => $this->cep,
                'cidade' => $this->cidade,
                'estado' => $this->estado
            ]);
            return true;
        }

        public function atualizar()
        {
            return (new Database('endereco'))
                ->update('id = ' . $this->id . ' AND ' . ' idUsuario = ' . $this->idUsuario, [
                    'rua' => $this->rua,
                    'numero' => $this->numero,
                    'complemento' => $this->complemento,
                    'bairro' => $this->bairro,
                    'cep' => $this->cep,
                    'cidade' => $this->cidade,
                    'estado' => $this->estado
                ]);
        }

        public static function getEndereco()
        {
            $idUsuario = $_SESSION['idUsuario'];

            return (new Database('endereco'))->select('idUsuario = ' . $idUsuario)
                ->fetchObject(self::class);
        }

    }
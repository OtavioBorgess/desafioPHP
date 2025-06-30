<?php

    namespace App\Entity;

    require_once __DIR__ . '/../Db/Database.php';

    use App\Db\Database;
    use PDO;

    class Usuario
    {
        public $id;
        public $nome;

        public $email;

        public $senha;
        public $telefone;

        public $perfil;

        public function cadastrar()
        {
            $obDatabase = new DataBase('usuario');
            $this->id = $obDatabase->insert([
                'nome' => $this->nome,
                'email' => $this->email,
                'senha' => $this->senha,
                'perfil' => $this->perfil
            ]);
            return true;
        }

        public static function login($email)
        {
            return (new Database('usuario'))->select('email = ' . "'$email'")
                ->fetchObject(self::class);
        }

        public function editar()
        {
            return (new Database('usuario'))
                ->update('id = ' . $this->id, [
                    'nome' => $this->nome,
                    'email' => $this->email,
                    'telefone' => $this->telefone,
                ]);
        }

        public static function getUsuario()
        {
            session_start();
            $idUsuario = $_SESSION['idUsuario'];

            return (new Database('usuario'))->select('id = ' . $idUsuario)
                ->fetchObject(self::class);
        }

        public function alterarSenha()
        {
            return (new Database('usuario'))
                ->update('id = ' . $this->id, [
                    'senha' => $this->senha,
                ]);
        }

    }

<?php

namespace App\Models;

use MF\Model\Model;

class Usuario extends Model {

    private $id;
    private $nome;
    private $email;
    private $senha;

    public function __get($attr) {
        return $this->$attr;
    }

    public function __set($attr, $value) {
        $this->$attr = $value;
    }

    // Salvar
    public function salvar() {

        $query = '
            INSERT INTO
                usuarios(nome, email, senha) values (:nome, :email, :senha)
        ';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha')); //md5() -> hash de 32 carac
        $stmt->execute();

        return $this;

    }

    // Realizar validação para verificar se um cadastro pode ser feito
    public function validarCadastro() {
        $valido = true;

        if(strlen($this->__get('nome')) < 3) {
            $valido = false;
        }

        if(strlen($this->__get('email')) < 2) {
            $valido = false;
        }

        if(strlen($this->__get('senha')) < 2) {
            $valido = false;
        }

        return $valido;
    }

    // Recuperar um usuário por e-mail
    public function getUsuarioPorEmail() {

        $query = '
            SELECT
                nome, email
            FROM
                usuarios
            WHERE
                email = :email
        ';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function autenticar() {

        $query = '
            SELECT
                id, nome, email
            FROM
                usuarios
            WHERE
                email = :email
                AND senha = :senha
        ';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($usuario['id'] != '' && $usuario['nome'] != '') {

            $this->__set('id', $usuario['id']);
            $this->__set('nome', $usuario['nome']);


        }

        return $this;

    }

    public function getAll() {

        $query = "
            SELECT
                u.id, u.nome, u.email, (
                    SELECT
                        COUNT(*)
                    FROM
                        usuarios_seguidores as us
                    WHERE
                        us.id_usuario = :id_usuario
                        AND us.id_usuario_seguindo = u.id
                ) as seguindo_sn
            FROM
                usuarios AS u
            WHERE
                nome like :nome
                AND id != :id_usuario
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', '%' . $this->__get('nome') . '%');
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Informações do usuário
    public function getInfoUsuario() {

        $query = "
            SELECT
                nome
            FROM
                usuarios
            WHERE
                id = :id_usuario
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Total de tweets
    public function getTotalTweetsUsuario() {

        $query = "
            SELECT
                COUNT(*) AS total_tweets
            FROM
                tweets
            WHERE
                id_usuario = :id_usuario
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

    // Total de pessoas que segue
    public function getTotalSeguindo() {

        $query = "
            SELECT
                COUNT(*) AS total_seguindo
            FROM
                usuarios_seguidores
            WHERE
                id_usuario = :id_usuario
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

    // Total de seguidores que tem
    public function getTotalSeguidores() {

        $query = "
            SELECT
                COUNT(*) AS total_seguidores
            FROM
                usuarios_seguidores
            WHERE
                id_usuario_seguindo = :id_usuario                
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

}

?>
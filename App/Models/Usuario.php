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

}

?>
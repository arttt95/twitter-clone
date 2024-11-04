<?php

namespace App\Models;

use MF\Model\Model;

class UsuariosSeguidores extends Model {

    private $id_usuario;
    private $id_usuario_seguindo;
    private $acao;

    public function __get($attr) {
        return $this->$attr;
    }

    public function __set($attr, $value) {
        $this->$attr = $value;
    }

    // Seguir
    public function seguir($id_usuario_seguindo) {

        $query = "
            INSERT INTO
                usuarios_seguidores(
                    id_usuario, id_usuario_seguindo
                ) values(
                    :id_usuario, :id_usuario_seguindo
                )
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
        $stmt->execute();

        return true;

    }

    // Deixar de seguir
    public function deixarDeSeguir($id_usuario_seguindo) {

        $query = "
            DELETE FROM
                usuarios_seguidores
            WHERE
                id_usuario = :id_usuario
                AND id_usuario_seguindo = :id_usuario_seguindo
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
        $stmt->execute();

        return true;

    }

}
<?php

namespace App\Controllers;

// Recursos
use MF\Controller\Action;
use MF\Model\Container;

// Models

class AuthController extends Action {

    public function autenticar() {
        
        $usuario = Container::getModel('Usuario');

        $usuario->__set('email', $_POST['email']);
        $usuario->__set('senha', $_POST['senha']);

        /*
        echo '<pre>';
        print_r($usuario);
        echo '</pre>';
        */

        $usuario->autenticar();

        if($usuario->__get('id') != '' && $usuario->__get('nome') != '') {

            //echo 'Autenticado!';

            session_start();

            $_SESSION['id'] = $usuario->__get('id');
            $_SESSION['nome'] = $usuario->__get('nome');

            header('location: /timeline');

        } else {

            header('location: /?login=erro');

        }

        /*
        echo '<pre>';
        print_r($usuario);
        echo '</pre>';
        */
        
    }

    public function sair() {

        session_start();

        session_destroy();

        header('location: /');

    }

}

?>
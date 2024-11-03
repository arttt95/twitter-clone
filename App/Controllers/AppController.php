<?php

namespace App\Controllers;

// Recursos
use MF\Controller\Action;
use MF\Model\Container;

// Models


class AppController extends Action {

    public function validarAutenticacao() {

        session_start();

        if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {

            header('location: /?login=expirado');

        } else {

            /*
            echo 'Chegamos em timeline';
        
            echo '<pre>';
            print_r($_SESSION);
            echo '</pre>';
            */

            return true;

        }

    }

    public function timeline() {

        $this->validarAutenticacao();

        // Recuperar tweets

        $tweet = Container::getModel('Tweet');

        $tweet->__set('id_usuario', $_SESSION['id']);

        $tweets = $tweet->getAll();

        /*
        echo '<pre>';
        print_r($tweets);
        echo '</pre>';
        */

        $this->view->tweets = $tweets;

        $this->render('timeline');

    }

    public function tweet() {

        $this->validarAutenticacao();

        $tweet = Container::getModel('Tweet');

        $tweet->__set('tweet', $_POST['tweet']);
        $tweet->__set('id_usuario', $_SESSION['id']);

        $tweet->salvar();

        header('location: /timeline');

        

    }

}

?>
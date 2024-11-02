<?php

namespace App\Controllers;

// Recursos
use MF\Controller\Action;
use MF\Model\Container;

// Models


class AppController extends Action {

    public function timeline() {

        session_start();

        if($_SESSION['id'] != '' && $_SESSION['nome'] != '') {

            /*
            echo 'Chegamos em timeline';
        
            echo '<pre>';
            print_r($_SESSION);
            echo '</pre>';
            */

            $this->render('timeline');

        } else {

            header('location: /?login=expirado');

        }

    }

}

?>
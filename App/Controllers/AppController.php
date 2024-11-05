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

            exit;

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

        $usuario = Container::getModel('Usuario');

        $usuario->__set('id', $_SESSION['id']);

        $this->view->info_usuario = $usuario->getInfoUsuario();
        $this->view->total_tweets = $usuario->getTotalTweetsUsuario();
        $this->view->total_seguindo = $usuario->getTotalSeguindo();
        $this->view->total_seguidores = $usuario->getTotalSeguidores();
        
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

    public function quemSeguir() {

        $this->validarAutenticacao();

        //echo '<br><br><br><br>';

        ///////////////////////////
        //  Criando um arr para  //
        //  encapsular a lista   //
        //   de usuários (db)    //
        ///////////////////////////

        $pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';
        //echo 'Pesquisando por: ' . $pesquisarPor;

        $usuarios = [];

        if($pesquisarPor != '') {
            
            $usuario = Container::getModel('Usuario');
            $usuario->__set('nome', $pesquisarPor);
            $usuario->__set('id', $_SESSION['id']);
            $usuarios = $usuario->getAll();

            /*
            echo '<br><br>';
            echo $_SESSION['id'];
            */

            /*
            echo '<pre>';
            print_r($usuarios);
            echo '</pre>';
            */

        }

        $this->view->usuarios = $usuarios;

        ////////////////////////////
        //  Comunicando com o db  //
        //   para obter infos     //
        //   tweets, seguidores,  //
        //       e seguindo       //
        ////////////////////////////

        
        $usuario = Container::getModel('Usuario');

        $usuario->__set('id', $_SESSION['id']);

        $this->view->info_usuario = $usuario->getInfoUsuario();
        $this->view->total_tweets = $usuario->getTotalTweetsUsuario();
        $this->view->total_seguindo = $usuario->getTotalSeguindo();
        $this->view->total_seguidores = $usuario->getTotalSeguidores();

        $this->render('quemSeguir');

    }

    public function acao() {

        $this->validarAutenticacao();

        // Descobrir qual é a ação
        // Descobri o id do user que será seguido pelo user que está autenticado

        /*
        echo '<br><br><br>';

        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';

        echo '<pre>';
        print_r($_GET);
        echo '</pre>';
        */

        $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
        $id_usuario_seguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';

        $usuario_seguidor = Container::getModel('UsuariosSeguidores');

        $usuario_seguidor->__set('id_usuario', $_SESSION['id']);

        if($acao == 'seguir') {

            $usuario_seguidor->seguir($id_usuario_seguindo);

        } else if ($acao == 'deixar_de_seguir') {

            $usuario_seguidor->deixarDeSeguir($id_usuario_seguindo);

        }

        header('location: /quem_seguir');

        /*
        Array
        (
            [acao] => seguir
            [id_usuario] => 1
        )
        */

    }

}

?>
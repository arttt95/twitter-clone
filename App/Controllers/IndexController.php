<?php

namespace App\Controllers;

// Recursos
use MF\Controller\Action;
use MF\Model\Container;

// Models


class IndexController extends Action {

    public function index() {

        $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';

        $this->render('index');

    }

    public function inscreverse() {

        $this->view->usuario = [
            'nome' => $_POST[''],
            'email' => $_POST[''],
            'senha' => $_POST['']
        ];

        $this->view->erroCadastro = false;

        $this->render('inscreverse');

    }

    public function registrar() {

        /*  echo '<pre>';
            print_r($_POST);
            echo '</pre>';    */

        // Receber os dados do formulário
        $usuario = Container::getModel('Usuario');

        $usuario->__set('nome', $_POST['nome']);
        $usuario->__set('email', $_POST['email']);
        $usuario->__set('senha', md5($_POST['senha']));

        /*  echo '<pre>';
            print_r($usuario);
            echo '</pre>';    */

        if($usuario->validarCadastro() && count($usuario->getUsuarioPorEmail()) == 0) { //Sucesso

            $usuario->salvar();

            $this->render('cadastro');

        } else { // Erro

            $this->view->usuario = [
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'senha' => $_POST['senha']
            ];

            $this->view->erroCadastro = true;
            
            $this->render('inscreverse');

        }
        
    }

}



?>
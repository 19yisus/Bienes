<?php

  if(isset($_GET['A'])){

    switch($_GET['A']){
      case 'Login':
        echo 'Login';
        
      break;

      case 'Logout':
        echo 'Logout';
      break;

      default:
        echo 'Accion por defecto';
      break;
    }
  }
  class Login extends Controller{
    public function __construct(){
      parent::__construct('Login');
    }

    public function Login(){
      echo '<br>hola desde controlador';
    }
  }
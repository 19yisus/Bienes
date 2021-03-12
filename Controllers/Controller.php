<?php
  abstract class Controller{
    protected $modelo;

    public function __construct($name){
      $this->modelo = $this->PrepareModel($name);
    }

    private function PrepareModel($controller){

      $rutaModel = "./Models/Cls$controller.php";

      if(file_exists($rutaModel)){
        require_once $rutaModel;
        $NameModel = 'Cls'.$controller;
        return new $NameModel();
      }
    }

    protected function PJSON($json){
      print json_encode($json);
    }

    protected function Post($name = []){
      foreach( $name as $param){
          if(!isset($_POST[$param])){
            return false;
          }
      }
      return true;
    }

    public function permisos(){
      return $this->PJSON($this->modelo->session->GetDatos('permisos'));
    }

    protected function GetPost($name){
      return isset($_POST[$name]) ? $_POST[$name] : false;
    }

    public function fecha(){
      setlocale(LC_ALL,"es_ES");
      date_default_timezone_set("America/Caracas");
      $fecha = date('Y-m-d');

      return $fecha;
    }

    public function Year(){
      setlocale(LC_ALL,"es_ES");
      date_default_timezone_set("America/Caracas");
      $fecha = date('Y');

      return $fecha;
    }
  }

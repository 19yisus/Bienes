<?php 

  abstract class DB{
    private $host, $dbname, $user, $pass, $charset;
    public function __construct(){
      $this->host = constant('HOST');
      $this->dbname = constant('DBNAME');
      $this->charset = constant('CHARSET');
      $this->user = constant('USER');
      $this->pass = constant('PASS');
    }

    Protected function Conectar(){
      try{

        if(constant('DBHOST') == 'mysql'){
          $conexion = "mysql:host=$this->host;dbname=$this->dbname;charset=$this->charset";
        }else if(constant('DBHOST') == 'pgsql'){
          $conexion = "mysql:host=$this->host;dbname=$this->dbname";
        }
        
        $option = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false];
        $pdo = new PDO($conexion,$this->user,$this->pass,$option);
        return $pdo;

      }catch(PDOException $e){
          print_r("Error connection :".$e->Getmessage());
      }
    }
  }
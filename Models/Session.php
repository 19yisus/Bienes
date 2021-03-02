<?php
  session_start();

  class Session{
    public function __constuct(){
      $_SESSION['user'] = null;
    }

    public function IfSession(){
      if(isset($_SESSION['user']['user_id'])){
        return true;
      }
      return false;
    }

    public function SetDatos($array = []){
      $_SESSION['user']['user_id'] = $array['id'];
      $_SESSION['user']['user_name'] = $array['name'];
      $_SESSION['user']['photo'] = $array['photo'];
      $_SESSION['user']['user_rol'] = $array['permisos'];
      
      return $this->IfSession();
    }

    public function GetDatos($key = ''){
      if(isset($_SESSION['user'])) return isset($key) && $key != '' ? $_SESSION['user'][$key] : $_SESSION['user'];
    }

    public function Logout(){
      session_destroy();
      session_unset();
    }
  }

<?php
  require_once './Models/Config.php';
  require_once './Models/Db.php';
  require_once './Models/Model.php';
  require_once './Models/Session.php';
  require_once './Views/View.php';
  require_once './Controllers/Controller.php';
  
  error_reporting(E_ALL);
  ini_set('ignore_repeated_errors',TRUE);
  ini_set('display_errors',FALSE);
  ini_set('log_errors',TRUE);
  ini_set("error_log","./php-error.log");
  error_log("Inicio de la aplicacion");
  
  class App extends Model{
    
    public function __construct(){
      parent::__construct();
      $request = $this->RequestGetURL();
      $this->RequestController($request);
      $this->view->RenderView($request[0].'/'.$request[1]);
    }

    /**
     * Request de la consulta al servidor
     * @return ruta
     */
    private function RequestGetURL(){
      $url = isset($_GET['url']) ? $_GET['url'] : '';
      $url = rtrim($url,'/');
      $url = explode('/',$url);

      if(!isset($url[0]) || $url[0] == '' ){
        
        if(!$this->session->IfSession()){
          $url[0] = 'Login';
        }else{
          $url [0] = 'Home';
        }
      }

      $url[1] = isset($url[1]) ? $url[1] : 'Vis_Index';
      
      if($url[1] == 'Logout'){
        $this->session->logout();
        $this->view->Redirect();
      }

      return $url;
    }

    private function RequestController($request){

      if(strpos($request[0],'Controller') !== false){

        $Controller = './Controllers/'.$request[0].'.php';
        
        if(file_exists($Controller)){  
          require_once $Controller;
          $control = new $request[0]();
          
          if(method_exists($control, $request[1])){
            
            if(isset($request[2])){
              
              $param = [];
              for ($i = 2; $i < sizeof($request); $i++){
                array_push($param, $request[$i]);
              }

              $control->{$request[1]}($param);
            }else{
              $control->{$request[1]}();
            }
          }
        }
      }  
    }
  }

  $app = new App();
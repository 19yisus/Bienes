<?php
  class View extends Session{
    /**
     * RenderView()
     * @param string name view
     * @return file.php
     */
    public function RenderView($ruta){
      
      if(strpos($ruta,'Vis') !== false){
        $File = './Views/Contents/'.$ruta.'.php';
        
        if(file_exists($File)){  
          require_once $File;
        }else{
          $this->Redirect('');
        }
      }     
    }
    private function Control($name){
      require_once "./Controllers/$name.php";
      return new $name();
    }
    /**
     * Redirect()
     * @param string ruta
     * @return header()
     */
    public function Redirect($ruta = ''){
      header('Location: '. constant('URL') . $ruta );
    }

    private function Headers($title = ''){
      require_once './Views/Includes/Header.php';
    }

    private function Nav(){
      require_once './Views/Includes/Nav.php';
    }

    private function Wraper($vista, $ruta){
      require_once './Views/Includes/WraperHeader.php';
    }
    private function Scripts($nameController = ''){
      require_once './Views/Includes/Scripts.php';
    }
    private function Catalogo(){
      require_once './Views/Includes/Catalogo.php';
    }
    /**
     * Footer()
     * @param string $nameController
     * @return Footer.php
     * @return Modal.php
     * @return Scripts.php (jquery, sweetAlert2, .Js)
     */
    private function Footer($nameController = ''){
      // Footer
      require_once './Views/Includes/Footer.php';
      
      if($nameController != ''){
        // Especific modal edit
        $url = "./Views/Contents/$nameController/ModalEdit.php";

        if(file_exists($url)){
          require_once $url;
        }
      }
      $this->Scripts($nameController);
      require_once './Views/Includes/Modal.php';
    }
    /**
     * Exit
     * @return redirect to login page
     */
    private function Exit(){
      if(!$this->IfSession()){
        $this->Redirect('Login');
      }
    }
  }

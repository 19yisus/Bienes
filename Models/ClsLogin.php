<?php
  class ClsLogin extends Model{
    // private $name, $lastname, $email, $password, $password_repeat, $photo, $rol, $created, $updated, $deleted;
    private $user_id, $user_pass, $user_name, $user_state, $user_rol, $pg1, $pg2, $rp1, $rp2;
    
    public function __construct(){
      parent::__construct();
    }

    public function SetDatos(){
      $this->user_cedula = isset($_POST['User']) ? $_POST['User'] : null;
      $this->name = isset($_POST['Name']) ? $_POST['Name'] : null;
      // $this->email = isset($_POST['Email']) ? $_POST['Email'] : null;
      $this->password = isset($_POST['Password']) ? $_POST['Password'] : null;
      $this->password_repeat = isset($_POST['PasswordRepeat']) ? $_POST['PasswordRepeat'] : null;
      $this->photo = isset($_POST['photo']) ? $_POST['photo'] : "Img/Default/User.png";
    }

    public function Login(){

      if(!is_null($this->user_cedula) || !is_null($this->password)){

        $con = $this->Query("SELECT * FROM usuarios WHERE user_cedula = '$this->user_cedula';")->fetch(PDO::FETCH_ASSOC);
        if(is_array($con) && count($con) > 0){

          if($con['user_estado'] == 1 ){
            $this->validaFailsPassword();
            
            if(password_verify($this->password, $con['user_clave'])){
              $con2 = $this->Prepare("SELECT * FROM roles WHERE roles_id = :role_id;");
              $con2 ->bindParam(":role_id",$con['user_role_id']);
              $con2 ->execute();
              $permisos = $con2->fetch(PDO::FETCH_ASSOC);
                
              $datos = [
                'id' => $con['user_cedula'],
                'name' => $con['user_nombre'],
                'permisos' => $permisos,
                'photo' => $con['user_photo']
              ];

              setcookie("failPassword", '', time() - 3600);

              if($this->session->SetDatos($datos)){ $this->view->Redirect('Home'); }
            }else{
              $this->validaFailsPassword();
            }
          }else{
            $this->view->Redirect('Login?m=3');
          }
        }else{
          $this->view->Redirect('Login?m=2');
        }
      }else{
        $this->view->Redirect('Login?m=1');
      }
    }

    private function validaFailsPassword(){
      if(isset($_COOKIE["failPassword"])){$fail = $_COOKIE["failPassword"]; setcookie("failPassword",$fail+1, time() + 3600);}else{ setcookie("failPassword",1, time() + 3600);}
      if(isset($_COOKIE['failPassword'])){ if($_COOKIE['failPassword'] > 3){ setcookie("failPassword", '', time() - 3600); }}

      if(isset($_COOKIE['failPassword'])){
        if($_COOKIE['failPassword'] == 3){
          setcookie("failPassword", '', time() - 3600);
          $this->Query("UPDATE usuarios SET user_estado = false where user_cedula = $this->user_cedula AND user_role_id != 4;");
          $this->view->Redirect("Login?m=5");
        }else{
          $this->view->Redirect("Login?m=4");
        }
      }
    }

    public function Register(){

      if(!is_null($this->name) || !is_null($this->email) || !is_null($this->password) || !is_null($this->password_repeat)){
        if($this->password == $this->password_repeat){

          $con = $this->Prepare("INSERT INTO users(user_cedula,user_name,user_lastname,user_photo,user_email,user_pass,user_rol_id,
            user_fecha_created,user_fecha_modified,user_fecha_deleted,user_state)
            VALUES(null,:Nombre,:Apellido,:Photo,:Email,:Pass,:rol,:created,null,null,'1');");

          $con->bindParam(":Nombre", $this->name);
          $con->bindParam(":Apellido", $this->lastname);
          $con->bindParam(":Photo", $this->photo);
          $con->bindParam(":Email", $this->email);
          $con->bindParam(":Pass", $this->Encript($this->password));
          $con->bindParam(":rol", $this->rol);
          $con->bindParam(":created", $this->created);

          $this->Exec($con);

          $this->Login();
        }else{
          $this->view->Redirect('Login/Vis_Register?m=2');
        }
      }else{
        $this->view->Redirect('Login/Vis_Register?m=1');
      }

    }
  }

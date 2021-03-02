<?php
  class ClsLogin extends Model{
    // private $name, $lastname, $email, $password, $password_repeat, $photo, $rol, $created, $updated, $deleted;
    private $user_id, $user_pass, $user_name, $user_state, $user_rol, $pg1, $pg2, $rp1, $rp2;

    public function __construct(){
      parent::__construct();
    }

    public function SetDatos(){
      $this->user_id = isset($_POST['User']) ? $_POST['User'] : null;
      $this->name = isset($_POST['Name']) ? $_POST['Name'] : null;
      // $this->email = isset($_POST['Email']) ? $_POST['Email'] : null;
      $this->password = isset($_POST['Password']) ? $_POST['Password'] : null;
      $this->password_repeat = isset($_POST['PasswordRepeat']) ? $_POST['PasswordRepeat'] : null;
      $this->photo = isset($_POST['photo']) ? $_POST['photo'] : "Views/Img/Default/User.png";
      $this->rol = 1;
    }

    public function Login(){

      if(!is_null($this->user_id) || !is_null($this->password)){

        $con = $this->Query("SELECT * FROM usuarios WHERE user_id = '$this->user_id';")->fetch(PDO::FETCH_ASSOC);
        if(is_array($con) && count($con) > 0){

          if($con['user_estado'] == 1){

            if(password_verify($this->password, $con['user_clave'])){
                
                $datos = [
                  'id' => $con['user_id'],
                  'name' => $con['user_nombre'],
                  'permisos' => $con['user_permisos'],
                  'photo' => $con['user_photo']
                ];

              if($this->session->SetDatos($datos)){ $this->view->Redirect('Home'); } else{ $this->view->Redirect('Login?m=5'); }
            }else{
              $this->view->Redirect('Login?m=4');
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

    public function Register(){

      if(!is_null($this->name) || !is_null($this->email) || !is_null($this->password) || !is_null($this->password_repeat)){
        if($this->password == $this->password_repeat){

          $con = $this->Prepare("INSERT INTO users(user_id,user_name,user_lastname,user_photo,user_email,user_pass,user_rol_id,
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

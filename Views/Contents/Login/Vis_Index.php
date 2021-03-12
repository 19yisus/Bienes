<?php
  $this->Headers('Login');

  if(isset($_POST['User']) && $_POST['User'] != '' && isset($_POST['Password']) && $_POST['Password'] != ''){
    require './Models/ClsLogin.php';
    $mod = new ClsLogin();
    $mod->SetDatos();
    $mod->Login();
  }
  
?>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="./" class="h1"><b><?php echo constant('App_name')[0];?></b><?php echo constant('App_name')[1];?></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Inicio de sesion</p>
      <form action="./" method="post" name="formulario">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Usuario" pattern="[0-9]{7,8}" name="User" id="User" title="Solo se permiten numeros" autocofus required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Clave" name="Password" id="Pass" title="Ingrese una contraseña valida al menos de 8 caracteres, con mayusculas, minusculas y numeros" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-7">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Recuerda me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-5">
            <button type="submit" value="loguear" name="action" class="btn btn-primary btn-block">Iniciar Sesion</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="<?php echo constant('URL');?>Login/Vis_ForgotPassword">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="<?php echo constant('URL');?>Login/Vis_Register" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
<?php $this->Scripts();?>
<!-- REQUIRED SCRIPTS -->
<script>
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
</script>
<?php
  if(isset($_COOKIE['failPassword']) ){
    ?>
    <script>
      Toast.fire({
        icon: 'warning',
        title: 'Te queda n intentos antes de que tu usuario sea bloqueado!.'
      })
    </script>
    <?php
  }
  if(isset($_GET['m'])){
    switch($_GET['m']){
      case '1':
        ?>
        <script>
          Toast.fire({
            icon: 'warning',
            title: 'Los campos estan vacios!.'
          })
        </script>
        <?php
      break;

      case '2':
        ?>
        <script>
          Toast.fire({
            icon: 'warning',
            title: ' No se ha encontrado el usuario!.'
          })
        </script>
        <?php
      break;

      case '3':
        ?>
        <script>
          Toast.fire({
            icon: 'warning',
            title: ' usuario innactivo o bloqueado!.'
          })
        </script>
        <?php
      break;

      case '4':
        ?>
        <script>
          Toast.fire({
            icon: 'warning',
            title: 'La clave es incorrecta!.'
          })
        </script>
        <?php
      break;

      case '5':
        ?>
        <script>
          Toast.fire({
            icon: 'warning',
            title: 'Tu usuario ha sido suspendido!.'
          })
        </script>
        <?php
      break;
    }
  }
?>
</body>
</html>

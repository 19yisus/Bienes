<?php $this->Headers(); $this->Exit(); ?>
<body class="hold-transition sidebar-mini">
	<div class="wrapper">
  <?php $this->Nav();?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php $this->Wraper('Catalogo','Personas');?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <!-- row start -->
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Registro</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" name="formulario" id="formulario" method="POST" action="#" autocomplete="off"  class="needs-validation" novalidate>
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="">Cedula</label><label for="" id="ob">*</label>
                      <input type="text" pattern="[0-9]{7,8}" title="Solo se aceptan numeros" name="Cod" id="Cod" class="form-control" placeholder="Cedula" maxlength="8" minlength="7" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="">Nombre</label><label for="" id="ob">*</label>
                      <input type="text" pattern="[A-Za-z ]{4,60}" name="Nom" id="Nom" class="form-control" placeholder="Nombre" maxlength="60" minlength="4" style="text-transform: uppercase;" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="">Apellido</label><label for="" id="ob">*</label>
                      <input type="text" pattern="[A-Za-z ]{4,60}" name="Ape" id="Ape" class="form-control" placeholder="Apellido" maxlength="60" minlength="4" style="text-transform: uppercase;" required>
                    </div>
                  </div>
                  <div class="row">
										<div class="form-group col-md-3">
		                  <label>Telefono</label><label for="" id="ob">*</label>
		                  <div class="input-group">
		                    <div class="input-group-prepend">
		                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
		                    </div>
                        <input type="text" name="Tel" id="Tel" maxlength="15" minlength="15" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(9999) 999-9999&quot;" title="Ingresar numero de telefono omitiendo el cero inicial" data-mask="" required>
		                  </div>
		                  <!-- /.input group -->
		                </div>
                    <div class="form-group col-md-4">
                      <label for="">Cargo</label><label for="" id="ob">*</label>
                      <select name="Cargo" id="Cargo" class="form-control select2bs4 select2-hidden-accessible" required>
                      <?php echo $this->Control('PersonasController')->SelectCargos(); ?>
                      </select>
                    </div>
                    <div class="form-group col-md-5">
                      <label for="">Dependencia</label><label for="" id="ob">*</label>
                      <select name="Dep" id="Dep" class="form-control select2 select2-hidden-accessible" required>
                      <?php echo $this->Control('PersonasController')->SelectDeps(); ?>
                      </select>
                    </div>
                  </div>
									<div class="row">
										<div class="form-group col-md-4">
											<label for="">Correo</label><label for="" id="ob">*</label>
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text"> <i class="fas fa-envelope"></i> </span>
												</div>
												<input type="email" name="Email" id="Email" class="form-control" placeholder="Correo Electronico" maxlength="120" minlength="10" style="text-transform: uppercase;" required>
											</div>
										</div>
										<div class="form-group col-md-4">
                      <label for="">Fecha del cargo</label><label for="" id="ob">*</label>
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="date" class="form-control" name="Fecha" max="<?php echo $this->Control('PersonasController')->FechaActual(); ?>" min="2000-12-31" id="Fecha" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" title="Ingrese una fecha valida" required>
                        </div>
                        <!-- /.input group -->
                      </div>
                    </div>
										<div class="form-group col-md-4">
											<label for="">Direccion</label><label for="" id="ob">*</label>
											<textarea name="Dir" id="Dir" cols="30" rows="1" class="form-control" placeholder="Direccion" maxlength="60" minlength="10" style="text-transform: uppercase;" required></textarea>
										</div>
									</div>
                  <div class="row card-footer">
                    <div class="col-md-12 text-center">
                      <div class="btn-group ">
                        <button type="button" id="btnAdd" data-formulario="formulario" value="Insert" class="btn btn-success" title="Guardar"> 
                          <i class="fas fa-save"></i> Registrar
                        </button>
                        <button type="reset" class="btn btn-danger">  Limpiar</button>
                        <button type="button" class="btn btn-primary" onclick="Paginador('PersonasController',1)" data-toggle="modal" data-target="#ModalListar"> 
                            <i class="fas fa-search" ></i> Listar
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </form>
              <!-- ./form end -->
            </div>
          </div>
        </div>
        <!-- ./row end -->
      </div>
    </div>
  <!-- /.content-wrapper -->
</div>
<?php $this->Footer('Personas'); ?>
<script src="<?php echo constant('URL');?>Views/Js/GLOBAL.js"></script>
<script src="<?php echo constant('URL');?>Views/Assets/plugins/inputmask/inputmask.js"></script>
<script src="<?php echo constant('URL');?>Views/Assets/plugins/inputmask/jquery.inputmask.js"></script>
</body>
</html>




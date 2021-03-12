<?php $this->Headers(); $this->Exit(); ?>
<body class="hold-transition sidebar-mini">
	<div class="wrapper">
  <?php $this->Nav();?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php $this->Wraper('Catalogo','Clasificacion','Registro de Clasificaciones');?>
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
                    <div class="form-group col-md-3">
                      <label for="">Codigo</label><label for="" id="ob">*</label>
                      <input type="text" name="Cod" id="Cod" pattern="[0-9]{2}" class="form-control" placeholder="Codigo" maxlength="2" minlength="2" required>
                    </div>
                    <div class="form-group col-md-5">
                      <label for="">Descripcion</label><label for="" id="ob">*</label>
                      <input type="text" name="Des" id="Des" pattern="[A-Za-z ]{4,20}" class="form-control" placeholder="Descripcion" minlength="4" maxlength="20" style="text-transform: uppercase;" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="">Categoria</label><label for="" id="ob">*</label>
                      <select name="Tip" id="Tip" class="custom-select" required>
                        <?php echo $this->Control('ClasificacionController')->SelectCategoria();?>
                      </select>
                    </div>
                  </div>
                  <div class="row card-footer">
                    <div class="col-md-12 text-center">
                      <div class="btn-group ">
                        <button type="button" id="btnAdd" data-formulario="formulario" value="Insert" class="btn btn-success" title="Guardar"> 
                          <i class="fas fa-save"></i> Registrar
                        </button>
                        <button type="reset" class="btn btn-danger">  Limpiar</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalCatalogo"> 
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
<?php $this->Footer('Clasificacion'); ?>
<script src="<?php echo constant('URL');?>Views/Js/GLOBAL.js"></script>
</body>
</html>


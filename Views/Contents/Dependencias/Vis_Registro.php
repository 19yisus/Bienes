<?php $this->Headers(); $this->Exit(); ?>
<body class="hold-transition sidebar-mini">
	<div class="wrapper">
  <?php $this->Nav();?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php $this->Wraper('Catalogo','Dependencias','Registro de dependencia');?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <!-- row start -->
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary" id="caja">
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
                      <input type="text" name="Cod" id="Cod" pattern="[0-9]{1,2}" minlength="1" maxlength="2" class="form-control" placeholder="Codigo" readonly>
                    </div>
                    <div class="form-group col-md-5">
                      <label for="">Descripcion</label><label for="" id="ob">*</label>
                      <input type="text" name="Des" id="Des" class="form-control" pattern="[A-Za-z ]{4,30}" placeholder="Descripcion" style="text-transform: uppercase;" minlength="4" maxlength="30" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="">Pertenece a</label><label for="" id="ob">*</label>
                      <select name="Nu" id="Nu" class="form-control select2bs4 select2-hidden-accessible" required>
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
<?php $this->Footer('Dependencias'); ?>
<script src="<?php echo constant('URL');?>Views/Js/GLOBAL.js"></script>
<script>
  SelectNucleos();
  ShowCodigo_incrementado('<?php echo constant('URL').'DependenciasController'?>',document.formulario.Cod)
  document.formulario.addEventListener('reset', ()=>{
    ShowCodigo_incrementado('<?php echo constant('URL').'DependenciasController'?>',document.formulario.Cod);
  });
  Isthereprincipal();
</script>
</body>
</html>


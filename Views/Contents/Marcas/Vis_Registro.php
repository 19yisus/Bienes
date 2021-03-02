<?php $this->Headers(); $this->Exit(); ?>
<body class="hold-transition sidebar-mini">
	<div class="wrapper">
  <?php $this->Nav();?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php $this->Wraper('Catalogo','Marcas');?>
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
              <form role="form" name="formulario" id="formulario" method="POST" action="#" autocomplete="off" class="needs-validation" novalidate>
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="">Codigo</label><label for="" id="ob">*</label>
                      <input type="text" name="Cod" id="Cod" class="form-control" placeholder="Codigo" minlength="1" maxlength="2" readonly>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="">Descripcion</label><label for="" id="ob">*</label>
                      <input type="text" pattern="[A-Za-z ]{2,30}" name="Marca" id="Des" class="form-control" placeholder="Descripcion" minlength="2" maxlength="30" style="text-transform: uppercase;" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="">Categoria</label><label for="" id="ob">*</label>
                      <select name="Tip" id="Tip" class="custom-select" required>
                      <?php echo $this->Control('MarcasController')->SelectCategoria(); ?>
                      </select>
                    </div>
                  </div>
                  <div class="row card-footer">
                    <div class="col-md-12 text-center">
                      <div class="btn-group ">
                        <button type="button" id="btnAdd" data-formulario="formulario" value="Insert" class="btn btn-success" title="Guardar"> 
                          <i class="fas fa-save"></i> Registrar
                        </button>
                        <!-- <button type="submit" id="btnDel" onclick="btn(this);" value="Delete" class="btn btn-warning" title="Este boton no esta disponible para esta operacion" disabled> 
                            <i class="fas fa-trash"></i> Desactivar
                        </button> -->
                        <button type="reset" class="btn btn-danger">  Limpiar</button>
                        <button type="button" class="btn btn-primary" onclick="Paginador('MarcasController',1)" data-toggle="modal" data-target="#ModalListar"> 
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
<?php $this->Footer('Marcas'); ?>
<script src="<?php echo constant('URL');?>Views/Js/GLOBAL.js"></script>
<script>
  ShowCodigo_incrementado('<?php echo constant('URL').'MarcasController'?>',document.formulario.Cod)
</script>
</body>
</html>


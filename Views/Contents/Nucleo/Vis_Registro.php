<?php $this->Headers(); $this->Exit(); ?>
<body class="hold-transition sidebar-mini">
	<div class="wrapper">
  <?php $this->Nav();?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php $this->Wraper('Catalogo','Nucleo');?>
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
                    <div class="form-group col-md-3">
                      <label for="">Codigo</label><label for="" class="" id="ob">*</label>
                      <input type="text" name="Cod" pattern="[0-9]{2}" minlength="1" maxlength="2" id="Cod" class="form-control" placeholder="Codigo" disabled readonly>
                    </div>
                    <div class="form-group col-md-7">
                      <label for="Descripcion del nucleo">Descripcion</label><label for="" id="ob">*</label>
                      <input type="text" class="form-control" id="Des" name="Des" pattern="[A-Za-z ]{4,30}" placeholder="Descripcion" style="text-transform: uppercase;" autofocus minlength="4" maxlength="30" required>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="CodigoPostal">Codigo Postal</label><label for="" id="ob">*</label>
                      <input type="text" class="form-control" id="CP" name="CP" pattern="[0-9]+" placeholder="Codigo Postal" maxlength="4" minlength="4" pattern="[0-9]+" title="Solo se aceptan numeros" required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-7">
                      <label for="Direccion">Direccion</label><label for="" id="ob">*</label>
                      <textarea name="Dir" id="Dir" cols="30" rows="1" maxlength="150" minlength="10" class="form-control" placeholder="Direccion" style="text-transform: uppercase;" required></textarea>
                    </div>
                    <div class="form-group col-md-5">
                      <label for="">Tipo de Nucleo</label><label for="" id="ob">*</label>
                      <select name="Tip" id="Tip" class="custom-select" required>
                        <option value="">Seleccione un valor</option>
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
                        <button type="button" class="btn btn-primary" onclick="Paginador('NucleoController',1)" data-toggle="modal" data-target="#ModalListar"> 
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
<?php $this->Footer('Nucleo'); ?>
<script src="<?php echo constant('URL');?>Views/Js/GLOBAL.js"></script>

<script>
  ShowCodigo_incrementado('<?php echo constant('URL').'NucleoController'?>',document.formulario.Cod);
  IsNucleo();
</script>
</body>
</html>


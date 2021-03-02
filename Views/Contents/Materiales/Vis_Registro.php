<?php $this->Headers(); $this->Exit(); ?>
<body class="hold-transition sidebar-mini">
	<div class="wrapper">
  <?php $this->Nav();?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php $this->Wraper('Catalogo','Materiales');?>
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
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-header bg-info">
                          <h6 class="card-title">Bien Material</h6>
                          <div class="float-right">
                            <button class="btn btn-sm btn-success" type="button" id="btnAddMaterial" title="Agregar" data-toggle="modal" data-target="#ModalMateriales">
                              <i class="fas fa-plus"></i>
                            </button>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="form-group col-md-5">
                              <label for="">Codigo</label>
                              <input type="text" name="Material" id="Cod" class="form-control" placeholder="Codigo" readonly required >
                            </div>
                            <div class="form-group col-md-7">
                              <label for="">Descripcion</label>
                              <input type="text" id="DesM" class="form-control" placeholder="Descripcion" readonly >
                            </div>
                          </div>
                          <div class="row">
                            <div class="form-group col-md-5">
                              <label for="">Precio</label>
                              <input type="text" id="PreM" class="form-control" placeholder="Codigo" readonly >
                            </div>
                            <div class="form-group col-md-7">
                              <label for="">Fecha de ingreso</label>
                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                  </div>
                                  <input type="date" class="form-control" id="FechaM" data-inputmask-alias="datetime" 
                                  data-inputmask-inputformat="mm/dd/yyyy" readonly>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-header bg-warning">
                          <h6 class="card-title">Bien Beneficiado</h6>
                          <div class="float-right">
                            <button class="btn btn-sm btn-success" type="button" id="btnAddBien" title="Agregar" data-toggle="modal" data-target="#ModalMateriales">
                              <i class="fas fa-plus"></i>
                            </button>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="row">
                              <div class="form-group col-md-5">
                                <label for="">Codigo</label>
                                <input type="text" name="CodB" id="CodB" class="form-control" placeholder="Codigo" readonly required >
                              </div>
                              <div class="form-group col-md-7">
                                <label for="">Descripcion</label>
                                <input type="text" id="DesB" class="form-control" placeholder="Descripcion" readonly >
                              </div>
                          </div>
                          <div class="row">
                            <div class="form-group col-md-5">
                              <label for="">Precio</label>
                              <input type="text" id="PreB" class="form-control" placeholder="Codigo" readonly >
                            </div>
                            <div class="form-group col-md-7">
                              <label for="">Fecha de ingreso</label>
                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                  </div>
                                  <input type="date" class="form-control" id="FechaB" data-inputmask-alias="datetime" 
                                  data-inputmask-inputformat="mm/dd/yyyy" readonly>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row card-footer">
                    <div class="col-md-12 text-center">
                      <div class="btn-group ">
                        <button type="button" id="btnAdd" data-formulario="formulario" value="Insert" class="btn btn-success" title="Guardar"> 
                          <i class="fas fa-save"></i> Registrar
                        </button>
                        <button type="reset" class="btn btn-danger">  Limpiar</button>
                        <!-- <button type="button" class="btn btn-primary" onclick="Paginador('MaterialesController',1)" data-toggle="modal" data-target="#ModalListar"> 
                            <i class="fas fa-search" ></i> Listar
                        </button> -->
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
<?php $this->Footer('Materiales'); ?>
<script src="<?php echo constant('URL');?>Views/Js/GLOBAL.js"></script>
</body>
</html>


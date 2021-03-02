<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-xl modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" id="FormEdit" name="FormEdit"  class="needs-validation" novalidate>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 col-sm-12">
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
                    <div class="form-group col-md-4">
                      <label for="">Codigo</label>
                      <input type="hidden" name="CodM_old" id="CodM_old_edit" disabled>
                      <input type="text" name="Material" id="Cod_edit" class="form-control" placeholder="Codigo" readonly required >
                    </div>
                    <div class="form-group col-md-8">
                      <label for="">Descripcion</label>
                      <input type="text" id="DesM_edit" class="form-control" placeholder="Descripcion" readonly >
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="">Precio</label>
                      <input type="text" id="PreM_edit" class="form-control" placeholder="Codigo" readonly >
                    </div>
                    <div class="form-group col-md-8">
                      <label for="">Fecha de ingreso</label>
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="date" class="form-control" id="FechaM_edit" data-inputmask-alias="datetime" 
                          data-inputmask-inputformat="mm/dd/yyyy" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="card">
                <div class="card-header bg-warning">
                  <h6 class="card-title">Bien Beneficiado</h6>
                  <div class="float-right">
                    <button class="btn btn-sm btn-success" type="button" id="btnAddBien" data-pagina="1" title="Agregar" data-toggle="modal" data-target="#ModalMateriales">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                      <div class="form-group col-md-4">
                        <label for="">Codigo</label>
                        <input type="hidden" name="CodB_old" id="CodB_old_edit" disabled >
                        <input type="text" name="CodB" id="CodB_edit" class="form-control" placeholder="Codigo" readonly required >
                      </div>
                      <div class="form-group col-md-8">
                        <label for="">Descripcion</label>
                        <input type="text" id="DesB_edit" class="form-control" placeholder="Descripcion" readonly >
                      </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="">Precio</label>
                      <input type="text" id="PreB_edit" class="form-control" placeholder="Codigo" readonly >
                    </div>
                    <div class="form-group col-md-8">
                      <label for="">Fecha de ingreso</label>
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="date" class="form-control" id="FechaB_edit" data-inputmask-alias="datetime" 
                          data-inputmask-inputformat="mm/dd/yyyy" readonly>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnUp" data-formulario="FormEdit" value="Update" class="btn btn-info"> 
            <i class="fas fa-edit"></i> Modificar
          </button>
          <button type="button" class="btn btn-secondary" onclick="document.FormEdit.reset();" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>
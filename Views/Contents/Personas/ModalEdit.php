<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" id="FormEdit" name="FormEdit" class="needs-validation" novalidate>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-4">
              <label for="">Cedula</label><label for="" id="ob">*</label>
              <input type="text" pattern="[0-9]{7,8}" title="Solo se aceptan numeros" name="Cod" id="Cod_edit" class="form-control" placeholder="Cedula" maxlength="8" minlength="8" required readonly>
            </div>
            <div class="form-group col-md-4">
              <label for="">Nombre</label><label for="" id="ob">*</label>
              <input type="text" pattern="[A-Za-z ]{4,60}" name="Nom" id="Nom_edit" class="form-control" placeholder="Nombre" maxlength="60" minlength="4" style="text-transform: uppercase;" required>
            </div>
            <div class="form-group col-md-4">
              <label for="">Apellido</label><label for="" id="ob">*</label>
              <input type="text" pattern="[A-Za-z ]{4,60}" name="Ape" id="Ape_edit" class="form-control" placeholder="Apellido" maxlength="60" minlength="4" style="text-transform: uppercase;" required>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-3">
              <label>Telefono</label><label for="" id="ob">*</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                </div>
                <input type="text" name="Tel" id="Tel_edit" maxlength="14" minlength="14" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" title="Ingresar numero de telefono omitiendo el cero inicial" data-mask="" required>
              </div>
              <!-- /.input group -->
            </div>
            <div class="form-group col-md-4">
              <label for="">Cargo</label><label for="" id="ob">*</label>
              <select name="Cargo" id="Cargo_edit" class="form-control select2bs4 select2-hidden-accessible" required>
              <?php echo $this->Control('PersonasController')->SelectCargos(); ?>
              </select>
            </div>
            <div class="form-group col-md-5">
              <label for="">Dependencia</label><label for="" id="ob">*</label>
              <select name="Dep" id="Dep_edit" class="form-control select2bs4 select2-hidden-accessible" required>
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
                <input type="email" name="Email" id="Email_edit" class="form-control" placeholder="Correo Electronico" maxlength="120" minlength="10" style="text-transform: uppercase;" required>
              </div>
            </div>
            <div class="form-group col-md-4">
              <label for="">Fecha del cargo</label><label for="" id="ob">*</label>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                  </div>
                  <input type="date" class="form-control" name="Fecha" max="<?php echo $this->Control('PersonasController')->FechaActual(); ?>" min="2000-12-31" id="Fecha_edit" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" required>
                </div>
                <!-- /.input group -->
              </div>
            </div>
            <div class="form-group col-md-4">
              <label for="">Direccion</label><label for="" id="ob">*</label>
              <textarea name="Dir" id="Dir_edit" cols="30" rows="1" class="form-control" placeholder="Direccion" maxlength="60" minlength="10" style="text-transform: uppercase;" required></textarea>
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
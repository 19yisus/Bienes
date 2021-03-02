<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" id="FormEdit" name="FormEdit"  class="needs-validation" novalidate>
        <div class="modal-body">
          <div class="col">
            <div class="form-group">
              <label for="">Codigo</label><label for="" id="ob">*</label>
              <input type="text" name="Cod" pattern="[0-9]{1,11}" minlength="1" maxlength="2" id="Cod_edit" class="form-control" placeholder="Codigo" disabled readonly>
            </div>
            <div class="form-group">
              <label for="Descripcion del nucleo">Descripcion</label><label for="" id="ob">*</label>
              <input type="text" class="form-control" id="Des_edit" name="Des" pattern="[A-Za-z ]{4,30}" placeholder="Descripcion" style="text-transform: uppercase;" autofocus minlength="4" maxlength="30" required>
            </div>
            <div class="form-group">
              <label for="CodigoPostal">Codigo Postal</label><label for="" id="ob">*</label>
              <input type="text" class="form-control" id="CP_edit" name="CP" pattern="[0-9]+" placeholder="Codigo Postal" maxlength="4" minlength="4" pattern="[0-9]+" title="Solo se aceptan numeros" required>
            </div>
            <div class="form-group">
              <label for="Direccion">Direccion</label><label for="" id="ob">*</label>
              <textarea name="Dir" id="Dir_edit" cols="30" rows="1" maxlength="150" minlength="10" class="form-control" placeholder="Direccion" style="text-transform: uppercase;" required></textarea>
            </div>
            <div class="form-group">
              <label for="">Tipo de Nucleo</label><label for="" id="ob">*</label>
              <select name="Tip" id="Tip_edit" class="custom-select">
                <option value="">Seleccione un valor</option>
                <!-- <option value="EX" >Extension</option>
                <option value="PR" >Programa</option>
                <option value="NU" >Nucleo</option> -->
              </select>
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
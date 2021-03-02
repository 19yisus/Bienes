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
              <input type="text" name="Cod" id="Cod_edit" class="form-control" placeholder="Codigo" minlength="1" maxlength="11" readonly>
            </div>
            <div class="form-group">
              <label for="">Descripcion</label><label for="" id="ob">*</label>
              <input type="text" pattern="[A-Za-z ]{3,30}" name="Raza" id="Des_edit" class="form-control" placeholder="Descripcion" minlength="3" maxlength="30" style="text-transform: uppercase;" required>
            </div>
            <div class="form-group">
              <label for="">Especie</label><label for="" id="ob">*</label>
              <select name="Esp" id="Esp_edit" class="custom-select" required>
              <?php echo $this->Control('RazasController')->Select_Especies(); ?>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="btnUp" data-formulario="FormEdit" value="Update" class="btn btn-info"> 
            <i class="fas fa-edit"></i> Modificar
          </button>
          <button type="button" class="btn btn-secondary" onclick="document.FormEdit.reset();" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>
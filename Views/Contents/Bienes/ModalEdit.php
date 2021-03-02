<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-md" role="document">
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
            <div class="form-group col-md-6">
              <label for="">Codigo</label><label for="" id="ob">*</label>
              <input type="text" name="Codbien" id="Cod_edit" class="form-control" placeholder="Codigo" readonly disabled requied>
            </div>
            <div class="form-group col-md-6">
              <label for="">Descripcion</label><label for="" id="ob">*</label>
              <input type="text" pattern="[A-Za-z ]{2,90}" name="Desbien" id="Desbien_edit" class="form-control" minlength="2" maxlength="90" placeholder="Descripcion" disabled style="text-transform: uppercase;" required>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="">Precio</label><label for="" id="ob">*</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Bs</span>
                </div>
                <input type="number" name="Valbien" id="Valbien_edit" class="form-control" step="0,00" min="1" minlength="1" maxlength="12" disabled required>
                <!-- <div class="input-group-append">
                  <span class="input-group-text">.00</span>
                </div> -->
              </div>			
            </div>
            <div class="form-group col-md-6">
              <label for="">Fecha de ingreso</label><label for="" id="ob">*</label>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                  </div>
                  <input type="date" class="form-control" name="Fecbien" id="Fecbien_edit" max="<?php echo $this->Control('BienesController')->fecha();?>" min="2000-12-31" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" disabled required>
                </div>
                <!-- /.input group -->
              </div>
            </div>
          </div>
          <!-- Row1 (Bienes ELectronicos, Materiales, Material de oficina, Transporte) -->
          <div class="row EL MA OF TP" id="fila" style="display:none;">
            <!-- Caracteristicas muebles -->
            <div class="form-group col-md-4">
              <label for="">Marca</label><label for="" id="ob">*</label>
              <select name="Marca" id="Marca_edit" class="custom-select" disabled required>
                <option value="">Seleccione un valor</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="">Modelo</label><label for="" id="ob">*</label>
              <select name="Modelo" id="Modelo_edit" class="custom-select" disabled required>
                <option value="">Seleccione un valor</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="">Color</label><label for="" id="ob">*</label>
              <select name="Color" id="Color_edit" class="custom-select" disabled required>
              <?php echo $this->Control('BienesController')->SelectColores(); ?>
              </select>
            </div>
          </div>
          <!-- ./Row1 -->
          <!-- Row2 (Bienes Electronicos, Materiales, Material de oficina) -->
          <div class="row EL MA OF" id="fila" style="display:none;">
            <div class="form-group col-md-4">
              <label for="">Catalogo</label><label for="" id="ob">*</label>
              <input type="text" name="Catalogo" id="Catalogo_edit" minlength="4" maxlength="20" class="form-control" placeholder="Catalogo" disabled required>
            </div>
            <div class="form-group col-md-4">
              <label for="">Serial</label><label for="" id="ob">*</label>
              <input type="text" name="Serial" id="Serial_edit" minlength="4" maxlength="20" class="form-control" placeholder="Serial" disabled required>
            </div>
            <div class="form-group col-md-4">
              <label for="">Depreciacion</label><label for="" id="ob">*</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Bs</span>
                </div>
                <input type="number" name="Depre" id="Depre_edit" step="0,00" min="1" minlength="1" maxlength="12" class="form-control" disabled required>
                <!-- <div class="input-group-append">
                  <span class="input-group-text">.00</span>
                </div> -->
              </div>
            </div>
          </div>
          <!-- ./Row2 -->             
          <!-- Row3 (Transporte)-->
          <div class="row TP" id="fila" style="display:none;">
            <div class="form-group col-md-6">
              <label for="">Placa</label><label for="" id="ob">*</label>
              <input type="text" name="Placa" id="Placa_edit" class="form-control" minlength="6" maxlength="6" placeholder="Placa" disabled style="text-transform: uppercase;" required>
            </div>
            <div class="form-group col-md-6">
              <label for="">Año</label><label for="" id="ob">*</label>
              <input type="number" name="Anio" id="Anio_edit" step="1" max="<?php echo $this->Control('BienesController')->Year();?>" min="1990" minlength="4" maxlength="4" class="form-control" placeholder="Año" disabled required>
            </div>
          </div>
          <!-- ./Row3 -->
          <!-- Row4 (Bien Inmueble) -->
          <div class="row IN" id="fila" style="display:none;">
            <div class="form-group col-md-12">
              <label for="">Terreno</label><label for="" id="ob">*</label>
              <textarea name="Terreno" id="Terreno_edit" class="form-control" minlength="10" maxlength="120" cols="15" rows="3" placeholder="Descripcion del terreno" disabled required></textarea>
            </div>
          </div>
          <!-- ./Row4 -->
          <!-- Row5 (Bien Semoviente) -->
          <div class="row BS" id="fila" style="display:none;">
            <div class="form-group col-md-6">
              <label for="">Especie</label><label for="" id="ob">*</label>
              <select name="Esp" id="Esp_edit" class="custom-select" disabled required>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="">Raza</label><label for="" id="ob">*</label>
              <select name="Raza" id="Raza_edit" class="custom-select" disabled required>
              </select>
            </div>                             
          </div>
          <!-- ./Row5 -->
          <!-- Row6 -->
          <div class="row BS" id="fila" style="display:none;">
            <div class="form-group col-md-7">
              <label for="">Peso</label><label for="" id="ob">*</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Kg</span>
                </div>
                <input type="number" name="Peso" id="Peso_edit" step="0,00" minlength="2" maxlength="6" class="form-control" disabled required>
                <!-- <div class="input-group-append">
                  <span class="input-group-text">.00</span>
                </div> -->
              </div>
            </div>
            <div class="form-group col-md-5">
              <label for="">Sexo</label><label for="" id="ob">*</label>
              <div class="form-check">
                <input type="radio" name="sexo" id="S1_edit" value='F' class="form-check-input" disabled required>
                <label for="S1" class="form-check-label">F</label>
              </div>
              <div class="form-check">
                <input type="radio" name="sexo" id="S2_edit" value='M' class="form-check-input" disabled required>
                <label for="S2" class="form-check-label">M</label>
              </div>
            </div>
          </div>
          <!-- ./Row6 -->
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
const controller = "DependenciasController";

const Consulta = (e) =>{
  fetch(`${host_url}/${controller}/Consulta/${e.dataset.codigo}`)
    .then( response =>{
      return response.json();
    })
    .then( res =>{
      $('#ModalCatalogo').modal('hide');
      
      if(res.status == 200){
        
        $('#Cod_edit').val(res.datos.Cod);
        $('#Des_edit').val(res.datos.Des);

        for(var i = 0; i < $('#Nu_edit')[0].options.length; i++){

          if ($('#Nu_edit')[0].options[i].value == res.datos.Nu){
            $('#Nu_edit')[0].selectedIndex = i;
            break;
          }
        }

      }else{
        alerta(res.respuesta);
      }
    })
    .catch( Error =>{
      console.log(Error);
    });
}

const SelectNucleos = () =>{
  fetch(`${host_url}/${controller}/Select_Nucleos/1`)
  .then( response =>{ return response.text(); })
  .then( res =>{ $('#Nu').html(res); });
}

const Isthereprincipal = () =>{
  let alerta_warning = `
  <div class="alert alert-warning alert-dismissible fade show" role="alert" id="alert-waring">
    <strong>Atencion!</strong> No hay Dependencias registradas, por lo tanto deberas de registrar 
    la dependencia de Bienes Nacionales en la sede principal primero.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>`;

  fetch(`${host_url}/${controller}/Isthereprincipal`)
    .then( response => { return response.json(); })
    .then( res => { 
      
      if(res == false){ 
        $('#caja').parent().prepend(alerta_warning); 
      }else{
        $('.alert').alert('close');
      }
    })
    .catch( Error => { console.log(Error) });
}
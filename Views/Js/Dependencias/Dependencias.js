const controller = "DependenciasController";

const Consulta = (e) =>{
  fetch(`${url}/${controller}/Consulta/${e.dataset.codigo}`)
    .then( response =>{
      return response.json();
    })
    .then( res =>{
      $('#ModalListar').modal('hide');
      
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
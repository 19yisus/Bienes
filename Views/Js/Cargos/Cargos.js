const controller = "CargosController";

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

    }else{
      alerta(res.respuesta);
    }
  })
  .catch( Error =>{
    console.log(Error);
  });
}
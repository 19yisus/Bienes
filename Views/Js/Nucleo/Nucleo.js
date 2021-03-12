const controller = "NucleoController";

const Consulta = (e) =>{
  fetch(`${host_url}/${controller}/Consulta/${e.dataset.codigo}`)
    .then( response =>{ return response.json(); })
    .then( res =>{
      $('#ModalCatalogo').modal('hide');

      if(res.status == 200){
        $('#Cod_edit').attr('disabled',false);
        $('#Cod_edit').val(res.datos.Cod);
        $('#Des_edit').val(res.datos.Des);
        $('#CP_edit').val(res.datos.CodPostal);
        $('#Dir_edit').val(res.datos.Dir);

        if(res.datos.TipeNu == 'SP'){
          $('#Tip_edit').attr('disabled',true);
        }else{
          $('#Tip_edit').attr('disabled',false);

          for(var i = 0; i < $('#Tip_edit')[0].options.length; i++){
            if ($('#Tip_edit')[0].options[i].value == res.datos.TipeNu){
              $('#Tip_edit')[0].selectedIndex = i;
              break;
            }
          }
        }
      }
    })
    .catch( Error =>{ console.log(Error); });
}

const IsthereSede = () =>{
  let alerta_warning = `
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Atencion!</strong> No hay nuclos registrados, por lo tanto deberas de registrar la sede principal primero.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>`;
  fetch(`${host_url}/${controller}/IsThereSedePrincipal`)
    .then( response => { return response.json(); })
    .then( res => {
      if(res == true){
        $('.alert').alert('close');
        if($('#Tip')[0]){
          $("#Tip option").remove();
          $('#Tip')[0].options.add( new Option('Seleccione un valor',''));
          $('#Tip')[0].options.add( new Option('Nucleo','NU'));
          $('#Tip')[0].options.add( new Option('Programa','PR'));
          $('#Tip')[0].options.add( new Option('Extension','EX'));
        }
        if($('#Tip_edit')[0]){
          $("#Tip_edit option").remove();
          $('#Tip_edit')[0].options.add( new Option('Seleccione un valor',''));
          $('#Tip_edit')[0].options.add( new Option('Nucleo','NU'));
          $('#Tip_edit')[0].options.add( new Option('Programa','PR'));
          $('#Tip_edit')[0].options.add( new Option('Extension','EX'));
        }
      }else{ $('#Tip')[0].options.add( new Option('Sede Principal','SP')); $('#caja').parent().prepend(alerta_warning); }
    }).catch( Error => { console.log(Error) });
}
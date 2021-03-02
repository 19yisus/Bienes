const controller = "NucleoController";

const Consulta = (e) =>{  
  fetch(`${url}/${controller}/Consulta/${e.dataset.codigo}`)
    .then( response =>{
      return response.json();
    })
    .then( res =>{
      $('#ModalListar').modal('hide');
           
      if(res.status == 200){
                        
        $('#Cod_edit').attr('disabled',false);
        $('#Cod_edit').val(res.datos.Cod);
        $('#Des_edit').val(res.datos.Des);
        $('#CP_edit').val(res.datos.CodPostal);
        $('#Dir_edit').val(res.datos.Dir);
        
        if(res.datos.TipeNu == 'NU'){
          $('#Tip_edit').attr('disabled',true);
        }else{

          for(var i = 0; i < $('#Tip_edit')[0].options.length; i++){

            if ($('#Tip_edit')[0].options[i].value == res.datos.TipeNu){
              $('#Tip_edit')[0].selectedIndex = i;
              break;
            }
          }
        }
      }
    })
    .catch( Error =>{
      console.log(Error);
    });
}

const IsNucleo = () =>{

  fetch(`${url}/${controller}/ThereIsNucleo`)
    .then( response => {
      return response.json();
    })
    .then( res => {
            
      if(res == true){
        if($('#Tip')[0]){
          $('#Tip')[0].options.add( new Option('Programa','PR'));
          $('#Tip')[0].options.add( new Option('Extension','EX'));
        }

        if($('#Tip_edit')[0]){
          $('#Tip_edit')[0].options.add( new Option('Programa','PR'));
          $('#Tip_edit')[0].options.add( new Option('Extension','EX'));
        }
        
      }else{
        $('#Tip')[0].options.add( new Option('Nucleo','NU'));
      }
    })
    .catch( Error => {
      console.log(Error)
    });	
}



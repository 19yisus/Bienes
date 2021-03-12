const controller = 'ModelosController';

const Consulta = (e)=>{
	fetch(`${host_url}/${controller}/Consulta/${e.dataset.codigo}`)
		.then( response =>{
			return response.json();
		})
		.then( res =>{
			$('#ModalCatalogo').modal('hide');
			
			if(res.status == 200){

				$('#Cod_edit').val(res.datos.Cod);
				$('#Des_edit').val(res.datos.Des);

				for(var i = 0; i < $('#Marca_edit')[0].options.length; i++){

					if ($('#Marca_edit')[0].options[i].value == res.datos.Marca){
						$('#Marca_edit')[0].selectedIndex = i;
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
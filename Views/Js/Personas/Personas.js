const controller = 'PersonasController';

const Consulta = (e)=>{
	fetch(`${host_url}/${controller}/Consulta/${e.dataset.codigo}`)
		.then( response =>{
			return response.json();
		})
		.then( res =>{
			$('#ModalCatalogo').modal('hide');
			
			if(res.status == 200){				
				$('#Cod_edit').val(res.datos.Cod);
				$('#Nom_edit').val(res.datos.Name);
				$('#Ape_edit').val(res.datos.LastName);
				$('#Tel_edit').val(res.datos.Tel);
				$('#Email_edit').val(res.datos.Email);
				$('#Fecha_edit').val(res.datos.Fecha);
				$('#Dir_edit').val(res.datos.Dir);

				for(var i = 0; i < $('#Cargo_edit')[0].options.length; i++){
					if ($('#Cargo_edit')[0].options[i].value == res.datos.CodCargo){
						$('#Cargo_edit')[0].selectedIndex = i;
						break;
					}
				}

				for(var i = 0; i < $('#Dep_edit')[0].options.length; i++){

					if ($('#Dep_edit')[0].options[i].value == res.datos.CodDep){
						$('#Dep_edit')[0].selectedIndex = i;
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

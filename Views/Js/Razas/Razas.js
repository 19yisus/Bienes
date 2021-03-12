const controller = "RazasController";

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

				for(var i = 0; i < $('#Esp_edit')[0].options.length; i++){

					if ($('#Esp_edit')[0].options[i].value == res.datos.Raza){
						$('#Esp_edit')[0].selectedIndex = i;
						break;
					}
				}
			}
		})
		.catch( Error =>{
			console.log(Error);
		});
}

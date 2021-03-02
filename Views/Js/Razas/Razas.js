const controller = "RazasController";

const Consulta = (e) =>{
	fetch(`${url}/${controller}/Consulta/${e.dataset.codigo}`)
		.then( response =>{
			return response.json();
		})
		.then( res =>{

			if(res.status == 200){

				$('#Cod_edit')[0].value = res.datos.Cod;
				$('#Des_edit')[0].value = res.datos.Des;

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

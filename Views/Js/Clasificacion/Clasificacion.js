const controller = "ClasificacionController";

const Consulta = (e) =>{
	fetch(`${url}/${controller}/Consulta/${e.dataset.codigo}`)
		.then( response =>{
			return response.json();
		})
		.then( res =>{
			$('#ModalListar').modal('hide');
			
			if(res.status == 200){
				
				$('#Cod_edit')[0].value = res.datos.Cod;
				$('#Des_edit')[0].value = res.datos.Des;

				for(var i = 0; i < $('#Tip_edit')[0].options.length; i++){
					if ($('#Tip_edit')[0].options[i].value == res.datos.Cate){
						$('#Tip_edit')[0].selectedIndex = i;
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

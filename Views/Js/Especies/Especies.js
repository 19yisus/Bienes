const controller = 'EspeciesController';

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

			}else{

				alerta(res.respuesta);
			}
		})
		.catch( Error =>{
			console.log(Error);
		});
}

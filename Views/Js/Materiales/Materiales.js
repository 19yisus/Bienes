const controller = "MaterialesController";

const AddForm = (valor) =>{
	let form = valor.dataset.form;
	let codigo = valor.dataset.codigo;

	fetch(`${url}/${controller}/SearchById/${codigo}`)
		.then( response =>{ return response.json(); })
		.then( res =>{
			
			if(form == 'Materiales'){

				if($('#formulario')){
					$('#Cod').val(res.Cod);
					$('#DesM').val(res.Des);
					$('#PreM').val(res.Pre);
					$('#FechaM').val(res.Fecha);
				}

				if ($('#FormEdit').is(':visible')){
					$('#CodB_old_edit').attr('disabled', false);
					$('#CodB_old_edit').val('null');

					$('#CodM_old_edit').attr('disabled', false);
					$('#CodM_old_edit').val($('#Cod_edit').val());

					$('#Cod_edit').val(res.Cod);
					$('#DesM_edit').val(res.Des);
					$('#PreM_edit').val(res.Pre);
					$('#FechaM_edit').val(res.Fecha);
				}
				

			}else{

				if($('#formulario')){
					$('#CodB').val(res.Cod);
					$('#DesB').val(res.Des);
					$('#PreB').val(res.Pre);
					$('#FechaB').val(res.Fecha);
				}

				if ($('#FormEdit').is(':visible')) {
					$('#CodB_old_edit').attr('disabled', false);
					$('#CodB_old_edit').val($('#CodB_edit').val());

					$('#CodM_old_edit').attr('disabled', false);
					$('#CodM_old_edit').val('null');

					$('#CodB_edit').val(res.Cod);
					$('#DesB_edit').val(res.Des);
					$('#PreB_edit').val(res.Pre);
					$('#FechaB_edit').val(res.Fecha);
				}

				

			}
		})
		.catch( Error =>{ console.log(Error); })
}

const ModalBienes = (tipo,pag)=>{

	fetch(`${url}/${controller}/ModalAsignacion/${tipo}/${pag}`)
		.then( response =>{ return response.text(); })
		.then( res =>{ $('#MaterialesAdd').html(res); })
		.catch( Error =>{ console.log(Error); })
}

const Consulta = (e) =>{

	fetch(`${url}/${controller}/Consulta/${e.dataset.codigo}`)
		.then( response =>{ return response.json(); })
		.then( res =>{
			
			//Inputs del Material
			$('#Cod_edit').val(res.Material.Cod);
			$('#DesM_edit').val(res.Material.Des);
			$('#PreM_edit').val(res.Material.Pre);
			$('#FechaM_edit').val(res.Material.Fecha);

			//Inputs del Bien
			$('#CodB_edit').val(res.Bien.Cod);
			$('#DesB_edit').val(res.Bien.Des);
			$('#PreB_edit').val(res.Bien.Pre);
			$('#FechaB_edit').val(res.Bien.Fecha);

		})
		.catch( Error =>{ console.log(Error); })
}

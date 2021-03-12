//ZONA DE DECLARACION DE VARIABLES
const host_url = "http://localhost:80/proyectos/proyecto3/Bienes";
const Paginador_url = `${host_url}/${controller}/PaginadorController`;

const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000
});

//FUNCION PARA DETECTAR EL BOTON DE CONSULTA EN EL PAGINADOR
const bConsul = (valor) =>{
	var id = valor.dataset.codigo;
	var control = valor.dataset.control;

	fetch(`${host_url}/${control}/Listar/${id}`)
		.then( response =>{ return response.text(); })
		.then( res =>{ $("#ConsultaList").html(res); })
		.catch( Error =>{ console.log( Error ); });
}

const bDelet = (valor) => { //FUNCION PARA DETECTAR EL BOTON DE DESACTIVAR EN EL PAGINADOR
	let boton = valor.dataset.function;
	let form = valor.dataset.form;
	confirmacion(`${host_url}/${controller}/${boton}`, $(`#${form}`)[0]).then( (response1) =>{
		if(response1){
			POST(response1[0],response1[1]).then( (response) =>{ return response; })
		}
	}).then( () => {
		reloadCatalogo();
	});
}

const reloadCatalogo = () =>{
  if($('#catalogo_table').is(":visible")){
    catalogo = 'catalogo_table';
  }else{
    catalogo = 'catalogo_table2';
  }
  
  $(`#${catalogo}`).DataTable().ajax.reload(null, false);
}

const permisosUser = async () =>{
	return await fetch(`${host_url}/${controller}/permisos`)
		.then( response => { return response.json(); })
		.then( res => { return res; })
		.catch( Error => { return false; });
}

const ShowCodigo_incrementado = (control, inputCod) =>{
	fetch(`${control}/ShowCodigoIncrementado`)
		.then( response =>{ return response.text(); })
		.then( res =>{ inputCod.value = res; })
		.catch( Error =>{ console.log(Error); });
}

const confirmacion = async (ruta, form) =>{
	return await Swal.fire({
		title: 'Estas Seguro?',
		text: 'Solicitando confirmacion para proceder con la operacion',
		icon: 'warning',
		showCancelButton: true,
		showConfirmButton: true,
		confirmButtonText:'Aceptar',
		cancelButtonText: 'Cancelar'
	}).then( valor =>{

		if(valor.value){
			return [ruta, form];
		}
	});
}

//FUNCION PARA EL ENVIO DE LOS DATOS DEL FORMULARIO POR METODO POST
const POST = async (metodo, form) =>{

	var data = new FormData(form);

	return await fetch(metodo,{
		method: "POST",
		body: data
	}).then( response =>{ return response.json();
	}).then( res =>{

		if(res.status != 400){
						
			form.reset();
			$('#ModalEdit').modal('hide');
			$('#ModalCatalogo').modal('hide');

			if($('#formulario')){
				$('#formulario').removeClass('was-validated');
			}

			if($('#FormEdit')){
				$('#FormEdit').removeClass('was-validated');
			}
		}

		var texto = res.respuesta;
		var tipo = (res.status == 200) ? 'success' : 'error';

		Swal.fire({
			text: (res.datos != "") ? res.datos : '',
			title: texto,
			icon: tipo
		});

		return res;

	}).catch( Error =>{ console.log(Error); });
}

function alerta(texto){
	Toast.fire({
		icon: 'warning',
		title: texto
	});
}

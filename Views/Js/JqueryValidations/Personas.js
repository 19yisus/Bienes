$(document).ready(() => {
	$('[data-mask]').inputmask();
    $('.js-example-responsive').select2({
    	placeholder: "Seleccione un valor",
    	allowClear: true,
    	width: 'resolve'
    });	
	
	let catalogo;
	
	if($('#catalogo_table').is(":visible")){
		catalogo = 'catalogo_table';
	}else{
		catalogo = 'catalogo_table2';
	}

	$(`#${catalogo}`).DataTable({
    responsive: true, lengthChange: true, autoWidth: true,
    ajax:{
      url: Paginador_url,
      dataSrc: 'data',
    },
    columns:[
      {data: 'per_cedula'},
      {data: 'nombre'},
      {data: 'car_des'},
      {data: 'dep_des'},
      {data: 'nuc_des'},
      {data: 'per_estado', render: function(data){ return (data == 1) ? 'Activo': 'Innactivo'; }},
      {defaultContent: "",
      render: function(data, type, row, meta){
        let estado = (row.per_estado == 0) ? 'disabled': '';
        let title_edit = (row.per_estado == 0) ? 'Esta Persona no puede ser modificada': 'Modificar';
        let title_desac = (row.per_estado == 0) ? 'Activar':'Desactivar';
        let clase = (row.per_estado == 0) ? 'danger':'success';
        let btn = `
          <form name="form-del-${row.per_cedula}" id="form-del-${row.per_cedula}">
            <input type="hidden" name="Cod" value="${row.per_cedula}">
          </form>
          <div class='btn-group'>
            <button class="btn btn-sm btn-info" id="btn-edit" onclick="Consulta(this)" data-codigo="${row.per_cedula}"
              data-toggle="modal" data-target="#ModalEdit" ${estado} title="${title_edit}">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-${clase}" onclick="bDelet(this);" id="bDelete" data-form="form-del-${row.per_cedula}" 
            data-dismiss="modal" title="${title_desac}">
              <i class="fas fa-power-off"></i>
            </button>
            <button class="btn btn-sm btn-default" data-control="${controller}" onclick="bConsul(this);" data-codigo="${row.per_cedula}"
              data-toggle="modal" data-target="#ModalConsultar" data-dismiss="modal"  title="Consultar">
              <i class="fas fa-list"></i>
            </button>
           </div>`;
        return btn;
      }
      }],
    language:{
      url: `${host_url}/Views/Js/DataTables.config.json`
    }
  	});

	$.validator.addMethod('valida_fecha', (value, element) => {

		if (value >= element.min && value <= element.max) {
			return true;
		}
		return false;
	}, "La fecha ingresada es invalida");

	$.validator.addMethod('valida_telefono', (value,element)=>{
		let res = false;

		let datos = value.replace("(","");
		datos = datos.replace(")","");

		$('#codigos_telefonicos option').each( (i,e)=>{
			if(datos.match(`^${e.value}`)){
				res = true;
				return;
			}
		});

		return res;
	},'El numero ingresado no es valido');

	$.validator.addMethod('endwith_email', (value,element)=>{
		let res = false;
		let emails_validos = ['HOTMAIL.COM','GMAIL.COM','OUTLOOK.COM','YAHOO.COM'];
		value = value.toUpperCase();
		emails_validos.forEach( x => {
			if(value.endsWith(x)){
				res = true;
			}
		});

		return res;
	},"El correo electronico ingresado es invalido");

	$.validator.setDefaults({
		onsubmit: true,
		debug: true,
		errorClass: 'invalid-feedback',
		highlight: function (element) {
			$(element)
				.closest('.form-group')
				.removeClass('has-success')
				.addClass('has-error');
		},
		unhighlight: function (element) {
			$(element)
				.closest('.form-group')
				.removeClass('has-error')
				.addClass('has-success');
		},
		errorPlacement: function (error, element) {
			if (element.prop('type') === 'checkbox') {
				error.insertAfter(element.parent());
			} else {
				// var id = element[0].attributes.id.value;
				// console.log( $(`#${id}`)[0].attr('aria-invalid'))
				// $(element).attr('aria-invalid', true);
				error.insertAfter(element);
			}

			if (element.parent().parent().parent().parent()[0].id == 'formulario') {
				$('#formulario').addClass('was-validated');
			} else {
				$('#FormEdit').addClass('was-validated');
			}

		}
	});

	$('#FormEdit').validate({
		rules: {
			Cod: {
				required: true,
				minlength: 7,
				maxlength: 8,
				number: true,
			},
			Nom: {
				required: true,
				minlength: 4,
				maxlength: 60,
			},
			Ape: {
				required: true,
				minlength: 4,
				maxlength: 60,
			},
			Tel: {
				required: true,
				minlength: 14,
				maxlength: 14,
			},
			Cargo: {
				required: true,
			},
			Dep: {
				required: true,
			},
			Email: {
				required: true,
				minlength: 10,
				maxlength: 120,
				email: true,
				endwith_email: true,
			},
			Fecha: {
				required: true,
				valida_fecha: true,
			},
			Dir: {
				required: true,
				minlength: 10,
				maxlength: 60,
			},
		},
		messages: {
			Cod: {
				required: "Debe de ingresar la cedula",
				minlength: "Debe de ingresar al menos 7 caracteres",
				maxlength: "No debes de ingresar mas de 8 caracteres",
				number: "Solo se permiten numeros",
			},
			Nom: {
				required: "Debe de ingresar el nombre",
				minlength: "Debe de ingresar al menos 4 caracteres",
				maxlength: "No debes de ingresar mas de 60 caracteres",
				pattern: 'Este campo solo acepta letras',
			},
			Ape: {
				required: "Debe de ingresar el apellido",
				minlength: "Debe de ingresar al menos 4 caracteres",
				maxlength: "No debes de ingresar mas de 60 caracteres",
				pattern: 'Este campo solo acepta letras',
			},
			Tel: {
				required: "Debe de ingresar el telefono",
				minlength: "Numero de telefono incompleto",
				maxlength: "Demasiados numeros",
			},
			Cargo: {
				required: "Debe seleccionar un cargo",
			},
			Dep: {
				required: "Debe seleccionar una dependencia",
			},
			Email: {
				required: "Debe ingresar el correo electronico",
				minlength: "Debe de ingresar al menos 10 caracteres",
				maxlength: "No debes de ingresar mas de 120 caracteres",
				email: "Correo electronico invalido",
			},
			Fecha: {
				required: "Debe ingresar la fecha de asignacion del cargo",
			},
			Dir: {
				required: "Debe de ingresar la direccion",
				minlength: "Debe de ingresar al menos 10 caracteres",
				maxlength: "No debes de ingresar mas de 60 caracteres",
			},
		},
	});

	$('#formulario').validate({
		rules: {
			Cod: {
				required: true,
				minlength: 7,
				maxlength: 8,
				number: true,
				remote: `${host_url}/${controller}/check_cedula`
			},
			Nom: {
				required: true,
				minlength: 4,
				maxlength: 60,
			},
			Ape: {
				required: true,
				minlength: 4,
				maxlength: 60,
			},
			Tel: {
				required: true,
				minlength: 15,
				maxlength: 15,
				valida_telefono: true,
			},
			Cargo: {
				required: true,
			},
			Dep: {
				required: true,
			},
			Email: {
				required: true,
				minlength: 10,
				maxlength: 120,
				email: true,
				endwith_email: true,
				// remote: `${host_url}/${controller}/check_email`
			},
			Fecha: {
				required: true,
				valida_fecha: true,
			},
			Dir: {
				required: true,
				minlength: 10,
				maxlength: 60,
			},
		},
		messages: {
			Cod: {
				required: "Debe de ingresar la cedula",
				minlength: "Debe de ingresar al menos 7 caracteres",
				maxlength: "No debes de ingresar mas de 8 caracteres",
				number: "Solo se permiten numeros",
				remote: "Esta cedula ya esta registrada",
			},
			Nom: {
				required: "Debe de ingresar el nombre",
				minlength: "Debe de ingresar al menos 4 caracteres",
				maxlength: "No debes de ingresar mas de 60 caracteres",
				pattern: 'Este campo solo acepta letras',
			},
			Ape: {
				required: "Debe de ingresar el apellido",
				minlength: "Debe de ingresar al menos 4 caracteres",
				maxlength: "No debes de ingresar mas de 60 caracteres",
				pattern: 'Este campo solo acepta letras',
			},
			Tel: {
				required: "Debe de ingresar el telefono",
				minlength: "Numero de telefono incompleto",
				maxlength: "Demasiados numeros",
				valida_telefono: "El numero de telefono ingresado es invalido",
			},
			Cargo: {
				required: "Debe seleccionar un cargo",
			},
			Dep: {
				required: "Debe seleccionar una dependencia",
			},
			Email: {
				required: "Debe ingresar el correo electronico",
				minlength: "Debe de ingresar al menos 10 caracteres",
				maxlength: "No debes de ingresar mas de 120 caracteres",
				email: "Correo electronico invalido",
				// remote:"Este correo ya esta registrado",
			},
			Fecha: {
				required: "Debe ingresar la fecha de asignacion del cargo",
			},
			Dir: {
				required: "Debe de ingresar la direccion",
				minlength: "Debe de ingresar al menos 10 caracteres",
				maxlength: "No debes de ingresar mas de 60 caracteres",
			},
		},
	});

	$('#btnAdd').click(() => {

		if ($('#formulario').valid()) {
			confirmacion(`${host_url}/${controller}/Insert`, $('#formulario')[0]).then((response1) => {
				if (response1) {
					POST(response1[0], response1[1]).then((res) => {
						if (res.status == 200) {
							reloadCatalogo();
							return true;
						}
					});
				}
			});
		}
	});

	$('#btnUp').click(() => {

		if ($('#FormEdit').valid()) {
			confirmacion(`${host_url}/${controller}/Update`, $('#FormEdit')[0]).then((response1) => {
				if (response1) {
					POST(response1[0], response1[1]).then((res) => {
						reloadCatalogo();
						return true;
					});
				}
			});
		}
	});

	$('#Cod').on('keyup', ()=>{
		$('#Cod').valid();
	});
});

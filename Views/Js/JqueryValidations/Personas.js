$(document).ready(() => {
	$('[data-mask]').inputmask();

	$.validator.addMethod('valida_fecha', (value, element) => {

		if (value >= element.min && value <= element.max) {
			return true;
		}
		return false;
	}, "La fecha ingresada es invalida");

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

	$('#btnAdd').click(() => {

		if ($('#formulario').valid()) {
			confirmacion(`${url}/${controller}/Insert`, $('#formulario')[0]).then((response1) => {
				if (response1) {
					POST(response1[0], response1[1]).then((res) => {
						if (res.status == 200) {
							return true;
						}
					});
				}
			});
		}
	});

	$('#btnUp').click(() => {

		if ($('#FormEdit').valid()) {
			confirmacion(`${url}/${controller}/Update`, $('#FormEdit')[0]).then((response1) => {
				if (response1) {
					POST(response1[0], response1[1]).then((res) => {
						return true;
					});
				}
			});
		}
	});
});

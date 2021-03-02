$(document).ready(() => {
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
				minlength: 2,
				maxlength: 2,
				number: true,
			},
			Des: {
				required: true,
				minlength: 4,
				maxlength: 30,
			},
			Tip: {
				required: true,
			}
		},
		messages: {
			Cod: {
				required: 'Debe de ingresar el codigo para esta clasificacion',
				minlength: 'Debe de ingresar 2 caracteres numericos',
				maxlength: 'Debe de ingresar solo 2 caracteres numericos',
				number: 'Solo se permiten numeros',
				pattern: 'Este campo solo acepta numeros',
			},
			Des: {
				required: 'Debe ingresar el nombre de la clasificacion',
				minlength: 'Debe de ingresar al menos 4 caracteres',
				maxlength: 'No puede ingresar mas de 30 caracteres',
				pattern: 'Este campo solo acepta letras',
			},
			Tip: {
				required: 'Debe de seleccionar la categoria de esta clasificacion',
			}
		}
	});

	$('#formulario').validate({
		rules: {
			Cod: {
				required: true,
				minlength: 2,
				maxlength: 2,
				number: true,
			},
			Des: {
				required: true,
				minlength: 4,
				maxlength: 30,
			},
			Tip: {
				required: true,
			}
		},
		messages: {
			Cod: {
				required: 'Debe de ingresar el codigo para esta clasificacion',
				minlength: 'Debe de ingresar 2 caracteres numericos',
				maxlength: 'Debe de ingresar solo 2 caracteres numericos',
				number: 'Solo se permiten numeros',
				pattern: 'Este campo solo acepta numeros',
			},
			Des: {
				required: 'Debe ingresar el nombre de la clasificacion',
				minlength: 'Debe de ingresar al menos 4 caracteres',
				maxlength: 'No puede ingresar mas de 30 caracteres',
				pattern: 'Este campo solo acepta letras',
			},
			Tip: {
				required: 'Debe de seleccionar la categoria de esta clasificacion',
			}
		}
	});

	$('#btnAdd').click(() => {

		if ($('#formulario').valid()) {
			confirmacion(`${url}/${controller}/Insert`, $('#formulario')[0]).then((response1) => {
				if (response1) {
					POST(response1[0], response1[1]).then((res) => {
						return true;
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

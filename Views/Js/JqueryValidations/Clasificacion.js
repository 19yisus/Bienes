$(document).ready(() => {
	
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
      {data: 'cla_cod'},
      {data: 'cla_des'},
      {data: 'cat_des'},
      {defaultContent: "",
      render: function(data, type, row, meta){
        let estado = (row.mod_estado == 0) ? 'disabled': '';
        let title_edit = 'Modificar';
        let btn = `
          <form name="form-del-${row.cla_cod}" id="form-del-${row.cla_cod}">
            <input type="hidden" name="Cod" value="${row.cla_cod}">
          </form>
          <div class='btn-group'>
            <button class="btn btn-sm btn-info" id="btn-edit" onclick="Consulta(this)" data-codigo="${row.cla_cod}"
              data-toggle="modal" data-target="#ModalEdit" ${estado} title="${title_edit}">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-default" data-control="${controller}" onclick="bConsul(this);" data-codigo="${row.cla_cod}"
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
				remote: `${host_url}/${controller}/check_codigo`
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
				remote: 'Este codigo ya esta registrado',
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
			confirmacion(`${host_url}/${controller}/Insert`, $('#formulario')[0]).then((response1) => {
				if (response1) {
					POST(response1[0], response1[1]).then((res) => {
						reloadCatalogo();
						return true;
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
});

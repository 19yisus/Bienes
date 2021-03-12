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
      {data: 'mod_cod'},
      {data: 'mod_des'},
      {data: 'mar_des'},
      {data: 'mod_estado', render: function(data){ return (data == 1) ? 'Activo': 'Innactivo'; }},
      {defaultContent: "",
      render: function(data, type, row, meta){
        let estado = (row.mod_estado == 0) ? 'disabled': '';
        let title_edit = (row.mod_estado == 0) ? 'Este Modelo no puede ser modificado': 'Modificar';
        let title_desac = (row.mod_estado == 0) ? 'Activar':'Desactivar';
        let clase = (row.mod_estado == 0) ? 'danger':'success';
        let btn = `
          <form name="form-del-${row.mod_cod}" id="form-del-${row.mod_cod}">
            <input type="hidden" name="Cod" value="${row.mod_cod}">
          </form>
          <div class='btn-group'>
            <button class="btn btn-sm btn-info" id="btn-edit" onclick="Consulta(this)" data-codigo="${row.mod_cod}"
              data-toggle="modal" data-target="#ModalEdit" ${estado} title="${title_edit}">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-${clase}" onclick="bDelet(this);" id="bDelete" data-form="form-del-${row.mod_cod}" 
            data-dismiss="modal" title="${title_desac}">
              <i class="fas fa-power-off"></i>
            </button>
            <button class="btn btn-sm btn-default" data-control="${controller}" onclick="bConsul(this);" data-codigo="${row.mod_cod}"
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
			Modelo: {
				required: true,
				minlength: 3,
				maxlength: 30,
			},
			Marca: {
				required: true,
			}
		},
		messages: {
			Modelo: {
				required: 'Debe ingresar el nombre del modelo',
				minlength: 'Debe de ingresar al menos 3 caracteres',
				maxlength: 'No puede ingresar mas de 30 caracteres',
			},
			Marca: {
				required: 'Debe de seleccionar una marca',
			}
		}
	});

	$('#formulario').validate({
		rules: {
			Modelo: {
				required: true,
				minlength: 3,
				maxlength: 30,
			},
			Marca: {
				required: true,
			}
		},
		messages: {
			Modelo: {
				required: 'Debe ingresar el nombre del modelo',
				minlength: 'Debe de ingresar al menos 3 caracteres',
				maxlength: 'No puede ingresar mas de 30 caracteres',
			},
			Marca: {
				required: 'Debe de seleccionar una marca',
			}
		}
	});

	$('#btnAdd').click(() => {

		if ($('#formulario').valid()) {
			confirmacion(`${host_url}/${controller}/Insert`, $('#formulario')[0]).then((response1) => {
				if (response1) {
					POST(response1[0], response1[1]).then((res) => {
						if (res.status == 200) {
							reloadCatalogo();
							ShowCodigo_incrementado(`${host_url}/${controller}`, document.formulario.Cod);
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
});

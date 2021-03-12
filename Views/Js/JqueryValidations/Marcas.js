$(document).ready(() => {
	let catalogo;
	
	if($('#catalogo_table').is(":visible")){
		catalogo = 'catalogo_table';
	}else{
		catalogo = 'catalogo_table2';
	}
	`marcas.mar_cod,marcas.mar_des,marcas.mar_estado,categoria.cat_des`
	$(`#${catalogo}`).DataTable({
    responsive: true, lengthChange: true, autoWidth: true,
    ajax:{
      url: Paginador_url,
      dataSrc: 'data',
    },
    columns:[
      {data: 'mar_cod'},
      {data: 'mar_des'},
      {data: 'cat_des'},
      {data: 'mar_estado', render: function(data){ return (data == 1) ? 'Activo': 'Innactivo'; }},
      {defaultContent: "",
      render: function(data, type, row, meta){
        let estado = (row.mar_estado == 0) ? 'disabled': '';
        let title_edit = (row.mar_estado == 0) ? 'Esta Marca no puede ser modificada': 'Modificar';
        let title_desac = (row.mar_estado == 0) ? 'Activar':'Desactivar';
        let clase = (row.mar_estado == 0) ? 'danger':'success';
        let btn = `
          <form name="form-del-${row.mar_cod}" id="form-del-${row.mar_cod}">
            <input type="hidden" name="Cod" value="${row.mar_cod}">
          </form>
          <div class='btn-group'>
            <button class="btn btn-sm btn-info" id="btn-edit" onclick="Consulta(this)" data-codigo="${row.mar_cod}"
              data-toggle="modal" data-target="#ModalEdit" ${estado} title="${title_edit}">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-${clase}" onclick="bDelet(this);" id="bDelete" data-form="form-del-${row.mar_cod}" 
            data-dismiss="modal" title="${title_desac}">
              <i class="fas fa-power-off"></i>
            </button>
            <button class="btn btn-sm btn-default" data-control="${controller}" onclick="bConsul(this);" data-codigo="${row.mar_cod}"
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
			Marca: {
				required: true,
				minlength: 2,
				maxlength: 30,
			},
			Tip: {
				required: true,
			}
		},
		messages: {
			Marca: {
				required: 'Debe ingresar el nombre de la marca',
				minlength: 'Debe de ingresar al menos 2 caracteres',
				maxlength: 'No puede ingresar mas de 30 caracteres',
				pattern: 'Este campo solo acepta letras',
			},
			Tip: {
				required: 'Debe de seleccionar una categoria',
			}
		}
	});

	$('#formulario').validate({
		rules: {
			Marca: {
				required: true,
				minlength: 2,
				maxlength: 30,
			},
			Tip: {
				required: true,
			}
		},
		messages: {
			Marca: {
				required: 'Debe ingresar el nombre de la marca',
				minlength: 'Debe de ingresar al menos 2 caracteres',
				maxlength: 'No puede ingresar mas de 30 caracteres',
				pattern: 'Este campo solo acepta letras',
			},
			Tip: {
				required: 'Debe de seleccionar una categoria',
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
